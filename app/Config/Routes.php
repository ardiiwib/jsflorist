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
