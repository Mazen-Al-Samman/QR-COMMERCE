<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'vendor_id'
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

    public function invoiceProduct()
    {
        return $this->hasOne(InvoiceProduct::class);
    }

    public function getAllProducts()
    {

        return Product::paginate(15);
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

        if ($request->hasfile('main_image')) {
            $file = $request->file('main_image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/products/", $name);
            $product->main_image = $name;
        }

        if ($product->save()) {
            if ($request->hasfile('images')) {
                $result = true;
                $i = 0;
                foreach ($request->file('images') as $file) {
                    $name = time() . $i . '_' . $file->getClientOriginalName();
                    $media = new Media();
                    $media->image = $name;
                    if ($media->save()) {
                        $media_product = new MediaProduct();
                        $media_product->product_id = $product->id;
                        $media_product->media_id = $media->id;
                        if (!$media_product->save()) {
                            $result = false;
                        }
                        $file->move(public_path() . "/assets/images/uploads/products/", $name);
                    }
                    $i++;
                }
                return $result;
            }
            return true;
        }
        return false;
    }

    public function updateProdcut($id, $request)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->old_price = isset($request->old_price) ? $request->old_price : null;
        $product->price = $request->price;
        $product->vendor_id = $request->vendor_id;
        $product->barcode = $request->barcode;
        $product->description = $request->description;

        if ($request->hasfile('main_image')) {
            $file = $request->file('main_image');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/products/", $name);
            $product->main_image = $name;
        }
        if ($product->save()) {
            if ($request->hasfile('images')) {
                $result = true;
                $i = 0;
                foreach ($request->file('images') as $file) {
                    $name = time() . $i . '_' . $file->getClientOriginalName();
                    $media = new Media();
                    $media->image = $name;
                    if ($media->save()) {
                        $media_product = new MediaProduct();
                        $media_product->product_id = $product->id;
                        $media_product->media_id = $media->id;
                        if (!$media_product->save()) {
                            $result = false;
                        }
                        $file->move(public_path() . "/assets/images/uploads/products/", $name);
                    }
                    $i++;
                }
                return $result;
            }
            return true;
        }
        return false;
    }

    public function getProductsApi($category_id = null)
    {
        $products = null;
        if ($category_id) {
            $products = Product::where(['category_id' => $category_id])->get();
        } else {
            $products = Product::all();
        }
        return $products;
    }

    public function getVendorProductsApi($vendor_id)
    {
        $products = Product::where(['vendor_id' => $vendor_id])->get();

        return $products;
    }

    public function getProductByBarcodeApi($request)
    {
        $products = Product::where([
            'vendor_id' => $request->vendor_id,
            'barcode' => $request->barcode
        ])->get();

        return $products;
    }

    public static function addToCart($request)
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];
        $product = Product::where(['id' => $request->product_id])->get();

        if (array_key_exists($request->product_id, $cart)) {
            $cart[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $cart[$request->product_id] = array(
                'id' => $product[0]->id,
                'main_image' => $product[0]->main_image,
                'name' => $product[0]->name,
                'category' => $product[0]->category->title,
                'category_id' => $product[0]->category_id,
                'price' => $product[0]->price,
                'quantity' => $request->quantity
            );
        }
        \session(['cart' => $cart]);
        return $cart;
    }

    public static function deleteFromCart($request)
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];
        if (array_key_exists($request->product_id, $cart)) {
            unset($cart[$request->product_id]);
            \session(['cart' => $cart]);
        }
        return $cart;
    }


    public static function updateCart($request)
    {
        $cart = session()->has('cart') ? session()->get('cart') : [];
        if (array_key_exists($request->product_id, $cart)) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            \session(['cart' => $cart]);
        }
        return $cart;
    }
}
