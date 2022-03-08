<?php

namespace App\Http\Controllers;

use App\Models\MyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyReportController extends Controller
{

    public function showApi()
    {

        $my_reports = MyReport::getMyReports(auth('api')->user()->id);
        if (count($my_reports) > 0) {
            return response()->json([
                'status' => true,
                'data' => $my_reports
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => 'there is no data'
        ]);
    }

    public function storeApi(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required'],
            'image' => ['required'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        if (MyReport::storeMyReportApi($request)) {
            return response()->json([
                'status' => true,
                'message' => 'Report was successful saved!'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Something wrong!'
        ]);
    }

    public function deleteApi($id)
    {
        if (MyReport::deleteReportApi($id)) {
            return response()->json([
                'status' => true,
                'message' => 'Report was successful deleted!'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Something wrong'
        ]);
    }

    public function updateApi(Request $request) {
        $validation = Validator::make($request->all(), [
            'id' => ['required'],
            'title' => ['required'],
            'guarantee' => ['required'],
            'payment_date' => ['required'],
            'reminder' => ['required']
        ]);
        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }
        $report =  MyReport::updateReportByID($request);
        if($report) {
            return response()->json([
                'status' => true,
                'message' => "Report was successful Updated"
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "Something wrong !!"
        ]);
    }

    public function viewReportById($id) {

        $report = MyReport::getReportById($id);
        if($report) {
            return response()->json([
                'status' => true,
                'data' => $report
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => []
        ]);

    }

    public function reportsDateFilter($year, $month = null)
    {
        $my_reports = MyReport::filterByDate($year, $month);
        return response()->json([
            'status' => true,
            'data' => $my_reports
        ]);
    }
}
