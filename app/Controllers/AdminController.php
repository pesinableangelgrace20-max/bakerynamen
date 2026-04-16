<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\UserModel;

class AdminController extends BaseController
{
    protected $pModel;
    protected $sModel;

    public function __construct() {
        $this->pModel = new ProductModel();
        $this->sModel = new SaleModel();
    }

    public function index() {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        
        $data = [
            'page'     => 'products',
            'products' => $this->pModel->findAll(),
        ];
        return view('admin/dashboard', $data);
    }

    // PRODUCT CRUD
    public function storeProduct() {
        $this->pModel->save([
            'name'  => $this->request->getVar('name'),
            'price' => $this->request->getVar('price'),
            'stock' => $this->request->getVar('stock'),
        ]);
        return redirect()->to('/admin')->with('success', 'Product added!');
    }

    public function editProduct($id) {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        $data['product'] = $this->pModel->find($id);
        return view('admin/edit_product', $data);
    }

    public function updateProduct($id) {
        $this->pModel->update($id, [
            'name'  => $this->request->getVar('name'),
            'price' => $this->request->getVar('price'),
            'stock' => $this->request->getVar('stock'),
        ]);
        return redirect()->to('/admin')->with('success', 'Product updated!');
    }

    public function deleteProduct($id) {
        $this->pModel->delete($id);
        return redirect()->to('/admin')->with('success', 'Product deleted!');
    }

    // SECTIONS
    public function stock() { 
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        return view('admin/dashboard', ['page'=>'stock', 'products'=>$this->pModel->findAll()]); 
    }

    public function sales() { 
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        return view('admin/dashboard', [
            'page'     => 'sales', 
            'products' => $this->pModel->findAll(),
            'sales'    => $this->sModel->orderBy('id', 'DESC')->findAll()
        ]); 
    }

    // THE FIX FOR STORE SALE
    public function storeSale() {
        $productId = $this->request->getVar('product_id');
        $quantity  = (int) $this->request->getVar('quantity');

        if (!$productId || $quantity <= 0) {
            return redirect()->to('/admin/sales')->with('error', 'Invalid input.');
        }

        $product = $this->pModel->find($productId);

        if ($product) {
            if ($product['stock'] >= $quantity) {
                $totalPrice = $product['price'] * $quantity;

                // 1. Save Sale
                $saleData = [
                    'product_id'   => $productId,
                    'product_name' => $product['name'],
                    'quantity'     => $quantity,
                    'total_price'  => $totalPrice
                ];
                
                $this->sModel->insert($saleData);

                // 2. Update Stock
                $newStock = $product['stock'] - $quantity;
                $this->pModel->update($productId, ['stock' => $newStock]);

                return redirect()->to('/admin/sales')->with('success', 'Sale completed!');
            }
            return redirect()->to('/admin/sales')->with('error', 'Not enough stock!');
        }
        return redirect()->to('/admin/sales')->with('error', 'Product not found.');
    }

    public function reports() { 
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        $sales = $this->sModel->findAll();
        $revenue = 0; $items_sold = 0;
        foreach ($sales as $s) {
            $revenue += $s['total_price'];
            $items_sold += $s['quantity'];
        }
        return view('admin/dashboard', [
            'page'=>'reports', 
            'revenue'=>$revenue, 
            'items_sold'=>$items_sold
        ]); 
    }

    public function users() { 
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');
        return view('admin/dashboard', ['page'=>'users', 'users'=>(new UserModel())->findAll()]); 
    }
}