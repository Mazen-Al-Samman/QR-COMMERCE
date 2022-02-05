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

    public static function deleteReportApi($id)
    {
        return MyReport::where(['id' => $id, ''])->delete();
    }

    public static function updateReportByID($request) {
        $data = [
            'title' => $request->title,
            'guarantee' => $request->guarantee,
            'payment_date' => $request->payment_date,
            'reminder' => $request->reminder,
        ];
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/MyReports/", $name);
            $data = array_merge($data,['image' => $name]);
        }
        return self::where(['id' => $request->id])->update($data);

    }

    public static function getReportById($id) {
        return self::where(['id' => $id])->get();
    }

    public static function filterByDate($year, $month)
    {
        return self::where(['user_id' => auth('api')->user()->id])
            ->whereYear('created_at', $year)
            ->when($month, function ($q, $v) use ($month) {
                $q->whereMonth('created_at', $month);
            })->get();
    }
}
