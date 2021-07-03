<?php

namespace App\Http\Controllers;

use App\Models\Admin;
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
        return view('backend.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin = new Admin();
        $admins = $admin->getAllAdmins();
        return view('backend.admin.create', [
            'admins' => $admins
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
            'username' => ['required', 'string', 'unique:admins'],
            'email' => ['required', 'email', 'unique:admins'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'numeric', 'unique:admins'],
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
                    return Redirect::route('admin.create')->withErrors($validation);
            }
        }

        $admin = new Admin();
        if ($admin->createAdmin($request)) {
            if ($checkUrl)
                return response()->json([
                    'status' => 'success',
                ]);

            $request->session()->flash('success', 'User was successful added!');
            return view('backend.admin.create');
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
        //
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
        return view('backend.admin.edit', [
            'admin' => $admin
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
        $data = Admin::find($id);
        $checkUrl = parent::checkUrl($request);
        $validation = Validator::make($request->all(), [
            'username' => ['required', 'string', Rule::unique('admins')->ignore($id, 'id')],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($id, 'id')],
            'phone' => ['required', 'numeric', Rule::unique('admins')->ignore($id, 'id')],
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
//
//                    return view('backend.admin.edit', [
//                        'admin' => $data
//                    ])->withErrors($validation);
            }
        }

        $admin = new Admin();
        if ($admin->updateAdmin($id, $request)) {
            if ($checkUrl)
                return response()->json([
                    'status' => 'success',
                ]);

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
    public function destroy($id)
    {
        //
    }
}
