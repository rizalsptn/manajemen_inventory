<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;

class Checkout extends BaseController
{
public function create()
{
$json = $this->request->getJSON();
$orderModel = new OrderModel();
$itemModel = new OrderItemModel();
$paymentModel = new PaymentModel();

$orderData = [
'user_id' => $json->user_id,
'total_price' => $json->total_price,
'payment_status' => 'pending',
'order_status' => 'waiting'
];
$orderId = $orderModel->insert($orderData);

foreach ($json->items as $item) {
$itemModel->insert([
'order_id' => $orderId,
'product_id' => $item->product_id,
'quantity' => $item->quantity,
'unit_price' => $item->unit_price
]);
}

$paymentModel->insert([
'order_id' => $orderId,
'method' => $json->payment_method,
'qris_url' => $json->qris_url,
'amount' => $json->total_price,
'status' => 'unpaid'
]);

return $this->response->setJSON(['status' => 'success', 'order_id' => $orderId]);
}
}