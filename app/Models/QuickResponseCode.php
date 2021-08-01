<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class QuickResponseCode extends Model
{
    use HasFactory;

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

    public static function storeQrScan($request)
    {
        $qr = new QuickResponseCode();
        $qr->device_type = $request->device_type;
        $qr->invoice_id = $request->invoice_id;
        $qr->user_id = auth('api')->user()->id;
        return $qr->save();
    }
}
