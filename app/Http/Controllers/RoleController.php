<?php

namespace App\Http\Controllers;


use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RoleController extends MainController
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
        $role = new Role();
        $roles = $role->getAllRoles();
        return view('backend.role.create', [
            'roles' => $roles,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
        $checkUrl = parent::checkUrl($request);
        $validation = Validator::make($request->all(), [
            'role_title' => ['required', 'string','unique:roles'],
            'role_description' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            switch ($checkUrl) {
                case true :
                    return response()->json([
                        'error' => 500,
                        'messages' => $validation->errors()
                    ]);
                    break;
                case false :
                    return Redirect::route('role.create')->withErrors($validation);
            }
        }

        $role = new Role();
        if ($role->createRole($request)) {
            if ($checkUrl)
                return response()->json([
                    'status' => 'success',
                ]);

            $request->session()->flash('alert-success', 'Role was successful added!');
            return \redirect()->route('role.create');
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
        $role = Role::find($id);
        return view('backend.role.view', [
            'role' => $role,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $role = Role::find($id);
        return view('backend.role.edit',[
            'role' => $role,
            'userAuthPermission' => $this->getUserPermissionns($request),
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
        $checkUrl = parent::checkUrl($request);

        $validation = Validator::make($request->all(), [
            'role_title' => ['required', 'string', Rule::unique('roles')->ignore($id, 'id')],
            'role_description' => ['required', 'string'],
        ]);


        if ($validation->fails()) {
            switch ($checkUrl) {
                case true :
                    return response()->json([
                        'error' => 500,
                        'messages' => $validation->errors()
                    ]);
                    break;
                case false :
                    return Redirect::back()->withErrors($validation);
            }
        }

        $role = new Role();
        if ($role->updateRole($id, $request)) {
            if ($checkUrl)
                return response()->json([
                    'status' => 'success',
                ]);

            $request->session()->flash('alert-update', 'Role was successful updated!');
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
        if (Role::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Role was successful deleted!');
            return \redirect()->route('role.create');
        }
    }
}
