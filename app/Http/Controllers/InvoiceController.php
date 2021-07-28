<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class InvoiceController extends Controller
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
        \session()->remove('cart');
        $productsByCat = Product::with('category')->get();
        return view('backend.invoice.create', [
            'products' => $productsByCat
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
        $in_procuts = new InvoiceProduct();
        if ($invoice = $in_procuts->storeInvoiceProducts()) {
            QrCode::size(500)
                ->format('png')
                ->generate(route('invoice.show',['invoice_id' => $invoice->id]), storage_path() . "/app/public/uploads/qr/qrcode_".$invoice->id.".png");
        }
    }

    public function addToCart(Request $request)
    {
        if($request->quantity !=0){
            $cart = session()->has('cart') ? session()->get('cart') : [];
            $product = Product::where(['id'=>$request->product_id])->get();

            if (array_key_exists($request->product_id, $cart)) {
                $cart[$request->product_id]['quantity']+=$request->quantity;
            }else{
                $cart[$request->product_id] = array(
                    'id' => $product[0]->id,
                    'main_image' => $product[0]->main_image,
                    'name' => $product[0]->name,
                    'category' => $product[0]->category->title,
                    'category_id' => $product[0]->category_id,
                    'price' => $product[0]->price,
                    'quantity' =>$request->quantity
                );
            }
            \session(['cart'=>$cart]);
            return view('backend.invoice.productsAjax',[
                    'data'=>$cart
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);
        $products =  DB::table('products')
            ->select([
                'invoice_products.invoice_id',
                'products.id As product_id',
                'products.*',
                'categories.title As category_name'
            ])
            ->join('invoice_products', function ($join) use ($id) {
                $join->on('invoice_products.product_id', '=', 'products.id')
                    ->where('invoice_products.invoice_id', $id);
            })->join('categories','products.category_id','=','categories.id')->get();

        return view('backend.invoice.view',[
            'invoice_data' => $invoice,
            'invoice_products' => $products
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
