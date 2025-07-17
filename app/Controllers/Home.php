<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\OrderModel;
use App\Models\StockInModel;
use App\Models\StockOutModel;

class Home extends BaseController
{
    public function index(): string
    {
        $productModel = new ProductModel();
        $orderModel = new OrderModel();
        $stockInModel = new StockInModel();
        $stockOutModel = new StockOutModel();

        // Data untuk dashboard
        $data = [
            'title' => 'Dashboard',
            'totalProducts' => $productModel->countAll(),
            'totalOrders' => $orderModel->countAll(),
            'stockInToday' => $stockInModel->where('DATE(received_at)', date('Y-m-d'))->countAllResults(),
            'stockOutToday' => $stockOutModel->where('DATE(taken_at)', date('Y-m-d'))->countAllResults(),
            'lowStocks' => $productModel->orderBy('stock', 'ASC')->limit(5)->findAll(),
            'minStocks' => $productModel->where('stock < min_stock')->findAll(),
            'chartInData' => json_encode($stockInModel->getMonthlyChartData()),
            'chartOutData' => json_encode($stockOutModel->getMonthlyChartData())
        ];

        return view('dashboard', $data);
    }
}