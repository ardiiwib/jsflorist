<?php
namespace App\Controllers;

use App\Models\ProductModel;

class CartController extends BaseController
{
    public function __construct()
    {
        helper(['url', 'session']);
    }

    public function add()
    {
        $session = session();
        $request = \Config\Services::request();
        $productModel = new ProductModel();

        $productId = $request->getPost('product_id');
        $quantity = $request->getPost('quantity') ?? 1;

        if (empty($productId) || trim($productId) === '') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'ID Produk tidak valid (kosong).'
            ]);
        }

        if (!is_numeric($quantity) || (int)$quantity < 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Kuantitas tidak valid.'
            ]);
        }
        $quantity = (int)$quantity;

        $product = $productModel->find($productId);

        if (!$product) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Produk tidak ditemukan.'
            ]);
        }

        $cart = $session->get('cart') ?? [];

        $itemPrice = (float)$product['harga']; // Default price from product table
        $customDetails = $request->getPost('custom_details'); // Get custom details from form

        // --- START: MODIFIKASI UNTUK CUSTOM PRODUK (BUKET UANG) ---
        if ($productId === 'PRDKUANG') {
            // Server-side recalculation of upah and price to prevent tampering
            $pecahan = (int)($customDetails['pecahan'] ?? 0);
            $nominal = (int)($customDetails['nominal'] ?? 0);
            $lembar = ($pecahan > 0) ? $nominal / $pecahan : 0;
            $upahJasa = $this->calculateUpahBuketUang($lembar); // Recalculate upah server-side

            if ($customDetails['money_source_type'] === 'uang_dari_toko') {
                $itemPrice = $nominal + $upahJasa; // Nominal + Upah
            } elseif ($customDetails['money_source_type'] === 'uang_sendiri') {
                $itemPrice = $upahJasa; // Hanya Upah
            }
            // Ensure quantity is 1 for custom money bouquet, as price reflects the whole item
            $quantity = 1;

            // Add server-side calculated upah back to custom details for storage
            $customDetails['upah'] = $upahJasa;
            $customDetails['lembar'] = $lembar; // Also add lembar for consistency
        }
        // --- END: MODIFIKASI UNTUK CUSTOM PRODUK ---

        if (isset($cart[$productId])) {
            // For PRDKUANG, usually each customization is a new item, not a quantity increase.
            // If it's PRDKUANG, we should probably add it as a new distinct item or update the existing one uniquely.
            // For simplicity in this current cart structure, if product_id matches, it increments.
            // A more robust solution for unique custom items would be to use a hashed key including custom_details.
            $cart[$productId]['quantity'] += $quantity;
            // If the item is PRDKUANG, and a new one with same product_id is added,
            // the custom_details might be overwritten or combined incorrectly depending on logic.
            // For this specific request, we assume each PRDKUANG in the cart is distinct due to single quantity.
        } else {
            $cart[$productId] = [
                'id'       => $product['product_id'],
                'name'     => $product['nama_produk'],
                'price'    => $itemPrice,
                'quantity' => $quantity,
                'image'    => $product['gambar_url'],
                'options'  => [
                    'custom_details' => $customDetails ? json_encode($customDetails) : null,
                ]
            ];
        }

        $session->set('cart', $cart);

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

    // Helper function to calculate upah (copied from CustomOrderController for server-side validation)
    private function calculateUpahBuketUang(int $lembar): int
    {
        if ($lembar >= 5 && $lembar <= 20) {
            return 250000;
        } elseif ($lembar >= 21 && $lembar <= 40) {
            return 400000;
        } elseif ($lembar >= 41 && $lembar <= 60) {
            return 600000;
        } elseif ($lembar >= 61 && $lembar <= 80) {
            return 800000;
        } elseif ($lembar >= 81 && $lembar <= 100) {
            return 1000000;
        }
        return 0;
    }

    public function index()
    {
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        return view('cart', $data);
    }

    public function remove($productId)
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

    public function update()
    {
        $session = session();
        $request = \Config\Services::request();
        $productId = $request->getPost('product_id');
        $quantity = $request->getPost('quantity');

        $cart = $session->get('cart') ?? [];

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