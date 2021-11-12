<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

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
        'vendor_id'
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

    public static function getAllInvoices()
    {
        return Invoice::with(['user', 'vendor'])->get();
    }

    public function getInvoiceById($invoice_id)
    {
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product'])->where(['invoices.id' => $invoice_id])->get();
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
        $invoice_data = Invoice::with(['user','invoiceProduct','invoiceProduct.product'])->where(['invoices.id' => $invoice_id])->get()->toArray();
        $invoice_data = json_decode(json_encode($invoice_data), true);

        $pdf = PDF::loadView('backend.invoice.view', [
            'invoice_data' => $invoice_data[0],
            'pdf_option' => true
        ])->setPaper('letter', 'landscape')->setPaper('a4', 'landscape');
        return $pdf->download('invoice.pdf');
    }

    public function getInvoiceByVendor($vendor_id)
    {
        $invoice_data = Invoice::where(['vendor_id' => $vendor_id, 'user_id' => auth('api')->id()])->orderBy('created_at','desc')->get();
        return $invoice_data;
    }

    public function getInvoiceByCategory($category_id) {
        $invoice_data  = Invoice::whereHas('invoiceProduct', function ($q) use ($category_id) {
            $q->whereHas('product', function ($q) use ($category_id) {
                $q->where(['category_id' => $category_id]);
            });
        })->where(['user_id' => auth('api')->id()])->get();
        return $invoice_data;
    }

    public static function myInvoices () {
        return self::where(['user_id' => auth('api')->id()])->get();
    }
}
