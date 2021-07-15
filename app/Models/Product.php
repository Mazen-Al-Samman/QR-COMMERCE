<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'barcode',
        'main_image',
        'category_id',
        'vendor_id',
        'posted_by'
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function mediaProduct()
    {
        return $this->hasOne(MediaProduct::class);
    }

    public function getAllProducts(){

        return Product::all();
    }

    public function createProduct($request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->old_price = isset($request->old_price) ? $request->old_price : null;
        $product->price = $request->price;
        $product->vendor_id = $request->vendor_id;
        $product->barcode = $request->barcode;
        $product->description = $request->description;
        $file = $name = null;

        if ($request->hasfile('main_image')) {
            $file = $request->file('main_image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(storage_path() . "/app/public/uploads/products/", $name);
            $product->main_image = $name;
        }

        if ($request->hasfile('images')) {
            $i = 0;
            foreach ($request->file('images') as $file) {
                $name = time() . $i .'_' . $file->getClientOriginalName();
                $media = new Media();
                $media->image = $name;
                if ($media->save()) {
                    $file->move(storage_path() . "/app/public/uploads/products/", $name);
                }
                $i++;
            }
        }
        return $product->save();
    }

}
