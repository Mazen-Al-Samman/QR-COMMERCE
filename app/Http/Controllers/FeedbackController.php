<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

    }

    public function storeApi(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'rate' => ['required'],
            'comment' => ['required','string'],
            'user_id' => ['exists:users,id'],
            'vendor_id' => ['required','exists:vendors,id']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        $feedback = new Feedback();
        if ($feedback->createFeedback($request)) {
            return response()->json([
                'status' => true,
                'message' => "Feedback was successfully sent!"
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => "something wrong"
        ]);
    }
}
