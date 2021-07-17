<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Media;
use App\Models\MediaProduct;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ProductController extends MainController
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
    public function create()
    {
        $category = new Category();
        $vendor = new Vendor();
        $product = new Product();
        $categories = $category->getallCategories();
        $vendors = $vendor->getAllVendors();
        $products = $product->getAllProducts();
        return view('backend.product.create',[
            'categories' => $categories,
            'vendors' => $vendors,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'category_id' => ['required','exists:categories,id'],
            'old_price' => ['numeric'],
            'price' => ['required','numeric'],
            'main_image' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'images.*' => ['required', 'file', 'mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'barcode' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('product.create')->withErrors($validation);
        }

        $product = new Product();
        if($product->createProduct($request)){
            return back()->with('alert-success', 'Product has successfully Added!');
        }
        return new \Exception('an error occurred');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        $images = MediaProduct::where(['product_id' => $id])
                                ->leftJoin('media','media_products.media_id','=','media.id')
                                ->get();
        return view('backend.product.view',[
            'product' => $product,
            'images' => $images
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $category = new Category();
        $vendor = new Vendor();
        $categories = $category->getallCategories();
        $vendors = $vendor->getAllVendors();
        $images = MediaProduct::where(['product_id' => $id])
            ->leftJoin('media','media_products.media_id','=','media.id')
            ->get();
        return view('backend.product.edit', [
            'product' => $product,
            'categories' => $categories,
            'vendors' => $vendors,
            'images' => $images
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'category_id' => ['required','exists:categories,id'],
            'old_price' => ['numeric'],
            'price' => ['required','numeric'],
            'main_image' => ['file', 'mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'images.*' => ['file', 'mimes:jpg,png,jpeg,gif,svg','max:2048'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'barcode' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        if ($validation->fails()) {
            return Redirect::route('product.edit')->withErrors($validation);
        }

        $product = new Product();
        if($product->updateProdcut($id, $request)){
            return back()->with('alert-update', 'Product has successfully Updated!');
        }
        return new \Exception('an error occurred');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if (Product::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Product was successful deleted!');
            return \redirect()->route('product.create');
        }
    }

    public function deleteImage($id, Request $request)
    {
        if (Media::find($id)->delete()) {
            $request->session()->flash('alert-delete', 'Image was successful deleted!');
            return \redirect()->back();
        }
    }

    public function productsApi(Request $request)
    {
        $vendor_id = $request->vendor_id;
        $category_id = $request->category_id ? $request->category_id : null ;
        $product = new Product();
        $products = $product->getAllProductsApi($vendor_id, $category_id);
    }
}
