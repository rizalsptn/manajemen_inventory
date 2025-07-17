<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
protected $table = 'orders';
protected $primaryKey = 'id';
protected $allowedFields = ['user_id', 'total_price', 'payment_status', 'order_status', 'created_at'];
protected $useTimestamps = true;
protected $createdField = 'created_at';
}