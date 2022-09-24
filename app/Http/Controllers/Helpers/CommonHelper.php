<?php


namespace App\Http\Controllers\Helpers;


class CommonHelper
{
    const CIPHERING = "AES-128-CTR";
    const ENC_DEC_OPTIONS = 0;
    const ENC_DEC_IV = "1234567891011121";
    const ENC_DEC_KEY = "MYBill";

    public function filterOtherProductSkeleton($products)
    {
        $otherProductsFields = ["name", "description", "price", "quantity", "total_price"];
        foreach ($products as $product) {
            if (!empty(array_diff_key(array_flip($otherProductsFields), $product)) && count($product) != count($otherProductsFields)) {
                return false;
            }
        }
        return true;
    }

    public function encrypt($data)
    {
        return openssl_encrypt($data, self::CIPHERING,
            self::ENC_DEC_KEY, self::ENC_DEC_OPTIONS, self::ENC_DEC_IV);
    }

    public function decrypt($encryption)
    {
        return openssl_decrypt($encryption, self::CIPHERING,
            self::ENC_DEC_KEY, self::ENC_DEC_OPTIONS, self::ENC_DEC_IV);
    }

    public function decryptInvoice(&$data)
    {
            $data['total_price'] = $this->decrypt($data['total_price']);
            $data['qr_code'] = $this->decrypt($data['qr_code']);
    }

    public function encryptInvoiceProducts($data)
    {
        return [
            'name' => $this->encrypt($data['name']),
            'description' => $this->encrypt($data['description']),
            'quantity' => $this->encrypt($data['quantity']),
            'total_price' => $this->encrypt($data['total_price']),
            'price' => $this->encrypt($data['price']),
        ];
    }

    public function decryptInvoiceProducts($data)
    {
        return [
            'id' => $data['id'],
            'invoice_id' => $data['invoice_id'],
            'name' => $this->decrypt($data['name']),
            'description' => $this->decrypt($data['description']),
            'quantity' => $this->decrypt($data['quantity']),
            'total_price' => $this->decrypt($data['total_price']),
            'price' => $this->decrypt($data['price']),
            "old_price" => 0,
            "barcode"=> null,
            "main_image"=> null,
            "category_id"=> null,
            "vendor_id"=> $data,
            'created_at' => $data['created_at'],
            'updated_at' => $data['updated_at'],
        ];
    }
}
