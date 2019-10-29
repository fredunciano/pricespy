<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\VerifyUser;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        $verifyUser = VerifyUser::where('token', $request->input('token'))->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            $user->password = bcrypt($request->input('password'));
            $user->save();
            auth()->login($user);
            VerifyUser::where('user_id', auth()->user()->id)->delete();

            return redirect('/');
        } else {
            $token = $request->token;
            return view('auth.passwords.set', compact('token'))->with('warning', "Sorry your email cannot be identified.");
        }
    }
}
