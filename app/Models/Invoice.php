<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'user_id',
        'vendor_id'
    ];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function vendor(){
        return $this->hasOne(Vendor::class,'id','vendor_id');
    }

    public function invoiceProduct(){
        return $this->hasOne(InvoiceProduct::class);
    }

    public static function storeInvoice($data)
    {
        $invoice = new Invoice();
        $invoice->total_price = $data['total_price'];
        $invoice->user_id = $data['user_id'];
        $invoice->vendor_id = $data['vendor_id'];
        $invoice->qr_code = 'qrcode_'.time().'.png';
        if($invoice->save()) {
            $cart = session()->get('cart');
            $check = true;
            foreach ($cart as $item) {
                $in_product = new InvoiceProduct();
                $in_product->invoice_id = $invoice->id;
                $in_product->product_id = $item['id'];
                $in_product->quantity = $item['quantity'];
                if(!$in_product->save()){
                    $check = false;
                }
            }
            if($check)
                return ['status' => true, 'data' => $invoice];
        }

        return ['status' => false, 'data' => null];
    }
}
