<?php

namespace App\Http\Controllers;

use App\Country;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilesController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $countries = Country::all();
        return view('profiles.edit', compact( 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ($request->input('current_password') != null && !(Hash::check($request->input('current_password'), auth()->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }
        if ($request->input('current_password') != null && strcmp($request->input('current_password'), $request->input('password')) == 0) {
            //Current password and new password are same
            return redirect()->back()->with("error", "New Password cannot be same as your current password. Please choose a different password.");
        }

        $request->validate([
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'email' => 'required|email',
            'company' => 'required|min:2|max:100',
            'avatar' => 'nullable|image|max:400',
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|required_with:current_password',
            'password_confirmation' => 'nullable|required_with:password|same:password',
        ], [
            'current_password.required_with' => t('please_enter_current_password'),
            'password.required_with' => t('please_enter_new_password'),
            'password_confirmation.required_with' => t('please_enter_conf_password'),
        ]);
        $data = $request->input();
        if ($request->has('avatar')) {
            $data['avatar'] = User::saveFile($request->file('avatar'), 'users/avatars', auth()->user()->avatar);
        } elseif ($request->has('delete-avatar')) {
            User::deleteFile(auth()->user()->avatar);
            $data['avatar'] = null;
        }
        if ($request->input('password') == null) {
            $toRemove = array("password", 'current_password', 'password_confirmation');
            $data = array_diff_key($data, array_flip($toRemove));
        } else {
            $data['password'] = bcrypt($request->input('password'));
        }
        auth()->user()->update($data);
        return back()->with('success', 'changes_saved')->withInput($data);
    }

}
