<?php

namespace App\Http\Controllers;


use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PermissionController extends MainController
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $permission = new Permission();
        $permissions = $permission->getAllPermissions();
        return view('backend.permission.create', [
            'permissions' => $permissions,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
            'permission' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('permission.create')->withErrors($validation);
        }

        $admin = new Permission();
        if ($admin->createPermission($request)) {
            $request->session()->flash('alert-success', 'Permission was successful added!');
            return \redirect()->route('permission.create');
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
        $permission = Permission::find($id);

        return view('backend.permission.view', [
            'permission' => $permission,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
        $permission = Permission::find($id);
        return view('backend.permission.edit', [
            'permission' => $permission,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
            'permission' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $permission = new Permission();
        if ($permission->updatePermission($id, $request)) {
            $request->session()->flash('alert-update', 'Permission was successful updated!');
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
    public function destroy($id,Request $request)
    {
        if (Permission::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Permission was successful deleted!');
            return \redirect()->route('permission.create');
        }
    }
}
