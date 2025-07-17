<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            'categories' => $this->categoryModel->findAll()
        ];
        return view('admin/categories/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori'
        ];
        return view('admin/categories/create', $data);
    }

    public function jsonStore()
    {
        $name = $this->request->getPost('namaKategori');
    
        if (!$name) {
            return $this->response->setStatusCode(422)->setJSON(['error' => 'Nama kategori wajib diisi']);
        }
    
        $this->categoryModel->insert(['name' => $name]);
    
        return $this->response->setJSON(['status' => 'success']);
    }
    

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to('/admin/categories');
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];
        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/admin/categories');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/admin/categories');
    }

    public function jsonList()
    {
        $categories = $this->categoryModel->select('id, name')->findAll();
        return $this->response->setJSON($categories);
    }
    

}