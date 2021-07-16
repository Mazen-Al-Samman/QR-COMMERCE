<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function vendor() {
        return $this->hasOne(Vendor::class,'id','vendor_id');
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function createCategory($request){
        $category = new Category();
        $category->title = $request->title;
        $category->vendor_id = $request->vendor;
        if ($request->hasfile('image')) {
            
        }
    }
}
