<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Vendor extends Model
{
    use HasFactory;
    const ROLE_PREFIX = 'vendor';

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';
    const STATUS_PENDING = 'pending';
    const STATUS_BLOCKED = 'blocked';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'status',
        'name',
        'country',
        'city',
        'is_featured',
        'subscribe',
        'phone',
        'start_subscription',
        'end_subscription'
    ];

    public function category()
    {
        return $this->hasMany(Category::class);
    }

    public function vendorAdmin() {
        return $this->hasMany(AdminVendor::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function getAllVendorsList() {
        return Vendor::orderBy('created_at', 'desc')->orderBy('end_subscription', 'desc')->paginate(15);
    }

    public static function getAllVendors()
    {
        return Vendor::where('end_subscription', '>', date('Y-m-d'))->paginate(15);
    }

    public static function getActiveVendorsCount()
    {
        return Vendor::where('end_subscription', '>', date('Y-m-d'))->count();
    }

    public static function getDisabledVendorsCount()
    {
        return Vendor::where('end_subscription', '<', date('Y-m-d'))->count();
    }

    public static function getVendorsCount()
    {
        return Vendor::all()->count();
    }

    public function getvendorStatusList() {
        return [
            self::STATUS_ACTIVE => self::STATUS_ACTIVE,
            self::STATUS_PENDING => self::STATUS_PENDING,
            self::STATUS_BLOCKED => self::STATUS_BLOCKED,
        ];
    }

    public function createVendor($request)
    {
        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->country = $request->country;
        $vendor->city = $request->city;
        $vendor->subscribe = $this->generateRandomString(20);
        $vendor->start_subscription = date("Y-m-d");
        $vendor->end_subscription = date('Y-m-d', strtotime("+1 months", strtotime("NOW")));
        if(isset($request->is_featured)) {
            $vendor->is_featured = 1;
        }

        if(isset($request->active)) {
            $vendor->status = self::STATUS_ACTIVE;
        }

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/vendors/", $name);
            $vendor->image = $name;
        }
        if ($vendor->save()) {
            $adminVendor = new AdminVendor();
            $request->username = $request->name;
            $request->role_id = Role::VENDOR;
            return $adminVendor->createAdmin($request, $vendor->id, true);
        }
        return false;
    }

    public function updateVendor($id, $request)
    {
        $vendor = self::find($id);
        $vendor->name = $request->name;
        $vendor->phone = $request->phone;
        $vendor->country = $request->country;
        $vendor->city = $request->city;
        if (isset($request->is_featured)) {
            $vendor->is_featured = 1;
        } else {
            $vendor->is_featured = 0;
        }

        if(isset($request->active)) {
            $vendor->status = self::STATUS_ACTIVE;
        }else {
            $vendor->status = self::STATUS_PENDING;
        }

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/vendors/", $name);
            $vendor->image = $name;
        }
        if(!$vendor->save()) {
            return false;
        }

        if($request->has('password')) {
            AdminVendor::where(['vendor_id' => $id, 'is_main_vendor' => 1])->update([
                'password' => Hash::make($request->password)
            ]);
        }
        return true;
    }

    public function getAllVendorsApi()
    {
        $vendors =  Vendor::all()
        ->where('end_subscription', '>', date('Y-m-d'))->groupBy('country');
        $list = [];
        foreach ($vendors as $vendor => $value) {
            $title = $vendor;

            foreach($value as $val) {
                $data [] = $val;
            }

            $list [] = [
                'title' => $title,
                'data' => $data
            ];

            $data = [];
        }

        return $list;

    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
