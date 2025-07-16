<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/dashboard', 'Home::index');
$routes->get('shop', 'Home::shop');
$routes->post('shop', 'Home::shop');
$routes->get('shop/product/(:segment)', 'Home::productDetail/$1');
$routes->get('artikel/(:num)', 'Home::artikel/$1');
$routes->get('cek-database', 'DbTest::index');
// Routes untuk Keranjang Belanja
$routes->post('cart/add', 'CartController::add'); // Untuk AJAX Add to Cart
$routes->get('cart', 'CartController::index');   // Untuk menampilkan halaman keranjang (cart.php)
$routes->post('cart/remove/(:segment)', 'CartController::remove/$1'); // Opsional: Untuk menghapus item
$routes->post('cart/update', 'CartController::update'); // Opsional: Untuk update kuantitas

// Routes untuk Permintaan Produk Kustom (SKIP CART)
$routes->post('custom/checkout', 'CustomOrderController::checkout');
$routes->post('custom/save', 'CustomOrderController::saveRequest');
// Routes untuk Checkout
$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout/process', 'CheckoutController::processOrder');
$routes->post('checkout/estimateShipping', 'CheckoutController::estimateShipping');
$routes->get('checkout/qris/(:num)', 'CheckoutController::showQrisPage/$1');
$routes->get('order-success/(:num)', 'CheckoutController::orderSuccess/$1'); // Halaman sukses setelah checkout
$routes->get('track-order', 'OrderTracking::index'); // Form pelacakan
$routes->post('track-order/track', 'OrderTracking::track'); // Memproses pelacakan
// Routes untuk Pembayaran
$routes->get('payment/bank-transfer/(:num)', 'Payment::showBankTransfer/$1'); // Halaman detail rekening & upload bukti
$routes->post('payment/upload-proof', 'Payment::uploadProof'); // Endpoint untuk upload bukti transfer
$routes->get('artikel', 'Home::allArticles');

$routes->group('admin', function($routes) {
    $routes->get('orders', 'Admin\OrderController::index');
    $routes->get('orders/detail/(:num)', 'Admin\OrderController::detail/$1');
   $routes->post('orders/updateStatus/(:num)', 'Admin\OrderController::updateStatus/$1');
    $routes->get('custom-requests', 'Admin\CustomRequestController::index');
    $routes->post('custom-requests/update-status/(:num)', 'Admin\CustomRequestController::updateStatus/$1');
    // Rute placeholder untuk Pendapatan dan Produk
// Anda perlu membuat Admin\RevenueController
$routes->get('products/analysis', 'Admin\OrderController::productAnalysis'); // <-- TAMBAHKAN INI
    $routes->get('products', 'Admin\ProductController::index'); // Anda perlu membuat Admin\ProductController
     $routes->get('products', 'Admin\ProductController::index');
    $routes->get('products/create', 'Admin\ProductController::create');
    $routes->post('products/store', 'Admin\ProductController::store');
    $routes->get('products/edit/(:segment)', 'Admin\ProductController::edit/$1');
    $routes->post('products/update/(:segment)', 'Admin\ProductController::update/$1');
    $routes->get('products/delete/(:num)', 'Admin\ProductController::delete/$1');// Untuk menyimpan produk baru
     $routes->get('dashboard', 'Admin\DashboardController::dashboard'); // Atau 'Admin\DashboardController::index' jika pakai controller baru
    // $routes->get('dashboard', 'Admin\Orders::dashboard'); // Alias
       $routes->get('revenue', 'Admin\OrderController::revenue'); 
});
