<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaProduct extends Model
{
    use HasFactory;

    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }

    public function media(){
        return $this->hasOne(Media::class,'id','media_id');
    }
}
