<?php

namespace App\Http\Controllers;

use App\Models\MyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MyReportController extends Controller
{
    public function storeApi(Request $request)
    {
        $validation = Validator::make($request->all(), [
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

    public function deleteApi(Request $request)
    {
        if (MyReport::deleteReportApi($request)) {
            return response()->json([
                'status' => false,
                'message' => 'Report was successful deleted!'
            ]);
        }
    }
}
