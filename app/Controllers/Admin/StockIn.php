<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\StockInModel;
use App\Models\ProductModel;

class StockIn extends BaseController
{
    protected $stockInModel;
    protected $productModel;

    public function __construct()
    {
        $this->stockInModel = new StockInModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Stok Masuk',
            'stocks' => $this->stockInModel
                ->select('stock_in.*, products.name as product_name')
                ->join('products', 'products.id = stock_in.product_id')
                ->orderBy('stock_in.received_at', 'DESC')
                ->findAll(),
            'products' => $this->productModel->findAll()
        ];

        return view('stockin', $data);
    }

    // Optional, redirect ke index aja
    public function create()
    {
        return redirect()->to('/admin/stock-in');
    }

    public function store()
    {
        $productId = $this->request->getPost('product_id');
        $quantity  = (int) $this->request->getPost('quantity');
        $price     = $this->request->getPost('purchase_price');

        $this->stockInModel->save([
            'product_id'      => $productId,
            'quantity'        => $quantity,
            'purchase_price'  => $price,
            'remaining'       => $quantity,
            'received_at'     => date('Y-m-d H:i:s')
        ]);

        $this->productModel->increment('stock', $quantity, ['id' => $productId]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['message' => 'Data berhasil disimpan']);
        }        
        return redirect()->to('/admin/stock-in');
    }
    
    public function edit($id)
{
    $stock = $this->stockInModel->find($id);
    if (!$stock) {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Data tidak ditemukan']);
    }

    return $this->response->setJSON($stock);
}

public function update($id)
{
    $productId = $this->request->getPost('product_id');
    $quantity = $this->request->getPost('quantity');
    $price = $this->request->getPost('purchase_price');

    // Ambil data lama untuk menyesuaikan stok
    $oldData = $this->stockInModel->find($id);
    if (!$oldData) {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Data tidak ditemukan']);
    }

    // Update stok produk → kurangi stok lama, tambahkan stok baru
    $this->productModel->set('stock', 'stock - ' . $oldData['quantity'], false)
        ->where('id', $oldData['product_id'])
        ->update();

    $this->productModel->set('stock', 'stock + ' . $quantity, false)
        ->where('id', $productId)
        ->update();

    $this->stockInModel->update($id, [
        'product_id' => $productId,
        'quantity' => $quantity,
        'purchase_price' => $price,
        'remaining' => $quantity
    ]);

    return $this->response->setJSON(['message' => 'Stok masuk berhasil diperbarui']);
}

public function delete($id)
{
    $stock = $this->stockInModel->find($id);
    if (!$stock) {
        return $this->response->setStatusCode(404)->setJSON(['error' => 'Data tidak ditemukan']);
    }

    // Kurangi stok produk
    $this->productModel->set('stock', 'stock - ' . $stock['quantity'], false)
        ->where('id', $stock['product_id'])
        ->update();

    $this->stockInModel->delete($id);

    return $this->response->setJSON(['message' => 'Data stok masuk berhasil dihapus']);
}

    
}