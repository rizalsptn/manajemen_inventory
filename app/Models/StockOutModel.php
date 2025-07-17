<?php

namespace App\Models;

use CodeIgniter\Model;

class StockOutModel extends Model
{
    protected $table = 'stock_out';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'quantity', 'taken_at'];

    /**
     * Ambil data stok keluar bulanan untuk Chart.js
     * Output: array dengan [ 'month' => 1-12, 'total' => jumlah keluar ]
     */
    public function getMonthlyChartData()
    {
        return $this->select("MONTH(taken_at) AS month, SUM(quantity) AS total")
                    ->groupBy("MONTH(taken_at)")
                    ->orderBy("MONTH(taken_at)", 'ASC')
                    ->findAll();
    }
}