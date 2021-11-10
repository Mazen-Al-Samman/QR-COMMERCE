<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const ROLE_PREFIX = 'category';
    use HasFactory;

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function getallCategories(){
        $vendor_id = auth('vendor')->user()->vendor_id;
        return Category::where(['vendor_id' => $vendor_id])->paginate(15);
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }


    public function createCategory($request)
    {
        if (empty(auth('vendor')->user()->vendor_id)) {
            abort(404);
        }
        $category = new Category();
        $category->title = $request->title;
        $category->vendor_id = auth('vendor')->user()->vendor_id;
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
        if (empty(auth('vendor')->user()->vendor_id)) {
            abort(404);
        }
        $category = Category::find($id);
        $category->title = $request->title;
        $category->vendor_id = auth('vendor')->user()->vendor_id;
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
