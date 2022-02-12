<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class VendorsController extends MainController
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
        $vendorModel = new Vendor();
        $vendors = $vendorModel->getAllVendorsList();
        $path = storage_path() . "/app/public/json_files/jordanian_cities.json";
        $jordanian_cities = json_encode(file_get_contents($path));
        $vendor_status_list = $vendorModel->getVendorStatusList();
        return view('backend.vendor.create', [
            'vendors' => $vendors,
            'jordanian_cities' => $jordanian_cities,
            'userAuthPermission' => $this->getUserPermissionns($request),
            'defaultCountry' => 'Jordan',
            'statusList' => $vendor_status_list,
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
            'name' => ['required', 'string', 'unique:vendors'],
            'phone' => ['required', 'numeric', 'unique:vendors', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:admin_vendors'],
            'password' => ['required', 'string', 'confirmed'],
            'image' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('vendor.create')->withErrors($validation);
        }

        $vendorModel = new Vendor();
        if ($vendorModel->createVendor($request)) {
            $request->session()->flash('success', 'Vendor was successful added!');
            return \redirect()->route('vendor.create');
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
        $vendor = Vendor::find($id);
        return view('backend.vendor.view', [
            'vendor' => $vendor,
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
        $vendor = Vendor::find($id);
        $path = storage_path() . "/app/public/json_files/jordanian_cities.json";
        $jordanian_cities = json_encode(file_get_contents($path));
        return view('backend.vendor.edit', [
            'vendor' => $vendor,
            'jordanian_cities' => $jordanian_cities,
            'userAuthPermission' => $this->getUserPermissionns($request),
            'defaultCountry' => $vendor->country,
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
            'name' => ['required', 'string', Rule::unique('vendors')->ignore($id, 'id')],
            'phone' => ['required', 'numeric', 'unique:admins', 'regex:(^[07][7|8|9][0-9]{8})'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'image' => ['file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
            'password' => ['sometimes', 'confirmed'],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $vendor = new Vendor();
        if ($vendor->updateVendor($id, $request)) {
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
        if (Vendor::find($id)->delete()) {
            $request->session()->flash('delete', 'User was successful deleted!');
            return \redirect()->route('vendor.create');
        }
    }

    public function vendorsApi()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            $vendor = new Vendor();
            $vendors = $vendor->getAllVendorsApi();

            return response()->json([
                'status' => true,
                'data' => [$vendors]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }

    public function featuredVendorsSliders()
    {
        $vendors =  Vendor::where(['is_featured' => 1])->select(['id', 'image', 'name'])->get();
        return response()->json([
            'status' => true,
            'data' => $vendors
        ]);
    }
}
