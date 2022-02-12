<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $users = User::getAllUsers();
        $statusList = User::userStatusList();
        return view('backend.user.create', [
            'users' => $users,
            'statusList' => $statusList,
            'userAuthPermission' => $this->getUserPermissionns($request)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => ['required', 'string'],
            'last_name' => ['required'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/', 'unique:users'],
            'image' => ['file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('user.create')->withErrors($validation);
        }

        $user = new User();
        if ($user->createUser($request)) {
            $request->session()->flash('success', 'User was successful added!');
            return \redirect()->route('user.create');
        }

        return new \Exception('an error occurred');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $user = User::find($id);
        return view('backend.user.view', [
            'user' => $user,
            'userAuthPermission' => $this->getUserPermissionns($request)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $user = User::find($id);
        return view('backend.user.edit', [
            'user' => $user,
            'userAuthPermission' => $this->getUserPermissionns($request)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'first_name' => ['required', 'string', Rule::unique('users')->ignore($id, 'id')],
            'last_name' => ['required', 'string', Rule::unique('users')->ignore($id, 'id')],
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/', Rule::unique('users')->ignore($id, 'id')],
            'image' => ['file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $user = new User();
        if ($user->updateUser($id, $request)) {
            $request->session()->flash('update', 'User was successful updated!');
            return Redirect::back();
        }

        return new \Exception('an error occurred');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (User::find($id)->delete()) {
            $request->session()->flash('delete', 'User was successful deleted!');
            return \redirect()->route('user.create');
        }
    }
}
