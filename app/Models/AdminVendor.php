<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class AdminVendor extends Authenticatable
{
    const ROLE_PREFIX = 'admin-vendor';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_main_vendor',
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

    public function createAdmin($request, $vendor_id, $is_main_vendor = false)
    {
        $admin = new AdminVendor();

        if($is_main_vendor)
            $admin->is_main_vendor = 1;

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
        if($request->password)
            $admin->password = Hash::make($request->password);
        return $admin->save();
    }
}
