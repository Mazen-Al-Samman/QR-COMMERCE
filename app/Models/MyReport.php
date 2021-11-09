<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyReport extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'guarantee',
        'payment_date',
        'reminder',
        'image'
    ];

    public static function getMyReports($id)
    {
        if($id)
            return MyReport::where(['user_id' => $id])->get();

        return false;
    }

    public static function storeMyReportApi($request)
    {
        $report = new MyReport();
        $report->title = $request->title;
        $report->guarantee = $request->guarantee;
        $report->payment_date = $request->payment_date;
        $report->reminder = $request->reminder;
        $report->user_id = auth('api')->user()->id;

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/MyReports/", $name);
            $report->image = $name;
        }
        return $report->save();
    }

    public static function deleteReportApi($request)
    {
        return MyReport::where(['id' => $request->id])->delete();
    }

}
