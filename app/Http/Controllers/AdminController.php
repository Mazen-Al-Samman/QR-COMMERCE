<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Url;
use Psy\Util\Json;

class AdminController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.home',[
            'test' => 75
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = new Admin();
        $role = new Role();
        $admins = $admin->getAllAdmins();
        $roles = $role->getAllRoles();
        return view('backend.admin.create', [
            'admins' => $admins,
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'username' => ['required', 'string', 'unique:admins'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'numeric', 'unique:admins'],
            'role_id' => ['required', 'numeric'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('admin.create')->withErrors($validation);
        }

        $admin = new Admin();
        if ($admin->createAdmin($request)) {
            $request->session()->flash('success', 'User was successful added!');
            return \redirect()->route('admin.create');
        }

        return new \Exception('an error occurred');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $admin = Admin::find($id);

        return view('backend.admin.view', [
            'admin' => $admin
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        $role = new Role();
        $roles = $role->getAllRoles();
        return view('backend.admin.edit', [
            'admin' => $admin,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'username' => ['required', 'string', Rule::unique('admins')->ignore($id, 'id')],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($id, 'id')],
            'phone' => ['required', 'numeric', Rule::unique('admins')->ignore($id, 'id')],
        ]);

        if ($validation->fails()) {
                    return Redirect::back()->withErrors($validation);
        }

        $admin = new Admin();
        if ($admin->updateAdmin($id, $request)) {
            $request->session()->flash('update', 'User was successful updated!');
            return Redirect::back();
        }

        return new \Exception('an error occurred');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (Admin::find($id)->delete()) {
            $request->session()->flash('delete', 'User was successful deleted!');
            return \redirect()->route('admin.create');
        }
    }
}
