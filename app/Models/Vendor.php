<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'country',
        'city',
        'subscribe',
        'phone',
        'start_subscription',
        'end_subscription'
    ];

    public static function getAllVendors() {
        return Vendor::where('end_subscription', '>', date('Y-m-d'))->get();
    }

    public function createVendor($request) {
        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->country = $request->country;
        $vendor->city = $request->city;
        return $vendor->save();
    }

    public function updateVendor($id, $request) {
        $vendor = self::find($id);
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->country = $request->country;
        $vendor->city = $request->city;
        return $vendor->save();
    }
}
