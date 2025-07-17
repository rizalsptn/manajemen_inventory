<?php


namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StockOutModel;
use App\Models\StockInModel;
use App\Models\ProductModel;

class StockOut extends BaseController
{
    protected $stockOutModel;
    protected $stockInModel;
    protected $productModel;

    public function __construct()
    {
        $this->stockOutModel = new StockOutModel();
        $this->stockInModel = new StockInModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Stok Keluar',
            'stocks' => $this->stockOutModel->select('stock_out.*, products.name as product_name')
                ->join('products', 'products.id = stock_out.product_id')
                ->orderBy('stock_out.taken_at', 'DESC')
                ->findAll()
        ];
        return view('admin/stock_out/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Stok Keluar',
            'products' => $this->productModel->findAll()
        ];
        return view('admin/stock_out/create', $data);
    }

    public function store()
    {
        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');

        $remainingQty = $quantity;
        $stockInBatches = $this->stockInModel->where('product_id', $productId)->where('remaining >', 0)->orderBy('received_at', 'ASC')->findAll();

        foreach ($stockInBatches as $batch) {
            if ($remainingQty <= 0) break;

            $deductQty = min($remainingQty, $batch['remaining']);

            $this->stockOutModel->save([
                'product_id' => $productId,
                'stock_in_id' => $batch['id'],
                'quantity' => $deductQty
            ]);

            $this->stockInModel->update($batch['id'], [
                'remaining' => $batch['remaining'] - $deductQty
            ]);

            $remainingQty -= $deductQty;
        }

        // Update stock produk
        $this->productModel->decrement('stock', $quantity, ['id' => $productId]);

        return redirect()->to('/admin/stock-out');
    }
}