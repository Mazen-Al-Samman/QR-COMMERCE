<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use PDF;
use Illuminate\Http\Request;

class InvoiceController extends MainController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $invoice_data = Invoice::getAllInvoices();
        return view('backend.invoice.index', [
            'invoice_data' => $invoice_data,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        \session()->remove('cart');
        $vendor_id = auth('vendor')->user()->vendor_id;
        $productsByCat = Product::where(['vendor_id' => $vendor_id])->with('category')->get();
        return view('backend.invoice.create', [
            'products' => $productsByCat,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $in_procuts = new InvoiceProduct();
        if ($invoice = $in_procuts->storeInvoiceProducts()) {
            return redirect()->route('invoice.show', ['invoice_id' => $invoice->id]);
        }
        $request->session()->flash('alert-empty-cart', 'Cart is empty!');
        return redirect()->back();
    }

    public function addToCart(Request $request)
    {
        if ($request->quantity != 0) {
            $cart = Product::addToCart($request);
            return view('backend.invoice.productsAjax', [
                'data' => $cart,
                'userAuthPermission' => $this->getUserPermissionns($request),
            ]);
        }

    }

    public function deleteFromCart(Request $request)
    {
        $cart = Product::deleteFromCart($request);
        return view('backend.invoice.productsAjax', [
            'data' => $cart,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    public function updateCart(Request $request)
    {
        $cart = Product::UpdateCart($request);
        return view('backend.invoice.productsAjax', [
            'data' => $cart,
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $invoice = new Invoice();
        $invoice_data = $invoice->getInvoiceById($id);

        return view('backend.invoice.view', [
            'invoice_data' => $invoice_data[0],
            'userAuthPermission' => $this->getUserPermissionns($request),
        ]);
    }

    public function downloadPDF($invoice_id)
    {
        return Invoice::downloadPDF($invoice_id);
    }

    public function getInvoiceById($id)
    {
        $invoice = new Invoice();
        $invoice_data = $invoice->getInvoiceById($id);

        if(count($invoice_data) > 0) {
            return response()->json([
                'status' => true,
                'data' => $invoice_data
            ]);
        }
        return response()->json([
            'status' => false,
            'data' => []
        ]);
    }
}
