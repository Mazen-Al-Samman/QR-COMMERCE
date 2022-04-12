<?php

namespace App\Models;

use Elibyy\TCPDF\TCPDF;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Meneses\LaravelMpdf\LaravelMpdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use MPDF;

class Invoice extends Model
{
    const ROLE_PREFIX = 'invoice';
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_price',
        'qr_code',
        'user_id',
        'vendor_id',
        'is_manual',
        'title',
        'type',
        'note',
        'file',
        'manual_invoice_date',
    ];

    public static function getInvoicesCount()
    {
        return Invoice::all()->count();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function invoiceProduct()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

    public static function getAllVendorInvoices()
    {
        return Invoice::with(['user', 'vendor'])->where(['vendor_id' => auth('vendor')->user()->vendor_id])->get();
    }

    public static function getAllInvoices()
    {
        return Invoice::with(['user', 'vendor'])->get();
    }

    public function getInvoiceById($invoice_id)
    {
        $invoice_data = Invoice::with(['vendor','user','invoiceProduct','invoiceProduct.product'])->where(['invoices.id' => $invoice_id])->get();
        $invoice_data = json_decode(json_encode($invoice_data), true);
        return $invoice_data;
    }

    public static function storeInvoice($data)
    {
        $invoice = new Invoice();
        $invoice->total_price = $data['total_price'];
        $invoice->vendor_id = $data['vendor_id'];
        $invoice->qr_code = 'qrcode_' . time() . '.png';
        if ($invoice->save()) {
            $cart = session()->get('cart');
            $check = true;
            foreach ($cart as $item) {
                $in_product = new InvoiceProduct();
                $in_product->invoice_id = $invoice->id;
                $in_product->product_id = $item['id'];
                $in_product->quantity = $item['quantity'];
                if (!$in_product->save()) {
                    $check = false;
                }
            }
            if ($check) {
                QrCode::size(500)
                    ->format('png')
                    // ->generate(route('invoice.show', ['invoice_id' => $invoice->id]), public_path() . "/assets/images/uploads/qr/" . $invoice->qr_code);
                    ->generate(route('get-invoice-by-id',['id' => $invoice->id]), public_path() . "/assets/images/uploads/qr/" . $invoice->qr_code);
                return ['status' => true, 'data' => $invoice];
            }
        }

        return ['status' => false, 'data' => null];
    }

    public static function downloadPDF($invoice_id)
    {
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product', 'vendor'])->where(['invoices.id' => $invoice_id])->get()->toArray();
        $invoice_data = json_decode(json_encode($invoice_data), true);
        $pdf = MPDF::loadView('backend.invoice.pdf', [
            'invoice_data' => $invoice_data[0],
            'pdf_option' => true
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function getInvoiceByVendor($vendor_id)
    {
        $invoice_data = Invoice::with(['vendor'])->where(['vendor_id' => $vendor_id, 'user_id' => auth('api')->id()])->orderBy('created_at','desc')->get();

        // To Get Total for all User Invoices.
        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg')
            )
            ->where([
                'user_id' => auth('api')->id()
            ])->get()->toArray();
        $sum = $total_invoices[0]['totalSum'];
        $sum = number_format((float)$sum, 2, '.', '');

        // To get invoice calc for specific vendor
        $invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('count(id) as `invoiceCount`'),
            DB::raw('id')
            )
            ->where([
                'user_id' => auth('api')->id(),
                'vendor_id' => $vendor_id
            ])->get();

        $vendor_sum = $invoices[0]['totalSum'];
        $vendor_sum = number_format((float)$vendor_sum, 2, '.', '');;
        $percentage = ($invoices[0]['totalSum'] / $sum) * 100;
        $percentage = number_format((float)$percentage, 2, '.', '');

        $analysis_data = [
            'invoices_sum' => $sum,
            'vendor_sum' => $vendor_sum,
            'vendor_percentage' => $percentage
        ];

        return [
            'invoice_data' => $invoice_data,
            'analysis_data' => $analysis_data
        ];

    }

    public function getInvoiceByCategory($vendor_id, $category_id) {

        $invoice_data  = Invoice::with(['vendor'])->whereHas('invoiceProduct', function ($q) use ($vendor_id, $category_id) {
            $q->whereHas('product', function ($q) use ($vendor_id, $category_id) {
                $q->where(['category_id' => $category_id, 'vendor_id' => $vendor_id]);
            });
        })->where(['user_id' => auth('api')->id()])->get();

        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg')
            )->where([
                'user_id' => auth('api')->id()
            ])->get()->toArray();
        $sum = $total_invoices[0]['totalSum'];
        $sum = number_format((float)$sum, 2, '.', '');

        $category_invoices = self::join('invoice_products','invoices.id', '=', 'invoice_products.invoice_id')
        ->join('products', function ($join) {
            $join->on('invoice_products.product_id', '=', 'products.id');
        })
        ->select(
            DB::raw('(products.price * invoice_products.quantity) as totalPriceWithQuantity'),
        )
        ->where([
            'invoices.vendor_id' => $vendor_id,
            'products.vendor_id' => $vendor_id,
            'products.category_id' => $category_id,
            'invoices.user_id' => auth('api')->id()
        ])->get()->toArray();

        $category_sum = 0;
        foreach($category_invoices as $invoice) {
            $category_sum += $invoice['totalPriceWithQuantity'];
        }
        $category_sum = number_format((float)$category_sum, 2, '.', '');

        $category_percentage = ($category_sum / $sum) * 100;
        $category_percentage = number_format((float)$category_percentage, 2, '.', '');


        $vendor_invoices = self::select(DB::raw('sum(total_price) as totalSum'))
            ->where([
                'user_id' => auth('api')->id(),
                'vendor_id' => $vendor_id
            ])->get();

        $vendor_sum = $vendor_invoices[0]['totalSum'];
        $vendor_sum = number_format((float)$vendor_sum, 2, '.', '');
        $vendor_percentage = ($vendor_invoices[0]['totalSum'] / $sum) * 100;
        $vendor_percentage = number_format((float)$vendor_percentage, 2, '.', '');


        $analysis_data = [
            'invoices_sum' => $sum,
            'vendor_sum' => $vendor_sum,
            'vendor_percentage' => $vendor_percentage,
            'category_sum' => $category_sum,
            'category_percentage' => $category_percentage
        ];


        return [
            'invoice_data' => $invoice_data,
            'analysis_data' => $analysis_data
        ];

    }

    public static function myInvoices () {
        $my_invoices = self::with(['vendor'])->where(['user_id' => auth('api')->id()])->get()->toArray();
        $total = array_sum(array_column($my_invoices, 'total_price'));
        $total = number_format((float)$total, 2, '.', '');
        $data = [
            'my_invoices' => $my_invoices,
            'total' => $total
        ];
        return $data;
    }

    public static function streamPDF($invoice_id)
    {
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product', 'vendor'])->where(['invoices.id' => $invoice_id])->get()->toArray();
        $opciones_ssl=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),);

        $pdf = MPDF::loadView('backend.invoice.pdf', [
            'invoice_data' => $invoice_data[0],
            'pdf_option' => true
        ]);
        return $pdf->stream('document.pdf');



