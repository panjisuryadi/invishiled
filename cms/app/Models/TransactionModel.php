<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'product_id', 'payment_method', 'qty', 'total', 'created_at'];
}