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

    public static function storeInvoice($data)
    {
        $invoice = new Invoice();
        $invoice->total_price = $data['total_price'];
        $invoice->user_id = $data['user_id'];
        $invoice->vendor_id = $data['vendor_id'];
        if($invoice->save()) {
            $cart = session()->get('cart');
            $check = true;
            foreach ($cart as $item) {
                $in_product = new InvoiceProduct();
                $in_product->invoice_id = $invoice->id;
                $in_product->product_id = $item['id'];
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
