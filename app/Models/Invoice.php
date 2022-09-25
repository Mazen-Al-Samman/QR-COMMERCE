<?php

namespace App\Models;

use App\Http\Controllers\Helpers\CommonHelper;
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

    const TYPE_OUTSOURCE = 'out-source';

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

    public function invoiceOtherProduct()
    {
        return $this->hasMany(InvoiceOtherProduct::class);
    }

    public static function getAllVendorInvoices()
    {
        return Invoice::with(['user', 'vendor'])
            ->where(['vendor_id' => auth('vendor')
            ->user()->vendor_id])
            ->orderBy('invoices.user_id')
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public static function getAllInvoices()
    {
        return Invoice::with(['user', 'vendor'])->get();
    }

    public function getInvoiceById($invoice_id)
    {
        $invoice_data = Invoice::with(['vendor','user','invoiceProduct','invoiceProduct.product', 'invoiceOtherProduct'])->where(['invoices.id' => $invoice_id])->get();
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
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product', 'invoiceOtherProduct', 'vendor'])->where(['invoices.id' => $invoice_id])->get()->toArray();
        $invoice_data = json_decode(json_encode($invoice_data), true)[0];

        $common_helper = new CommonHelper();
        if($invoice_data['type'] == self::TYPE_OUTSOURCE) {
            $common_helper->decryptInvoice($invoice_data);
            if (!empty($invoice_data['invoice_other_product'])) {
                $otherProducts = [];
                foreach ($invoice_data['invoice_other_product'] as $product) {
                    $otherProducts [] = $common_helper->decryptInvoiceProducts($product);
                }
                $invoice_data['invoice_other_product'] = $otherProducts;
            }
        }

        $pdf = MPDF::loadView('backend.invoice.pdf', [
            'invoice_data' => $invoice_data,
            'pdf_option' => true
        ]);
        return $pdf->download('invoice.pdf');
    }

    public function getInvoiceByVendor($vendor_id)
    {
        $common_helper = new CommonHelper();
        $outSourceInvoices = self::with(['invoiceOtherProduct'])
            ->where([
                'invoices.type' => self::TYPE_OUTSOURCE,
                'user_id' => auth('api')->id()
            ])->get();

        DB::beginTransaction();
        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->decrypt($invoice['total_price']);
            $invoice->qr_code = $common_helper->decrypt($invoice['qr_code']);
            if (!$invoice->save()) {
                DB::rollBack();
            }
        }

        $invoice_data = Invoice::with(['vendor'])
            ->where([
                'vendor_id' => $vendor_id,
                'user_id' => auth('api')->id()
            ])->orderBy('created_at','desc')->get();

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

    public function getInvoiceByCategory($vendor_id, $category_id)
    {
        $common_helper = new CommonHelper();
        $outSourceInvoices = self::with(['invoiceOtherProduct'])
            ->where([
                'invoices.type' => self::TYPE_OUTSOURCE,
                'user_id' => auth('api')->id()
            ])->get();

        DB::beginTransaction();
        $other_invoice_sum = 0;
        $other_vendor_invoices = 0;
        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->decrypt($invoice['total_price']);
            $invoice->qr_code = $common_helper->decrypt($invoice['qr_code']);
            if(count($invoice->invoiceOtherProduct) > 0 && $invoice->vendor_id) {
                foreach ($invoice->invoiceOtherProduct as $prod) {
                    if($prod->category_id == $category_id) {
                        $price = $common_helper->decrypt($prod['price']);
                        $quantity = $common_helper->decrypt($prod['quantity']);
                        $other_invoice_sum += $price * $quantity;
                    }
                }
            }
            if($invoice->vendor_id == $vendor_id) {
                $other_vendor_invoices += $invoice->total_price;
            }
            if (!$invoice->save()) {
                DB::rollBack();
            }
        }

        $invoice_data  = Invoice::with(['vendor'])->whereHas('invoiceProduct', function ($q) use ($vendor_id, $category_id) {
            $q->whereHas('product', function ($q) use ($vendor_id, $category_id) {
                $q->where(['category_id' => $category_id, 'vendor_id' => $vendor_id]);
            });
        })->orWhereHas('invoiceOtherProduct', function ($q) use ($vendor_id, $category_id) {
            $q->where(['category_id' => $category_id]);
        })->where(['user_id' => auth('api')->id()])->orderBy('created_at', 'DESC')->get()->toArray();


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
            DB::raw('(invoices.total_price) as totalPriceWithQuantity')
//            DB::raw('(products.price * invoice_products.quantity) as totalPriceWithQuantity')
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

        $category_sum += $other_invoice_sum;
        $category_sum = number_format((float)$category_sum, 2, '.', '');

        $category_percentage = ($category_sum / $sum) * 100;
        $category_percentage = number_format((float)$category_percentage, 2, '.', '');


        $vendor_invoices = self::select(DB::raw('sum(total_price) as totalSum'))
            ->where([
                'type' => null,
                'user_id' => auth('api')->id(),
                'vendor_id' => $vendor_id
            ])->get();

        $vendor_sum_main = $vendor_invoices[0]['totalSum'] + $other_vendor_invoices;
        $vendor_sum = number_format((float)$vendor_sum_main, 2, '.', '');
        $vendor_percentage = ($vendor_sum_main / $sum) * 100;
        $vendor_percentage = number_format((float)$vendor_percentage, 2, '.', '');

        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->encrypt($invoice['total_price']);
            if(!$invoice->save()) {
                DB::rollBack();
            }
        }
        DB::commit();

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
        $my_invoices = self::with(['vendor'])
            ->where(['user_id' => auth('api')->id()])
            ->orderBy('created_at', 'DESC')
            ->get()->toArray();

        $invoice_data = [];
        foreach ($my_invoices as $invoice) {
            if($invoice['type'] == Invoice::TYPE_OUTSOURCE) {
                $common_helper = new CommonHelper();
                $common_helper->decryptInvoice($invoice);
            }
            unset($invoice['vendor']['access_key']);
            $invoice_data [] = $invoice;
        }

        $total = array_sum(array_column($invoice_data, 'total_price'));
        $total = number_format((float)$total, 2, '.', '');
        $data = [
            'my_invoices' => $invoice_data,
            'total' => $total
        ];
        return $data;
    }

    public static function streamPDF($invoice_id)
    {
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product', 'invoiceOtherProduct', 'vendor'])->where(['invoices.id' => $invoice_id])->get()->toArray()[0];

        if($invoice_data['type'] == self::TYPE_OUTSOURCE) {
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

        $pdf = MPDF::loadView('backend.invoice.pdf', [
            'invoice_data' => $invoice_data,
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
        $common_helper = new CommonHelper();
        $outSourceInvoices = self::where([
            'user_id' => auth('api')->id(),
            'type' => self::TYPE_OUTSOURCE
        ])->select(['id', 'total_price'])->get();

        DB::beginTransaction();
        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->decrypt($invoice['total_price']);
            if(!$invoice->save()) {
                DB::rollBack();
            }
        }

        // To Get Year (Total & AVG) For User.
        $total_invoices = self::select(
            DB::raw('sum(total_price) as total_price'),
            DB::raw('YEAR(created_at) year, MONTH(created_at) month')
        )
        ->where(
                DB::raw('YEAR(created_at)'),
                date('Y')
            )->where([
                'user_id' => auth('api')->id()
            ])
            ->orderBy('month')
            ->groupBy('month')
            ->get()->keyBy('month')->toArray();

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
            ])->groupBy('month')->orderBy('month')->get()->keyBy('month');

        // To Send month name with response.
        $static_months = ['1' => 'يناير', '2' => 'فبراير', '3' => 'مارس', '4' => 'ابريل', '5' => 'مايو', '6' => 'يونيو', '7' => 'يوليو', '8' => 'أغسطس', '9' => 'سبتمبر', '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'];

        $invoices = $invoices->mapWithKeys(function ($item,$key) use ($static_months, $invoices, $total_invoices) {
            $test = array_search($key, array_keys(json_decode($invoices, true))) + 1;

            $totalYear = 0;
            foreach ($total_invoices as $invKey => $inv) {
                if($invKey > $key) continue;
                $totalYear += $inv['total_price'];
            }

            $year_avg = number_format(($totalYear / $test), 2, '.', '');

            $month_total = $item['totalSum'];
            $month_avg = number_format((float)($totalYear / $test), 2, '.', '');

            $total_diff = $month_total - $month_avg; // 860 - 510 = 350
            $percentage = ($total_diff / $month_total) * 100; // 350 / 510
            $percentage = number_format((float)$percentage, 2, '.', '');

            $good_message = "في شهر " . $static_months[$item['month']] . " وفرت و صرفت أقل من المتوسط";
            $bad_message = "في شهر " . $static_months[$item['month']] . " صرفت أكثر من معدل صرفك الشهري ب " . abs($total_diff) . " دينار, ما يعادل " . abs($percentage) . "% أعلى من المنوسط";

            $message = "في شهر " . $static_months[$item['month']] . " معدل الصرف معتدل";
            $arrow_image = 'arrow-fair.png';

            if($percentage > 0) {
                $message = $bad_message;
                $arrow_image = "arrow-up.png";
            }
            else if($percentage < 0) {
                $message = $good_message;
                $arrow_image = "arrow-down.png";
            }

            $month = [
                $item['month'] =>
                    [
                        'month' => $item['month'],
                        'month_name' => $static_months[$item['month']],
                        'total' => $month_total,
                        'total_year' => $totalYear,
                        'count' => $item['invoiceCount'],
                        'percentage' => abs((double)$percentage),
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

        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->encrypt($invoice['total_price']);
            if(!$invoice->save()) {
                DB::rollBack();
            }
        }
        DB::commit();
        return $invoices;

    }


    public static function getVendorAnalysis($vendor_id)
    {
        $common_helper = new CommonHelper();
        $outSourceInvoices = self::where(['vendor_id' => $vendor_id, 'type' => self::TYPE_OUTSOURCE])->select(['id', 'total_price'])->get();

        DB::beginTransaction();
        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->decrypt($invoice['total_price']);
            if (!$invoice->save()) {
                DB::rollBack();
            }
        }

        // To Get Year (Total & AVG) For User.
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

        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->encrypt($invoice['total_price']);
            if(!$invoice->save()) {
                DB::rollBack();
            }
        }
        DB::commit();

        return $data;
    }

    public static function getVendorCategoryAnalysis($vendor_id, $category_id)
    {
        $common_helper = new CommonHelper();
        $outSourceInvoices = self::with(['invoiceOtherProduct'])
            ->where([
                'invoices.type' => self::TYPE_OUTSOURCE,
                'user_id' => auth('api')->id()
            ])->get();

        DB::beginTransaction();
        $other_invoice_sum = 0;
        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->decrypt($invoice['total_price']);
            if(count($invoice->invoiceOtherProduct) > 0 && $invoice->vendor_id == $vendor_id) {
                foreach ($invoice->invoiceOtherProduct as $prod) {
                    if($prod->category_id == $category_id) {
                        $price = $common_helper->decrypt($prod['price']);
                        $quantity = $common_helper->decrypt($prod['quantity']);
                        $other_invoice_sum += $price * $quantity;
                    }
                }
            }

            if(!$invoice->save()) {
                DB::rollBack();
            }
        }

        $total_invoices = self::select(
            DB::raw('sum(total_price) as totalSum'),
            DB::raw('AVG(total_price) as totalAvg')
        )->where([
            'user_id' => auth('api')->id()
        ])->get()->toArray();
        $sum = $total_invoices[0]['totalSum'];

        $invoices = self::join('invoice_products', 'invoices.id', '=', 'invoice_products.invoice_id')
            ->join('products', function ($join) {
                $join->on('invoice_products.product_id', '=', 'products.id');
            })
            ->select(
                DB::raw('sum(products.price) as totalprice'),
                DB::raw('count(products.id) as `productCount`'),
                DB::raw('invoice_products.quantity as `quantity`'),
                DB::raw('(sum(products.price) * invoice_products.quantity) as totalPriceWithQuantity')
        )
            ->where([
                'invoices.vendor_id' => $vendor_id,
                'products.vendor_id' => $vendor_id,
                'products.category_id' => $category_id,
                'invoices.user_id' => auth('api')->id()
            ])
            ->groupBy('products.id')->get();

        $invoices_sum = 0;
        foreach ($invoices as $invoice) {
            $invoices_sum += $invoice['totalPriceWithQuantity'];
        }

        $invoices_sum += $other_invoice_sum;
        $percentage = ($invoices_sum / $sum) * 100;
        $percentage = number_format((float)$percentage, 2, '.', '');

        foreach ($outSourceInvoices as $invoice) {
            $invoice->total_price = $common_helper->encrypt($invoice['total_price']);
            if (!$invoice->save()) {
                DB::rollBack();
            }
        }
        DB::commit();

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
