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

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function storeInvoiceProducts()
    {
        if (empty(auth('vendor')->user()->vendor_id)) {
            abort(404);
        }

        $cart = session()->get('cart');
        if ($cart) {
            $total_price = 0;
            foreach ($cart as $item) {
                $total_price += $item['price'] * $item['quantity'];
            }

            $invoice_data = ['total_price' => $total_price, 'vendor_id' => auth('vendor')->user()->vendor_id];


            $data = Invoice::storeInvoice($invoice_data);
            if ($data['status']) {
                return $data['data'];
            }
        } else {
            return null;
        }

    }
}
