<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // These MUST match the columns in your database
    protected $allowedFields    = ['product_id', 'product_name', 'quantity', 'total_price'];
}

