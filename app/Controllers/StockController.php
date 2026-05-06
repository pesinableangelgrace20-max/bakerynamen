<?php

namespace App\Controllers;

use App\Models\ProductModel;

class StockController extends AdminBaseController
{
    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        return view('admin/pages/stock', [
            'page'     => 'stock',
            'title'    => 'Stock',
            'products' => (new ProductModel())->findAll(),
        ]);
    }
}
