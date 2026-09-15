<?php
namespace App\Controllers;

use App\Models\ProductModel;

class Product extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->findAll();
        
        $totalProduk = count($products);
        $totalStok = array_sum(array_column($products, 'qty_in_stock'));

        $data = [
            'title'        => 'Data Product',
            'products'     => $products,
            'total_produk' => $totalProduk,
            'total_stok'   => $totalStok
        ];

        return view('product/index', $data);
    }

    public function store()
    {
        $data = [
            'name'         => $this->request->getPost('name'),
            'price'        => $this->request->getPost('price'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
        ];

        $this->productModel->save($data);

        return redirect()->to(base_url('products'))->with('success', 'Product berhasil ditambahkan!');
    }

    public function update($id)
    {
        $data = [
            'name'         => $this->request->getPost('name'),
            'price'        => $this->request->getPost('price'),
            'qty_in_stock' => $this->request->getPost('qty_in_stock'),
        ];

        $this->productModel->update($id, $data);

        return redirect()->to(base_url('products'))->with('success', 'Product berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->productModel->delete($id);

        return redirect()->to(base_url('products'))->with('success', 'Product berhasil dihapus!');
    }
}