<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('stockin', 'Admin\StockIn::index');
$routes->post('stockin', 'Admin\StockIn::create');
$routes->post('stockin', 'Admin\StockIn::store');
$routes->get('products', 'Admin\Products::index');         // menampilkan semua produk
$routes->get('products/create', 'Admin\Products::create'); // form tambah
$routes->post('products/store', 'Admin\Products::store');  // proses simpan
$routes->get('products/edit/(:num)', 'Admin\Products::edit/$1');
$routes->put('products/update/(:num)', 'Admin\Products::update/$1');
$routes->delete('products/delete/(:num)', 'Admin\Products::delete/$1');
$routes->get('admin/categories/jsonList', 'Admin\Categories::jsonList');
$routes->get('admin/products/jsonstore', 'Admin\Products::jsonStore');
$routes->post('admin/categories/jsonStore', 'Admin\Categories::jsonStore');

// Untuk update kategori (bisa digabung jsonStore juga, jika tanpa perbedaan)
$routes->post('admin/categories/update/(:num)', 'Admin\Categories::update/$1');

// Untuk hapus kategori
$routes->delete('admin/categories/delete/(:num)', 'Admin\Categories::delete/$1');// Route stock in
$routes->get('admin/stock-in', 'Admin\StockIn::index');        // Tampilkan tabel stok masuk
$routes->post('admin/stock-in/store', 'Admin\StockIn::store'); // Simpan data stok masuk

// Optional jika kamu pakai create page terpisah
$routes->get('admin/stock-in/create', 'Admin\StockIn::create');
$routes->get('admin/stock-in/edit/(:num)', 'Admin\StockIn::edit/$1');
$routes->post('admin/stock-in/update/(:num)', 'Admin\StockIn::update/$1');
$routes->delete('admin/stock-in/delete/(:num)', 'Admin\StockIn::delete/$1');