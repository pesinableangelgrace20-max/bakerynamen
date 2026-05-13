<?php

namespace App\Controllers;

use App\Models\ProductModel;

class ProductController extends AdminBaseController
{
    protected ProductModel $pModel;

    public function __construct()
    {
        $this->pModel = new ProductModel();
    }

    public function index()
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $q     = $this->request->getGet('q');
        $pModel = new ProductModel();

        if ($q !== null && $q !== '') {
            $pModel->like('name', $q);
        }

        return view('admin/pages/products', [
            'page'     => 'products',
            'title'    => 'Products',
            'products' => $pModel->orderBy('name', 'ASC')->findAll(),
            'search_q' => $q ?? '',
        ]);
    }

    public function store()
    {
        if ($r = $this->requireLogin()) {
            return $r;
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[255]',
            'price' => 'required|numeric|greater_than_equal_to[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
            'expiry_date' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->pModel->save([
            'name'  => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
        ]);

        return redirect()->to('/admin/products')->with('success', 'Product added!');
    }

    public function edit($id)
    {
        if ($redirect = $this->requireLogin()) {
            return $redirect;
        }

        $product = $this->pModel->find($id);
        if (! $product) {
            return redirect()->to('/admin/products')->with('error', 'Product not found.');
        }

        return view('admin/pages/edit_product', [
            'page'    => 'products',
            'title'   => 'Edit Product',
            'product' => $product,
        ]);
    }

    public function update($id)
    {
        if ($r = $this->requireLogin()) {
            return $r;
        }

        $rules = [
            'name'  => 'required|min_length[2]|max_length[255]',
            'price' => 'required|numeric|greater_than_equal_to[0]',
            'stock' => 'required|integer|greater_than_equal_to[0]',
            'expiry_date' => 'permit_empty|valid_date[Y-m-d]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->validator->getErrors()));
        }

        $this->pModel->update($id, [
            'name'  => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'expiry_date' => $this->request->getPost('expiry_date') ?: null,
        ]);

        return redirect()->to('/admin/products')->with('success', 'Product updated!');
    }

    public function delete($id)
    {
        if ($r = $this->requireLogin()) {
            return $r;
        }

        $this->pModel->delete($id);

        return redirect()->to('/admin/products')->with('success', 'Product deleted!');
    }
}
