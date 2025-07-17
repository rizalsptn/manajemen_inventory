<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Produk',
            'products' => $this->productModel->select('products.*, categories.name as category_name')
                ->join('categories', 'categories.id = products.category_id', 'left')
                ->findAll(),
        ];
        return view('products', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'categories' => $this->categoryModel->findAll()
        ];
        return view('products/create', $data);
    }

    public function store()
    {
        helper(['form', 'url']);
    
        // Validasi minimal dulu
        $validationRules = [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
        ];
    
        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'message' => $this->validator->getErrors(),
            ]);
        }
    
        // Ambil file gambar (nama field-nya harus sesuai form)
        $image = $this->request->getFile('gambarProduk');
        $imageName = null;
    
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads', $imageName);
        }
    
        $this->productModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'min_stock' => $this->request->getPost('min_stock'),
            'image' => $imageName,
        ]);
    
        return $this->response->setJSON(['message' => 'Produk berhasil disimpan']);
    }    

    public function jsonStore()
{
    $products = $this->productModel
        ->select('products.*, categories.name as category_name')
        ->join('categories', 'categories.id = products.category_id', 'left')
        ->findAll();

    return $this->response->setJSON($products);
}


    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to('/products');
        }
        $data = [
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => $this->categoryModel->findAll()
        ];
        return view('products/edit', $data);
    }

    public function update($id)
    {
        // Kalau _method dari POST adalah PUT, kita tetap jalan di sini
        helper(['form', 'url']);
    
        $validationRules = [
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
        ];
    
        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => $this->validator->getErrors(),
            ]);
        }
    
        $image = $this->request->getFile('gambarProduk');
        $imageName = null;
    
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $imageName = $image->getRandomName();
            $image->move(FCPATH . 'uploads', $imageName);
        }
    
        $dataUpdate = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'category_id' => $this->request->getPost('category_id'),
            'min_stock' => $this->request->getPost('min_stock'),
        ];
    
        if ($imageName) {
            $dataUpdate['image'] = $imageName;
        }
    
        $this->productModel->update($id, $dataUpdate);
    
        return $this->response->setJSON(['message' => 'Produk berhasil diperbarui']);
        return redirect()->to('/products');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);
        return $this->response->setJSON(['message' => 'Produk berhasil dihapus']);
    }
}