<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BannerController extends MainController
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
        $banner = new Banner();
        $banners = $banner->getAllBanners();
        $vendors = Vendor::getAllVendors();
        return view('backend.banner.create', [
            'banner' => $banner,
            'banners' => $banners,
            'vendors' => $vendors,
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
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
//            'image' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('banner.create')->withErrors($validation);
        }

        $banner = new Banner();
        if ($banner->createBanner($request)) {
            $request->session()->flash('success', 'Banner was successful added!');
            return \redirect()->route('banner.create');
        }

        return new \Exception('an error occurred');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $banner = Banner::find($id);

        return view('backend.banner.view', [
            'banner' => $banner,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id, Request $request)
    {
        $banner = Banner::find($id);
        $vendors = Vendor::getAllVendors();
        return view('backend.banner.edit', [
            'banner' => $banner,
            'vendors' => $vendors,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Exception|\Illuminate\Http\RedirectResponse
     */
    public function update($id,Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required', 'string'],
            'body' => ['required', 'string'],
//            'image' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $banner = new Banner();
        if ($banner->updateBanner($id, $request)) {
            $request->session()->flash('alert-update', 'Category was successful updated!');
            return Redirect::back();
        }

        return new \Exception('an error occurred');
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        if (Banner::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Banner was successful deleted!');
            return \redirect()->route('banner.create');
        }
        return new \Exception('an error occurred');
    }

    public function bannersApi() {

        $banners = Banner::BannersSliderApi();

        return response()->json([
            'status' => true,
            'data' => $banners
        ]);
    }
}
