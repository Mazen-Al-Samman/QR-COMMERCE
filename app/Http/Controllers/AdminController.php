<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Invoice;
use App\Models\QuickResponseCode;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AdminController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $total_vendors = Vendor::getVendorsCount();
        $total_active_vendors = Vendor::getActiveVendorsCount();
        $total_disabled_vendors = Vendor::getDisabledVendorsCount();
        $total_users = User::getUsersCount();
        $total_verified_users = User::getVerifiedUsersCount();
        $total_not_verified_users = User::getNotVerifiedUsersCount();
        $total_invoices = Invoice::getInvoicesCount();
        $total_qr_scan = QuickResponseCode::getCount();
        $total_android_scan = QuickResponseCode::getCountByAndriod();
        $total_ios_scan = QuickResponseCode::getCountByIos();
        $qr_daily = QuickResponseCode::getDailyQrScan();
        $qr_weekly = QuickResponseCode::getWeeklyQrScan();
        $qr_monthly = QuickResponseCode::getMonthlyQrScan();
        $qr_yearly = QuickResponseCode::getYearlyQrScan();
        return view('backend.home',[
            'total_invoices' => $total_invoices,
            'total_vendors' => $total_vendors,
            'total_active_vendors' => $total_active_vendors,
            'total_disabled_vendors' => $total_disabled_vendors,
            'total_users' => $total_users,
            'total_verified_users' => $total_verified_users,
            'total_not_verified_users' => $total_not_verified_users,
            'total_qr_scan' => $total_qr_scan,
            'total_android_scan' => $total_android_scan,
            'total_ios_scan' => $total_ios_scan,
            'qr_daily' => $qr_daily,
            'qr_weekly' => $qr_weekly,
            'qr_monthly' => $qr_monthly,
            'qr_yearly' => $qr_yearly,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $admin = new Admin();
        $role = new Role();
        $admins = $admin->getAllAdmins();
        $roles = $role->getAllRoles();
        return view('backend.admin.create', [
            'admins' => $admins,
            'roles' => $roles,
            'userAuthPermission' => $this->getUserPermissionns($request)
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
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/', 'unique:admins'],
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
            'admin' => $admin,
            'userAuthPermission' => $this->getUserPermissionns($request)
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
        $admin = Admin::find($id);
        $role = new Role();
        $roles = $role->getAllRoles();
        return view('backend.admin.edit', [
            'admin' => $admin,
            'roles' => $roles,
            'userAuthPermission' => $this->getUserPermissionns($request)
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
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/', Rule::unique('admins')->ignore($id, 'id')],
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
