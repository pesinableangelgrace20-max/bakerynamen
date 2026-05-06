<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SaleModel;

class SaleController extends AdminBaseController
{
    protected ProductModel $pModel;
    protected SaleModel $sModel;

    public function __construct()
    {
        $this->pModel = new ProductModel();
        $this->sModel = new SaleModel();
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $date   = $this->request->getGet('date');
        $sModel = new SaleModel();

        if ($date !== null && $date !== '') {
            $sModel->where('created_at >=', $date . ' 00:00:00')
                ->where('created_at <=', $date . ' 23:59:59');
        }

        return view('admin/pages/sales', [
            'page'      => 'sales',
            'title'     => 'Sales',
            'products'  => $this->pModel->findAll(),
            'sales'     => $sModel->orderBy('id', 'DESC')->paginate(20),
            'pager'     => $sModel->pager,
            'filter_dt' => $date ?? '',
        ]);
    }

    public function store()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'quantity'   => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $productId = (int) $this->request->getPost('product_id');
        $quantity  = (int) $this->request->getPost('quantity');

        $product = $this->pModel->find($productId);
        if (! $product) {
            return redirect()->to('/admin/sales')->with('error', 'Product not found.');
        }

        $unitPrice = (float) $product['price'];
        $total     = $unitPrice * $quantity;

        $db = db_connect();
        $db->transStart();

        $db->table('products')
            ->where('id', $productId)
            ->where('stock >=', $quantity)
            ->set('stock', 'stock - ' . $quantity, false)
            ->update();

        if ($db->affectedRows() === 0) {
            $db->transRollback();

            return redirect()->to('/admin/sales')->with('error', 'Not enough stock!');
        }

        $this->sModel->insert([
            'product_id'   => $productId,
            'product_name' => $product['name'],
            'quantity'     => $quantity,
            'unit_price'   => $unitPrice,
            'total_price'  => $total,
            'cashier_id'   => session()->get('id'),
        ]);

        $saleId = (int) $this->sModel->getInsertID();

        if ($db->transComplete() === false || ! $saleId) {
            return redirect()->to('/admin/sales')->with('error', 'Sale could not be completed. Please try again.');
        }

        return redirect()->to('/admin/sales/receipt/' . $saleId)->with('success', 'Sale completed!');
    }

    public function receipt($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $sale = $this->sModel->find($id);
        if (! $sale) {
            return redirect()->to('/admin/sales')->with('error', 'Receipt not found.');
        }

        return view('admin/pages/receipt', [
            'page'  => 'sales',
            'title' => 'Receipt',
            'sale'  => $sale,
        ]);
    }

    public function delete($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $sale = $this->sModel->find($id);
        if (! $sale) {
            return redirect()->to('/admin/sales')->with('error', 'Sale not found.');
        }

        $productId = (int) ($sale['product_id'] ?? 0);
        $quantity  = (int) ($sale['quantity'] ?? 0);

        $db = db_connect();
        $db->transStart();

        if ($productId > 0 && $quantity > 0) {
            $db->table('products')
                ->where('id', $productId)
                ->set('stock', 'stock + ' . $quantity, false)
                ->update();
        }

        $this->sModel->delete($id);

        if ($db->transComplete() === false) {
            return redirect()->to('/admin/sales')->with('error', 'Could not delete sale. Please try again.');
        }

        return redirect()->to('/admin/sales')->with('success', 'Sale removed.');
    }
}
