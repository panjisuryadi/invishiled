<?php
namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\ProductModel;

class Transaction extends BaseController
{
    protected $transactionModel;
    protected $productModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('transactions');
        $builder->select('transactions.*, products.name as product_name, products.price, users.name as user_name');
        $builder->join('products', 'products.id = transactions.product_id', 'left');
        $builder->join('users', 'users.id = transactions.user_id', 'left');
        $builder->orderBy('transactions.id', 'DESC');
        $transactions = $builder->get()->getResultArray();

        $products = $this->productModel->findAll();
        
        $users = $db->table('users')->get()->getResultArray();

        // Summary
        $totalTransaksi = count($transactions);
        $totalPendapatan = array_sum(array_column($transactions, 'total'));
        $totalQty = array_sum(array_column($transactions, 'qty'));

        $data = [
            'title'            => 'Data Transaksi',
            'transactions'     => $transactions,
            'products'         => $products,
            'users'            => $users,
            'total_transaksi'  => $totalTransaksi,
            'total_pendapatan' => $totalPendapatan,
            'total_qty'        => $totalQty
        ];

        return view('transaction/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        
        $productId = $this->request->getPost('product_id');
        $userId    = $this->request->getPost('user_id');
        $jumlah    = (int) $this->request->getPost('jumlah');
        $paymentMethod = $this->request->getPost('payment_method');

        $product = $this->productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan!');
        }

        if ($product['qty_in_stock'] < $jumlah) {
            return redirect()->back()->with('error', 'Stok produk tidak mencukupi! Sisa stok: ' . $product['qty_in_stock']);
        }

        $totalHarga = $product['price'] * $jumlah;

        $db->transStart();

        $this->transactionModel->save([
            'user_id'     => $userId,
            'product_id'  => $productId,
            'qty'      => $jumlah,
            'total' => $totalHarga,
            'payment_method' => $paymentMethod,
        ]);

        $stokBaru = $product['qty_in_stock'] - $jumlah;
        $this->productModel->update($productId, [
            'qty_in_stock' => $stokBaru
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal memproses transaksi.');
        }

        return redirect()->to(base_url('transactions'))->with('success', 'Transaksi berhasil disimpan dan stok produk telah diperbarui!');
    }
}