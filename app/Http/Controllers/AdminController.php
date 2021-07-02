<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
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
        return view('backend.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $request->fullUrl();
        preg_match('/\/api\//',$url,$matches);
        
        if(count($matches) > 0){
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|unique:admins',
                'email' => 'required|email|unique:admins',
                'phone' => 'required|numeric|unique:admins',
                'password' => 'required|string|confirmed',
            ]);
            if($validator->fails()){
                $response['response'] = $validator->messages();
            }
            return $response;
        }

        $request->validate([
            'username'=>['required','string','unique:admins'],
            'email'=>['required','email','unique:admins'],
            'phone'=>['required','numeric','unique:admins'],
            'password'=>['required','string','confirmed'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
