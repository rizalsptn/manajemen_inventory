<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
protected $table = 'payments';
protected $primaryKey = 'id';
protected $allowedFields = ['order_id', 'method', 'qris_url', 'amount', 'status', 'paid_at'];
protected $useTimestamps = true;
protected $createdField = 'paid_at';
}