<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Invoice;
use App\Models\InvoiceOtherProduct;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use PDF;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Http\Controllers\Helpers\CommonHelper;

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
        $invoices = [];
        foreach ($invoice_data as $invoice) {
            $common_helper = new CommonHelper();
            if ($invoice['type'] == Invoice::TYPE_OUTSOURCE) {
                $common_helper->decryptInvoice($invoice);
            }
            $invoices [] = $invoice;
        }

        return view('backend.invoice.index', [
            'invoice_data' => $invoices,
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
        $invoice_data = $invoice->getInvoiceById($id)[0];

        if($invoice_data['type'] == Invoice::TYPE_OUTSOURCE) {
            $common_helper = new CommonHelper();
            $common_helper->decryptInvoice($invoice_data);
            if (!empty($invoice_data['invoice_other_product'])) {
                $otherProducts = [];
                foreach ($invoice_data['invoice_other_product'] as $product) {
                    $otherProducts [] = $common_helper->decryptInvoiceProducts($product);
                }
                $invoice_data['invoice_other_product'] = $otherProducts;
            }
        }
        return view('backend.invoice.view', [
            'invoice_data' => $invoice_data,
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

        if(!$invoice_data) {
            return response()->json([
                'status' => true,
                'data' => []
            ]);
        }

        $common_helper = new CommonHelper();

        if($invoice_data[0]['type'] == Invoice::TYPE_OUTSOURCE) {
            $common_helper->decryptInvoice($invoice_data[0]);
            if (!empty($invoice_data[0]['invoice_other_product'])) {
                $otherProducts = [];
                foreach ($invoice_data[0]['invoice_other_product'] as $product) {
                    $otherProducts [] = $common_helper->decryptInvoiceProducts($product);
                }
                $invoice_data[0]['invoice_other_product'] = $otherProducts;
            }
        }

        return response()->json([
            'status' => true,
            'data' => $invoice_data
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

        if($data['invoice_data'][0]['type'] == Invoice::TYPE_OUTSOURCE) {
            $common_helper = new CommonHelper();
            $common_helper->decryptInvoice($data['invoice_data'][0]);
        }

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

        $invoice_data = [];
        foreach ($invoices['my_invoices'] as $invoice) {
            if($invoice['type'] == Invoice::TYPE_OUTSOURCE) {
                $common_helper = new CommonHelper();
                $common_helper->decryptInvoice($invoice);
            }
            unset($invoice['vendor']['access_key']);
            $invoice_data [] = $invoice;
        }

        return response()->json([
            'status' => true,
            'total' => $invoices['total'],
            'color_number' => 1,
            'data' => $invoice_data
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

    public function generateInvoice(Request $request)
    {
        DB::beginTransaction();
        try {
            $common_helper = new CommonHelper();
            $products = $request->post();
            if (!$common_helper->filterOtherProductSkeleton($products)) {
                return response()->json([
                    'status' => false,
                    'message' => "Messing parameters !"
                ]);
            }

            $data = [];
            $total_amount = 0;
            foreach ($products as $product) {
                $validator = Validator::make(
                    $product,
                    [
                        'name' => 'required|string',
                        'price' => 'required',
                        'quantity' => 'required',
                        'total_price' => 'required',
                    ]
                );

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => $validator->errors()
                    ]);
                }
                $total_amount += $product['total_price'];
                $data [] = $common_helper->encryptInvoiceProducts($product);
            }

            $accessKey = $request->header('accessKey');
            $vendor = Vendor::where(['access_key' => $accessKey])->get()[0];
            if (!$vendor) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "Something wrong !!"
                ]);
            }

            $qr_code_name = 'qrcode_' . time() . '.png';
            $invoice = new Invoice();
            $invoice->type = Invoice::TYPE_OUTSOURCE;
            $invoice->vendor_id = $vendor->id;
            $invoice->total_price = $common_helper->encrypt($total_amount);
            $invoice->qr_code = $common_helper->encrypt($qr_code_name);

            if (!$invoice->save()) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "Something wrong !!"
                ]);
            }

            $products = array_map(function ($product) use ($invoice) {
                return $product + [
                        'invoice_id' => $invoice->id,
                        'created_at' => date("Y-m-d h:i:s"),
                        'updated_at' => date("Y-m-d h:i:s"),
                    ];
            }, $data);

            if (!InvoiceOtherProduct::insert($products)) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "Something wrong !!"
                ]);
            }

            QrCode::size(500)
                ->format('png')
                // ->generate(route('invoice.show', ['invoice_id' => $invoice->id]), public_path() . "/assets/images/uploads/qr/" . $invoice->qr_code);
                ->generate(route('get-invoice-by-id', ['id' => $invoice->id]), public_path() . "/assets/images/uploads/qr/" . $qr_code_name);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => "success"
            ]);

        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
