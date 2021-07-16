<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'role_id'
    ];

    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function createAdmin($request)
    {
        $admin = new Admin();
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->phone = $request->phone;
        $admin->role_id = $request->role_id ;
        return $admin->save();
    }

    public function updateAdmin($id,$request)
    {
        $admin = Admin::find($id);
        $admin->username = $request->username;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->role_id = $request->role_id ;
        return $admin->save();
    }

    public function getAllAdmins(){
        return Admin::where([
            'active' => 1
        ])->paginate(15);
    }
}
