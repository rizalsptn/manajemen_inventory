<?php

namespace App\Models;

use CodeIgniter\Model;

class StockInModel extends Model
{
    protected $table = 'stock_in';
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id', 'quantity', 'received_at', 'purchase_price', 'remaining'];

    /**
     * Ambil data stok masuk bulanan untuk Chart.js
     * Output: array dengan [ 'month' => 1-12, 'total' => jumlah masuk ]
     */
    public function getMonthlyChartData()
    {
        return $this->select("MONTH(received_at) AS month, SUM(quantity) AS total")
                    ->groupBy("MONTH(received_at)")
                    ->orderBy("MONTH(received_at)", 'ASC')
                    ->findAll();
    }
}