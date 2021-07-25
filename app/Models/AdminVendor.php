<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
}
