<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class VendorsController extends Controller
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
    public function create()
    {
        $vendorModel = new Vendor();
        $vendors = $vendorModel->getAllVendors();
        $path = storage_path() . "/app/public/json_files/jordanian_cities.json";
        $jordanian_cities = json_decode(file_get_contents($path), true);
        return view('backend.vendor.create', [
            'vendors' => $vendors,
            'jordanian_cities' => $jordanian_cities,
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
            'phone' => ['required', 'numeric', 'unique:admins', 'regex:(^[07][7|8|9][0-9]{8})'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
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
    public function show($id)
    {
        $vendor = Vendor::find($id);
        return view('backend.vendor.view', [
            'vendor' => $vendor
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
        $vendor = Vendor::find($id);
        $path = storage_path() . "/app/public/json_files/jordanian_cities.json";
        $jordanian_cities = json_decode(file_get_contents($path), true);
        return view('backend.vendor.edit', [
            'vendor' => $vendor,
            'jordanian_cities' => $jordanian_cities,
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
        ]);

        if ($validation->fails()) {
            return Redirect::route('vendor.create')->withErrors($validation);
        }

        $vendor = new Vendor();
        if ($vendor->updateVendor($id, $request)) {
            $request->session()->flash('update', 'User was successful updated!');
            return Redirect::route('vendor.create')->withErrors($validation);
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
                'data' => $vendors
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ]);
        }
    }
}
