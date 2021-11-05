<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rate',
        'comment',
        'user_id',
        'vendor_id'
    ];

    public function createFeedback($request)
    {
        $feedback = new Feedback();
        $feedback->rate = $request->rate;
        $feedback->comment = $request->comment;
        $feedback->user_id = auth('api')->user()->id;
        $feedback->vendor_id = $request->vendor_id;
        return $feedback->save();
    }
}
