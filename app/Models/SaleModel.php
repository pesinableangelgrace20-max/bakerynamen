<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $useSoftDeletes   = true;
    protected $dateFormat       = 'datetime';
    protected $createdField     = 'created_at';
    protected $updatedField     = '';
    protected $deletedField     = 'deleted_at';

    protected $allowedFields = [
        'product_id',
        'product_name',
        'quantity',
        'unit_price',
        'total_price',
        'cashier_id',
        'deleted_at',
    ];
}
