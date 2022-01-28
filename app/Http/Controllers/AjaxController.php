<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function updateStatusField(Request $request) {
        $type = $request->type;
        $value = $request->value;
        $id = $request->id;

        switch($type) {
            case $type == "update-vendor-status" :
                $model = Vendor::find($id);
                $model->status = $value;
                $model->save();
                break;
            case $type == "update-user-status" :
                $model = User::find($id);
                $model->status = $value;
                $model->save();
                break;
        }
    }

    public function updateFlagField(Request $request) {
        $id = $request->id;
        $type = $request->type;
        switch($type) {
            case "banner-published-status" :
                $model = Banner::find($id);
                $model->is_published = !$model->is_published;
                $model->save();
                break;
            case "verify-user" :
                $model = User::find($id);
                $model->actived = !$model->actived;
                $model->save();
                break;
        }

    }
}
