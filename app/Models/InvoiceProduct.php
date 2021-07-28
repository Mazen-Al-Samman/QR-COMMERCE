<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'invoice_id',
        'product_id'
    ];

    public function storeInvoiceProducts()
    {
        $cart = session()->get('cart');
        $total_price = 0;
        foreach ($cart as $item) {
            $total_price += $item['price'] * $item['quantity'];
        }

        $invoice_data = ['total_price' => $total_price, 'user_id'=>1, 'vendor_id' => 1];


        $data = Invoice::storeInvoice($invoice_data);
        if($data['status']){
            return $data['data'];
        }

    }
}
