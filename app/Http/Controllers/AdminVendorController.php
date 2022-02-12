<?php

namespace App\Http\Controllers;

use App\Models\AdminVendor;
use App\Models\Invoice;
use App\Models\QuickResponseCode;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminVendorController extends MainController
{
    public function index(Request $request) {
        if (empty(auth('vendor')->user()->vendor_id)) {
            abort(404);
        }

        $vendor_id = auth('vendor')->user()->vendor_id;
        $vendorModel = Vendor::where(['id' => $vendor_id])->first();
        if (!$vendorModel) {
            abort(404);
        }
        return view('backend.dashboard', ['userAuthPermission' => $this->getUserPermissionns($request), 'model' => $vendorModel]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin = new AdminVendor();
        $role = new Role();
        $admins = $admin->getAllAdmins($this->getLoggedInVendorId());
        $roles = $role->getAllVendorRoles();
        return view('backend.admin-vendor.create', [
            'admins' => $admins,
            'roles' => $roles,
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
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/'],
            'role_id' => ['required', 'numeric'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('admin-vendor.create')->withErrors($validation);
        }

        $admin = new AdminVendor();
        $vendor_id = Auth::guard('vendor')->user()->vendor_id;
        if ($admin->createAdmin($request, $vendor_id)) {
            $request->session()->flash('success', 'Admin was successful added!');
            return \redirect()->route('admin-vendor.create');
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
        $admin = AdminVendor::find($id);
        if (!$admin || $admin->vendor_id != Auth::guard('vendor')->user()->vendor_id) {
            return \redirect()->route('admin-vendor.create');
        }

        return view('backend.admin-vendor.view', [
            'admin' => $admin,
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
        $admin = AdminVendor::find($id);
        $role = new Role();
        $roles = $role->getAllVendorRoles();
        return view('backend.admin-vendor.edit', [
            'admin' => $admin,
            'roles' => $roles,
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
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['nullable','string', 'confirmed'],
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/'],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $admin = new AdminVendor();
        if ($admin->updateAdmin($id, $request)) {
            $request->session()->flash('update', 'Admin was successful updated!');
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
        if (AdminVendor::find($id)->delete()) {
            $request->session()->flash('delete', 'Admin was successful deleted!');
            return \redirect()->route('admin-vendor.create');
        }
    }

    public function getLoggedInVendorId() {
        return Auth::guard('vendor')->user()->vendor_id ?? -1;
    }
}
