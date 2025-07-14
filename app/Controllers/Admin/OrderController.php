<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ProductModel; // Untuk mendapatkan detail produk di order item

class OrderController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $productModel;

    public function __construct()
    {
        // Pastikan helper yang dibutuhkan dimuat
        helper(['form', 'url']);
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
    }

    // Menampilkan daftar semua pesanan
    public function index()
    {
        // 1. Ambil pesanan yang belum selesai dengan pagination
        $data['incomplete_orders'] = $this->orderModel
            ->where('status_pesanan !=', 'Selesai')
            ->orderBy('tanggal_pesan', 'DESC')
            ->paginate(10, 'incomplete'); // 'incomplete' adalah nama grup pager

        // 2. Ambil pesanan yang selesai hari ini
        // Menggunakan DATE(updated_at) untuk membandingkan dengan tanggal hari ini
        $data['completed_today'] = $this->orderModel
            ->where('status_pesanan', 'Selesai')
            ->where('DATE(updated_at)', 'CURDATE()', false) // false agar CURDATE() tidak di-escape
            ->orderBy('updated_at', 'DESC')
            ->findAll();

        // 3. Ambil pager
        $data['pager'] = $this->orderModel->pager;

        return view('admin/orders/index', $data);
    }


    // Menampilkan detail pesanan dan form untuk mengubah status
    public function detail($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->to(base_url('admin/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        // Ambil item-item pesanan
        $orderItems = $this->orderItemModel->where('order_id', $orderId)->findAll();

        // Ambil detail produk untuk setiap item pesanan (nama produk, gambar)
        $detailedOrderItems = [];
        foreach ($orderItems as $item) {
            $productDetails = $this->productModel->find($item['product_id']);
            if ($productDetails) {
                $item['nama_produk'] = $productDetails['nama_produk'];
                $item['gambar_url'] = $productDetails['gambar_url'];
            } else {
                $item['nama_produk'] = 'Produk Tidak Ditemukan';
                $item['gambar_url'] = ''; // Default jika gambar tidak ada
            }
            // Decode custom_details jika ada
            if (!empty($item['custom_details'])) {
                $item['custom_details_decoded'] = json_decode($item['custom_details'], true);
            } else {
                $item['custom_details_decoded'] = null;
            }
            $detailedOrderItems[] = $item;
        }

        $data['order'] = $order;
        $data['orderItems'] = $detailedOrderItems;

        // Daftar status yang bisa dipilih (sesuaikan dengan alur bisnis Anda)
        $data['availableStatuses'] = [
            'Menunggu Bukti Transfer',
            'Menunggu Verifikasi Admin',
            'Dikonfirmasi',
            'Diproses',
            'Siap Dikirim/Diambil',
            'Dalam Pengiriman',
            'Selesai',
            'Dibatalkan',
            'Dikembalikan'
        ];

        return view('admin/orders/detail', $data);
    }

    // Mengupdate status pesanan
    public function updateStatus($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        $newStatus = $this->request->getPost('status_pesanan');

        // Validasi status baru
        $availableStatuses = [
            'Menunggu Bukti Transfer',
            'Menunggu Verifikasi Admin',
            'Dikonfirmasi',
            'Diproses',
            'Siap Dikirim/Diambil',
            'Dalam Pengiriman',
            'Selesai',
            'Dibatalkan',
            'Dikembalikan'
        ];

        if (!in_array($newStatus, $availableStatuses)) {
            return redirect()->back()->with('error', 'Status yang dipilih tidak valid.');
        }

        $data = ['status_pesanan' => $newStatus];

        if ($this->orderModel->update($orderId, $data)) {
            return redirect()->to(base_url('admin/orders/detail/' . $orderId))->with('success', 'Status pesanan berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('admin/orders/detail/' . $orderId))->with('error', 'Gagal memperbarui status pesanan.');
        }
    }
}
