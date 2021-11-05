<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuickResponseCode extends Model
{
    use HasFactory;
    const ANDROID = 'android';
    const IOS = 'ios';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_type',
        'invoice_id',
        'user_id'

    ];

    public static function getCount()
    {
        return QuickResponseCode::all()->count();
    }

    public static function getCountByAndriod()
    {
        return QuickResponseCode::where(['device_type' => self::ANDROID])->count();
    }

    public static function getCountByIos()
    {
        return QuickResponseCode::where(['device_type' => self::IOS])->count();
    }

    public static function getDailyQrScan()
    {
        return QuickResponseCode::whereDay('created_at', '=', date('d'))->count();
    }

    public static function getWeeklyQrScan()
    {
        return QuickResponseCode::whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->count();
    }

    public static function getMonthlyQrScan()
    {
        return QuickResponseCode::whereMonth('created_at', date('m'))->WhereYear('created_at',date('Y'))->count();
    }

    public static function getYearlyQrScan()
    {
        return QuickResponseCode::whereYear('created_at',date('Y'))->count();
    }

    public static function storeQrScan($request)
    {
        $qr = new QuickResponseCode();
        $qr->device_type = $request->device_type;
        $qr->invoice_id = $request->invoice_id;
        $qr->user_id = auth('api')->user()->id;
        return $qr->save();
    }
}
