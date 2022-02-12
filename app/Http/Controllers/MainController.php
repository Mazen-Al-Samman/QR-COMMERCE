<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Twilio\Rest\Client;

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

    public function profile(Request $request)
    {
        if (\auth()->user()) {
            return view('backend.auth.profile', ['userAuthPermission' => $this->getUserPermissionns($request),]);
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
            'phone' => ['required', 'min:10', 'max:15', 'regex:/(^(079|078|077)[0-9]{7})|(^(05|01|10)[0-9]{8})$/', Rule::unique('admins')->ignore(Auth::user()->id, 'id')],
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
        if(!empty($permissions)) {
            $subset = $permissions->map(function ($permissions) {
                return collect($permissions->toArray())
                    ->only(['permission'])
                    ->all();
            });
            $arr = [];
            foreach ($subset as $item) {
                $arr[] = $item['permission'];
            }
            return $arr;
        }
        return [];
    }

    public function noPermissions(Request $request) {
        $userPermissions = $this->getUserPermissionns($request);
        if (count($userPermissions) != 0) {
            abort(404);
        }
        return view('no_permissions', [
            'userAuthPermission' => $userPermissions,
        ]);
    }

    public function expired(Request $request) {
        $userPermissions = $this->getUserPermissionns($request);
        return view('expired',[
            'userAuthPermission' => $userPermissions,
        ]);
    }
}
