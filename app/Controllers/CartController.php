<?php

namespace App\Controllers;

use App\Models\ProductModel; // Pastikan ini di-import

class CartController extends BaseController
{
    public function __construct()
    {
        // Memuat helper 'url' dan 'session' jika belum dimuat secara global
        helper(['url', 'session']);
    }

    // Method untuk menambahkan produk ke keranjang
    public function add()
    {
        $session = session();
        $request = \Config\Services::request();
        $productModel = new ProductModel();

        $productId = $request->getPost('product_id');
        $quantity = $request->getPost('quantity') ?? 1; // Default quantity 1

        // --- START: MODIFIKASI VALIDASI ID PRODUK ---
        // Validasi input productId: Pastikan tidak kosong dan bukan string kosong setelah trim
        if (empty($productId) || trim($productId) === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Produk tidak valid (kosong).'
            ]);
        }
        // Jika Anda ingin membatasi format ID produk (misal: hanya menerima PRDKXX)
        // Anda bisa tambahkan regex di sini. Contoh:
        // if (!preg_match('/^[A-Z]{4}\d{2}$/', $productId)) { // Contoh regex untuk format PRDK01
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'message' => 'Format ID Produk tidak valid.'
        //     ]);
        // }
        // --- END: MODIFIKASI VALIDASI ID PRODUK ---


        // Validasi kuantitas: Pastikan numerik dan lebih dari 0
        if (!is_numeric($quantity) || (int)$quantity < 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Kuantitas tidak valid.'
            ]);
        }
        $quantity = (int)$quantity; // Pastikan kuantitas adalah integer

        // Ambil detail produk dari database menggunakan ProductModel
        // find() akan mencari berdasarkan primaryKey, yang di ProductModel Anda adalah 'product_id'
        // Karena ProductModel Anda menggunakan primaryKey 'product_id', dan itu sesuai dengan kolom database
        // maka find() akan bekerja dengan baik meskipun ID-nya string.
        $product = $productModel->find($productId);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan.'
            ]);
        }

        // Ambil keranjang dari session, atau inisialisasi jika belum ada
        $cart = $session->get('cart') ?? [];

        // Cek apakah produk sudah ada di keranjang
        if (isset($cart[$productId])) {
            // Jika sudah ada, tambahkan kuantitasnya
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            $cart[$productId] = [
                'id'       => $product['product_id'],   // Ini akan menyimpan 'PRDK01' di session
                'name'     => $product['nama_produk'],
                'price'    => (float)$product['harga'],
                'quantity' => $quantity,
                'image'    => $product['gambar_url']
            ];
        }

        // Simpan kembali keranjang ke session
        $session->set('cart', $cart);

        // Hitung total item di keranjang (opsional, untuk update ikon keranjang)
        $totalItemsInCart = 0;
        foreach ($cart as $item) {
            $totalItemsInCart += $item['quantity'];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $product['nama_produk'] . ' berhasil ditambahkan ke keranjang!',
            'cart_total_items' => $totalItemsInCart
        ]);
    }

    // Method untuk menampilkan halaman keranjang belanja
    public function index()
    {
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        return view('cart', $data); // Memuat view cart.php
    }

    // Opsional: Method untuk menghapus item dari keranjang
    public function remove($productId) // productId di sini juga akan berupa string
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            $session->set('cart', $cart);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Produk berhasil dihapus dari keranjang.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan di keranjang.'
        ]);
    }

    // Opsional: Method untuk mengupdate kuantitas item di keranjang
    public function update()
    {
        $session = session();
        $request = \Config\Services::request();
       $productId = $request->getPost('product_id');
    $quantity = $request->getPost('quantity');

    $cart = $session->get('cart') ?? [];

    // Debug langsung isi variabel
    // dd([
    //     'productId_from_post' => $productId,
    //     'quantity_from_post' => $quantity,
    //     'cart_from_session' => $cart,
    //     'isset_check' => isset($cart[$productId]), // Ini yang kita ingin tahu hasilnya TRUE/FALSE
    //     'cart_keys' => array_keys($cart) // Lihat kunci-kunci yang ada di $cart
    // ]);


        // Validasi input productId
        // if (empty($productId) || trim($productId) === '') {
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'message' => 'ID Produk tidak valid (kosong).'
        //     ]);
        // }
        // // Validasi kuantitas
        // if (!is_numeric($quantity) || (int)$quantity < 1) {
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'message' => 'Kuantitas tidak valid.'
        //     ]);
        // }
        $quantity = (int)$quantity;

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            $session->set('cart', $cart);
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Kuantitas produk berhasil diperbarui.'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Produk tidak ditemukan di keranjang.'
        ]);
    }
}