<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MainController extends Controller
{

    public $url;
    public $request;
    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->url = $this->checkUrl(new Request());
    }

    public function checkUrl(Request $request){
        $url = $request->fullUrl();
        preg_match('/\/api\//',$url,$matches);
        return count($matches) > 0;
    }

    public function profile()
    {
        if (\auth()->user()) {
            return view('backend.auth.profile');
        }
        return redirect()->route('login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => ['required', 'string', Rule::unique('admins')->ignore(Auth::user()->id, 'id')],
            'email' => ['required', 'email', Rule::unique('admins')->ignore(Auth::user()->id, 'id')],
            'phone' => ['required', 'min:10', 'max:15', 'regex:/^(079|078|077)[0-9]{7}$/', Rule::unique('admins')->ignore(Auth::user()->id, 'id')],
        ]);

        if ($validation->fails()) {
            return Redirect::back()->withErrors($validation);
        }

        $update = Admin::find(Auth::user()->id);
        $update->username = $request->username;
        $update->email = $request->email;
        $update->phone = $request->phone;
        $update->save();

            $request->session()->flash('update', 'User was successful updated!');
            return Redirect::back();


        return new \Exception('an error occurred');
    }

    public function getUserPermissionns($request) {
        $permissions = $request->get('permissions');
        $subset = $permissions->map(function ($permissions) {
            return collect($permissions->toArray())
                ->only(['permission'])
                ->all();
        });
        $arr = [];
        foreach ($subset as $item) {
            $arr[]= $item['permission'];
        }
        return $arr;
    }
}