//        $pdf = PDF::loadView('backend.invoice.view', [
//            'invoice_data' => $invoice_data[0],
//            'pdf_option' => true
//        ])->setPaper('letter', 'landscape')->setPaper('a4', 'landscape');
//        return $pdf->stream('invoice.pdf');
    }

    public static function deleteInvoiceById($id) {
        if (Invoice::where(['id' => $id])->delete()) {
            return response()->json([
                'status' => true,
                'message' => "Invoice Deleted"
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => "Invoice Not Exist"
        ]);
    }

    public static function getAnalysisByMonth()
    {
        // To Get Year (Total & AVG) For User.
        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg'),
            DB::raw('count(id) as `invoiceCount`')
            )
            ->where(
                DB::raw('YEAR(created_at)'),
                date('Y')
            )->where([
                'user_id' => auth('api')->id()
            ])
            ->get()->toArray();

        $year_avg = number_format((float)$total_invoices[0]['totalAvg'], 2, '.', '');
        $year_total = $total_invoices[0]['totalSum'];

        // To Get Month (Total, AVG & COUNT ) For User.
        $invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg'),
            DB::raw('count(id) as `invoiceCount`'),
            DB::raw('id'),
            DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),
            DB::raw('YEAR(created_at) year, MONTH(created_at) month')
            )
            ->where(DB::raw('YEAR(created_at)'), date('Y'))
            ->where([
                'user_id' => auth('api')->id()
            ])->groupBy('month')->get();

        // To Send month name with response.
        $static_months = ['1' => 'يناير', '2' => 'فبراير', '3' => 'مارس', '4' => 'ابريل', '5' => 'مايو', '6' => 'يونيو', '7' => 'يوليو', '8' => 'أغسطس', '9' => 'سبتمبر', '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'];

        $invoices = $invoices->mapWithKeys(function ($item) use ($year_avg, $year_total, $static_months) {

            $month_avg = number_format((float)$item['totalAvg'], 2, '.', '');
            $month_total = $item['totalSum'];

            $percentage = ($month_total / $year_avg) * 100 - 100;
//            $percentage = ($month_total / $month_avg) * 100 - 100;
//            $percentage = ($month_total / $year_total) * 100;
            $percentage = number_format((float)$percentage, 2, '.', '');

            $good_message = "في شهر " . $static_months[$item['month']] . " وفرت و صرفت أقل من المتوسط";
            $bad_message = "في شهر " . $static_months[$item['month']] . " صرفت أكثر من معدل صرفك الشهري ب " . $item['totalSum'] . " دينار, ما يعادل " . $percentage . "% أعلى من المنوسط";

            $message = "في شهر " . $static_months[$item['month']] . " معدل الصرف معتدل";
            $arrow_image = 'arrow-fair.png';

            if($year_avg > $month_avg) {
                $message = $good_message;
                $arrow_image = "arrow-up.png";
            }
            else if($year_avg < $month_avg) {
                $message = $bad_message;
                $arrow_image = "arrow-down.png";
            }

            $month = [
                $item['month'] =>
                    [
                        'month' => $item['month'],
                        'month_name' => $static_months[$item['month']],
                        'total' => $month_total,
                        'total_year' => $year_total,
                        'count' => $item['invoiceCount'],
                        'percentage' => (double)$percentage,
                        'average' => $month_avg,
                        'average_year' => $year_avg,
                        'message' => $message,
                        'image' => $arrow_image
                    ]
            ];

            return $month;
        });
        $invoices = json_decode($invoices,true);
        $invoices = array_values($invoices);
        return $invoices;

    }


    public static function getVendorAnalysis($vendor_id) {
        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg')
            )
            ->where([
                'user_id' => auth('api')->id()
            ])->get()->toArray();
        $sum = $total_invoices[0]['totalSum'];

        $invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('count(id) as `invoiceCount`'),
            DB::raw('id')
            )
            ->where([
                'user_id' => auth('api')->id(),
                'vendor_id' => $vendor_id
            ])->get();

        $vendor_sum = $invoices[0]['totalSum'];
        $percentage = ($invoices[0]['totalSum'] / $sum) * 100;
        $percentage = number_format((float)$percentage, 2, '.', '');

        $data = [
            'sum' => $sum,
            'vendor_sum' => $vendor_sum,
            'invoice_count' => $invoices[0]['invoiceCount'],
            'percentage' => $percentage

        ];

        return $data;
    }

    public static function getVendorCategoryAnalysis($vendor_id, $category_id) {
        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg')
            )->where([
                'user_id' => auth('api')->id()
            ])->get()->toArray();
        $sum = $total_invoices[0]['totalSum'];

        $invoices = self::join('invoice_products','invoices.id', '=', 'invoice_products.invoice_id')
        ->join('products', function ($join) {
            $join->on('invoice_products.product_id', '=', 'products.id');
        })
        ->select(
            DB::raw('sum(products.price) as totalprice'),
            DB::raw('count(products.id) as `productCount`'),
            DB::raw('invoice_products.quantity as `quantity`'),
            DB::raw('(sum(products.price) * invoice_products.quantity) as totalPriceWithQuantity'),
        )
        ->where([
            'invoices.vendor_id' => $vendor_id,
            'products.vendor_id' => $vendor_id,
            'products.category_id' => $category_id,
            'invoices.user_id' => auth('api')->id()
        ])->groupBy('products.id')->get();

        $invoices_sum = 0;
        foreach($invoices as $invoice) {
            $invoices_sum += $invoice['totalPriceWithQuantity'];
        }

        $percentage = ($invoices_sum / $sum) * 100;
        $percentage = number_format((float)$percentage, 2, '.', '');

        return [
            'sum' => $sum,
            'invoices_sum' => $invoices_sum,
            'percentage' => $percentage
        ];
    }

    /**
     * @param $request
     */
    public function createManualInvoice($request)
    {
        $invoice = new self();
        $invoice->title = $request->title;
        $invoice->total_price = $request->total_price;
        $invoice->user_id = auth('api')->user()->id;
        $invoice->is_manual = 1;
        $invoice->type = $request->type;
        $invoice->note = $request->note;
        $invoice->manual_invoice_date = $request->manual_invoice_date;

        if ($request->hasfile('file')) {
            $file = $request->file('file');
            $name = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path() . "/assets/images/uploads/manual_invoices/", $name);
            $invoice->file = $name;
        }
        return $invoice->save();
    }
}
