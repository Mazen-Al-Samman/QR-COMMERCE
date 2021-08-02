<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasMany(Product::class);
    }

    public function getallCategories(){
        return Category::paginate(15);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }


    public function createCategory($request)
    {
        $category = new Category();
        $category->title = $request->title;
        $category->vendor_id = $request->vendor;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/categories/", $name);
            $category->image = $name;
        }
        return $category->save();
    }

    public function updateCategory($id, $request)
    {
        $category = Category::find($id);
        $category->title = $request->title;
        $category->vendor_id = $request->vendor;
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/categories/", $name);
            $category->image = $name;
        }
        return $category->save();
    }

    public function getCategoriesApi($vendor_id = null)
    {
        $categories = null;
        if ($vendor_id) {
            $categories = Category::where(['vendor_id' => $vendor_id])->get();
        } else {
            $categories = Category::all();
        }
        return $categories;
    }
}
