<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

class Invoice extends Model
{
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
        return $this->hasOne(InvoiceProduct::class);
    }

    public static function getAllInvoices()
    {
        return Invoice::with(['user', 'vendor'])->get();
    }

    public function getInvoiceById($invoice_id)
    {
        $invoice_data = DB::table('invoices')->select(['invoice_products.invoice_id', 'invoice_products.quantity', 'invoices.*', 'products.*', 'users.*'])
            ->join('invoice_products', function ($join) use ($invoice_id) {
                $join->on('invoices.id', '=', 'invoice_products.invoice_id')
                    ->join('products', 'invoice_products.product_id', '=', 'products.id')
                    ->where('invoice_products.invoice_id', $invoice_id);
            })
            ->join('users', function ($join) use ($invoice_id) {
                $join->on('invoices.user_id', '=', 'users.id');
            })
            ->get()
            ->toArray();

        $invoice_data = json_decode(json_encode($invoice_data), true);
        return $invoice_data;
    }

    public static function storeInvoice($data)
    {
        $invoice = new Invoice();
        $invoice->total_price = $data['total_price'];
        $invoice->user_id = $data['user_id'];
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
                    ->generate(route('invoice.show', ['invoice_id' => $invoice->id]), public_path() . "/assets/images/uploads/qr/" . $invoice->qr_code);
                return ['status' => true, 'data' => $invoice];
            }
        }

        return ['status' => false, 'data' => null];
    }

    public static function downloadPDF($invoice_id)
    {
        $invoice_data = DB::table('invoices')->select(['invoice_products.invoice_id', 'invoice_products.quantity', 'invoices.*', 'products.*', 'users.*'])
            ->join('invoice_products', function ($join) use ($invoice_id) {
                $join->on('invoices.id', '=', 'invoice_products.invoice_id')
                    ->join('products', 'invoice_products.product_id', '=', 'products.id')
                    ->where('invoice_products.invoice_id', $invoice_id);
            })
            ->join('users', function ($join) use ($invoice_id) {
                $join->on('invoices.user_id', '=', 'users.id');
            })
            ->where(['invoices.id' => $invoice_id])
            ->get()
            ->toArray();

        $invoice_data = json_decode(json_encode($invoice_data), true);

        $pdf = PDF::loadView('backend.invoice.view', [
            'invoice_data' => $invoice_data,
            'pdf_option' => true
        ])->setPaper('letter', 'landscape')->setPaper('a4', 'landscape');
        return $pdf->download('invoice.pdf');
    }
}
