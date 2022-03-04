<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
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
        $invoice_data = Invoice::getAllVendorInvoices();
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
        $this->UpdateInvoice($id);
        $invoice = new Invoice();
        $invoice_data = $invoice->getInvoiceById($id);
        if($invoice_data) {
            return response()->json([
                'status' => true,
                'data' => $invoice_data
            ]);
        }

        return response()->json([
            'status' => true,
            'data' => []
        ]);
    }

    public function UpdateInvoice($id) {

        $invoice = Invoice::where('id' ,$id)->get();
        $invoice = count($invoice) > 0 ? $invoice[0] : null;
        if($invoice && !$invoice['user_id']) {
            $invoice['user_id'] = auth('api')->id();
            return $invoice->save();
        }
        return false;
    }

    public function getInvoiceByVendor($vendor_id, Invoice $invoice) {
        $data = $invoice->getInvoiceByVendor($vendor_id);
            return response()->json([
                'status' => true,
                'color_number' => 2,
                'analysis_data' => $data['analysis_data'],
                'data' => $data['invoice_data']
            ]);
    }

    public function getMyVendors () {
        $vendors  = Vendor::whereHas('invoice', function ($q) {
            $q->where(['user_id' => auth('api')->id()]);
        })->get();
        return response()->json([
            'status' => true,
            'data' => $vendors
        ]);
    }

    public function getInvoiceByCategory($vendor_id, $category_id, Invoice $invoice) {
        $data = $invoice->getInvoiceByCategory($vendor_id, $category_id);
            return response()->json([
                'status' => true,
                'color_number' => 3,
                'analysis_data' => $data['analysis_data'],
                'data' => $data['invoice_data']
            ]);
    }

    public function getMyCategory($vendor_id) {
        $vendors  = Category::whereHas('product', function ($q) use ($vendor_id) {
            $q->where(['vendor_id' => $vendor_id])->whereHas('invoiceProduct', function ($q) {
                $q->whereHas('invoice', function ($q) {
                    $q->where(['user_id' => auth('api')->id()]);
                });
            });
        })->get();
        return response()->json([
            'status' => true,
            'data' => $vendors
        ]);
    }

    public function getMyinvoice () {
        $invoices = Invoice::myInvoices();
        return response()->json([
            'status' => true,
            'total' => $invoices['total'],
            'color_number' => 1,
            'data' => $invoices['my_invoices']
        ]);
    }

    public function streamPdf($invoice_id) {
        return Invoice::streamPDF($invoice_id);

    }

    public function streamPdfLink($invoice_id) {
        if(Invoice::where(['id' => $invoice_id])->exists()) {
            $link = route('invoice.streamPdf',['invoice_id' => $invoice_id]);
            return response()->json([
                'status' => true,
                'data' => $link
            ]);
        }

        return response()->json([
            'status' => false,
            'data' => "This invoice is not exist"
        ]);

    }

    public function deleteInvoice($id) {
       return Invoice::DeleteInvoiceById($id);
    }

    public function invoiceAnalysis() {
        $analysis = Invoice::getAnalysisByMonth();
        return response()->json([
            'status' => true,
            'data' => $analysis
        ]);
    }

    public function invoiceVendorAnalysis($vendor_id) {
        $analysis = Invoice::getVendorAnalysis($vendor_id);
        return response()->json([
            'status' => true,
            'data' => $analysis
        ]);
    }

    public function invoiceVendorCategoryAnalysis($vendor_id, $category_id) {
        $analysis = Invoice::getVendorCategoryAnalysis($vendor_id, $category_id);
        return response()->json([
            'status' => true,
            'data' => $analysis
        ]);
    }

    public function storeManualInvoice(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'title' => ['required'],
            'total_price' => ['required'],
            'type' => ['required'],
            'file' => ['file', 'mimes:jpg,png,jpeg,gif,svg,pdf,xls,ppt,doc,docx,csv', 'max:2048'],
            'manual_invoice_date' => ['required','date_format:Y-m-d'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validation->errors()
            ]);
        }

        $invoice = new Invoice();

        if($invoice->createManualInvoice($request)) {
            return response()->json([
                'status' => true,
                'message' => 'Invoice was successfully added'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'something wrong !!'
        ]);
    }
}
