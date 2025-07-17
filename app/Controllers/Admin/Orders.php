<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;

class Orders extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pesanan',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->findAll()
        ];
        return view('admin/orders/index', $data);
    }

    public function detail($id)
    {
        $order = $this->orderModel->find($id);
        if (!$order) return redirect()->to('/admin/orders');

        $items = $this->orderItemModel->where('order_id', $id)->findAll();

        $data = [
            'title' => 'Detail Pesanan',
            'order' => $order,
            'items' => $items
        ];
        return view('admin/orders/detail', $data);
    }
}