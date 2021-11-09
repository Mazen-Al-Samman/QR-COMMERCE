<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AdminVendor extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'vendor_id'
    ];

    public function role(){
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function vendor(){
        return $this->hasOne(Vendor::class,'id','vendor_id');
    }

    public function getAllAdmins($vendor_id){
        return self::where(['vendor_id' => $vendor_id])->get();
    }

    public function createAdmin($request, $vendor_id)
    {
        $admin = new AdminVendor();
        $admin->name = $request->username;
        $admin->email = $request->email;
        $admin->password = Hash::make($request->password);
        $admin->phone = $request->phone;
        $admin->role_id = $request->role_id ;
        $admin->vendor_id = $vendor_id;
        return $admin->save();
    }

    public function updateAdmin($id,$request)
    {
        $admin = self::find($id);
        $admin->name = $request->username;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->role_id = $request->role_id ;
        return $admin->save();
    }
}
