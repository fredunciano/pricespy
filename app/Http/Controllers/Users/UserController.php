<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use App\Permission;
use App\User;
use App\VerifyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subUsers = User::where('is_sub', 1)->where('main_user_id', auth()->user()->user_id)->with('verification')->with('permissions')->get();
        return view('users.index', compact('subUsers'));
    }

    public function logoutAndVerify($token)
    {
        auth()->logout();
        return redirect('/user/verify/' . $token);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        // create user
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->is_sub = true;
        $user->main_user_id = auth()->user()->user_id;
        $user->after_tax_prices = auth()->user()->after_tax_prices;
        $user->equality_percent = auth()->user()->equality_percent;
        $user->company = auth()->user()->company;
        $user->save();

        // creating permissions
        $permission = new Permission();
        $permission->user_id = $user->id;
        $permission->add_product = $request->has('add_product');
        $permission->edit_product = $request->has('edit_product');
        $permission->delete_product = $request->has('delete_product');
        $permission->add_new_sub_user = $request->has('add_new_sub_user');
        $permission->add_competitor = $request->has('add_competitor');
        $permission->edit_competitor = $request->has('edit_competitor');
        $permission->delete_competitor = $request->has('delete_competitor');
        $permission->view_invoice_and_payment_system = $request->has('view_invoice_and_payment_system');
        $permission->save();

        // creating verify token
        VerifyUser::create([
            'user_id' => $user->id,
            'token' => time() . str_random(40)
        ]);

        if ($request->has('send_email_notification')) {
            Mail::to($user->email)->send(new VerifyMail($user));
        }

        return redirect('users')->with('success', 'new_user_created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userData = User::where('id', $id)->with('permissions')->first();
        return view('users.show', compact('userData'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userData = User::where('id', $id)->with('permissions')->first();
        return view('users.edit', compact('userData'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // update user
        $user = User::find($id);
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->save();

        // update permissions
        $permission = Permission::find($request->input('permission_id'));
        $permission->user_id = $id;
        $permission->add_product = $request->has('add_product');
        $permission->edit_product = $request->has('edit_product');
        $permission->delete_product = $request->has('delete_product');
        $permission->add_new_sub_user = $request->has('add_new_sub_user');
        $permission->add_competitor = $request->has('add_competitor');
        $permission->edit_competitor = $request->has('edit_competitor');
        $permission->delete_competitor = $request->has('delete_competitor');
        $permission->view_invoice_and_payment_system = $request->has('view_invoice_and_payment_system');
        $permission->save();

        return redirect('users')->with('success', 'user_info_updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            \DB::beginTransaction();
            Permission::where('user_id', $id)->delete();
            User::destroy($id);
            \DB::commit();
            $notification = ['success' => 'user_info_deleted'];
        } catch (\Exception $exception) {
            \DB::rollback();
            $notification = ['error' => 'something_went_wrong'];
        }

        return back()->with($notification);
    }
}
