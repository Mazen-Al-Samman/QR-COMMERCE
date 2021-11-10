<?php

namespace App\Http\Controllers;

use App\Models\QuickResponseCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuickResponseCodeController extends Controller
{
    public function storeApi(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'device_type' => ['required'],
            'invoice_id' => ['required','exists:invoices,id'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        if(QuickResponseCode::storeQrScan($request)) {
            return response()->json([
                'status' => true,
                'message' => 'Qr Scan has been saved'
            ]);
        }
    }
}
