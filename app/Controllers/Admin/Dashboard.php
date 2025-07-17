<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\StockInModel;
use App\Models\StockOutModel;

class Dashboard extends BaseController
{
public function index()
{
$productModel = new ProductModel();
$orderModel = new OrderModel();
$stockInModel = new StockInModel();
$stockOutModel = new StockOutModel();

$data = [
'title' => 'Dashboard',
'totalProducts' => $productModel->countAll(),
'totalOrders' => $orderModel->countAll(),
'stockInToday' => $stockInModel->where('DATE(received_at)', date('Y-m-d'))->countAllResults(),
'stockOutToday' => $stockOutModel->where('DATE(taken_at)', date('Y-m-d'))->countAllResults(),
];

return view('admin/dashboard/index', $data);
}
}