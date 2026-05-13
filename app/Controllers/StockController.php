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

        $today = date('Y-m-d');
        $pModel = new ProductModel();
        
        $active = $pModel->where('expiry_date >=', $today)
                         ->orWhere('expiry_date', null)
                         ->orderBy('name', 'ASC')
                         ->findAll();
                         
        $expired = $pModel->where('expiry_date <', $today)
                          ->orderBy('name', 'ASC')
                          ->findAll();

        return view('admin/pages/stock', [
            'page'            => 'stock',
            'title'           => 'Stock',
            'active_products' => $active,
            'expired_products' => $expired,
        ]);
    }

    public function clearExpired()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $today = date('Y-m-d');
        $pModel = new ProductModel();
        
        $pModel->where('expiry_date <', $today)->delete();

        return redirect()->to('/admin/stock')->with('success', 'All expired products have been removed from inventory.');
    }
}
