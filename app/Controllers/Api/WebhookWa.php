<?php


namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\PaymentModel;

class QrisPayment extends BaseController
{
    public function generate()
    {
        $json = $this->request->getJSON();

        $amount = $json->amount;
        $qris_url = 'https://dummy-qris.com/qr/' . uniqid();

        return $this->response->setJSON([
            'status' => 'success',
            'qris_url' => $qris_url,
            'amount' => $amount
        ]);
    }
}