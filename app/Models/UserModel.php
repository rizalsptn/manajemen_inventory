<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'phone', 'email', 'password', 'role', 'created_at'];
    protected $useTimestamps = true;
}