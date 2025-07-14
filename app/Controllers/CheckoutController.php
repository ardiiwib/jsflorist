<?php
namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\UserModel;
use App\Models\ProductModel; // Ditambahkan: Untuk mendapatkan detail produk
use App\Models\CategoryModel; // Ditambahkan: Untuk mendapatkan kategori

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class CheckoutController extends BaseController
{
    protected $orderModel;
    protected $orderItemModel;
    protected $userModel;
    protected $productModel; // Inisialisasi ProductModel
    protected $categoryModel; // Inisialisasi CategoryModel
    protected $session;
    protected $request;
    protected $db;

    // Lokasi toko Anda (Latitude dan Longitude)
    // GANTI DENGAN KOORDINAT TOKO JS FLORIST ANDA YANG SEBENARNYA
    const STORE_LATITUDE = -3.4398799; // Contoh: Banjarbaru (sesuaikan)
    const STORE_LONGITUDE = 114.8332947; // Contoh: Banjarbaru (sesuaikan)

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        helper(['url', 'session']);

        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel(); // Inisialisasi
        $this->categoryModel = new CategoryModel(); // Inisialisasi
        $this->session = session();
        $this->request = \Config\Services::request();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $cartItems = $this->session->get('cart') ?? [];

        if (empty($cartItems)) {
            log_message('debug', 'Keranjang kosong saat akses checkout. Redirect ke halaman keranjang.');
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang belanja Anda kosong, tidak dapat melanjutkan ke checkout.');
        }

        $data['cartItems'] = $cartItems;
        $data['loggedInUser'] = null;

        if ($this->session->has('user_id')) {
            $userId = $this->session->get('user_id');
            $loggedInUser = $this->userModel->find($userId);
            if ($loggedInUser) {
                $data['loggedInUser'] = $loggedInUser;
                log_message('debug', 'User login ditemukan: ' . $loggedInUser['email']);
            } else {
                log_message('debug', 'User ID di session tidak ditemukan di database.');
            }
        } else {
            log_message('debug', 'User tidak login saat akses checkout.');
        }

        $subtotalProduk = 0;
        foreach ($cartItems as $item) {
            $subtotalProduk += $item['price'] * $item['quantity'];
        }
        $data['subtotalProduk'] = $subtotalProduk;


        // Hitung biaya pengiriman awal (misal, untuk menampilkan di ringkasan checkout)
        // Ini adalah estimasi awal, perhitungan final saat processOrder()
        $data['estimated_shipping_cost'] = 0;
        $data['distance_km'] = 0;

        // Jika ada koordinat lama dari old() atau profil user, bisa dihitung di sini
        $tempLat = old('alamat_latitude');
        $tempLng = old('alamat_longitude');
        if (!empty($tempLat) && !empty($tempLng)) {
            $data['distance_km'] = $this->calculateHaversineDistance(
                self::STORE_LATITUDE, self::STORE_LONGITUDE,
                (float)$tempLat, (float)$tempLng
            );
            $data['estimated_shipping_cost'] = $this->getShippingCostByDistance($data['distance_km'], $cartItems);
        }

        return view('checkout', $data);
    }

    /**
     * Menghitung jarak garis lurus (Haversine Formula) antara dua titik koordinat.
     * Mengembalikan jarak dalam kilometer.
     */
     private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2) {
        $R = 6371; // Radius bumi dalam kilometer

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = $R * $c; // Jarak dalam KM
        log_message('debug', "Jarak Haversine dihitung: {$distance} km antara ({$lat1},{$lon1}) dan ({$lat2},{$lon2})");
        return $distance;
    }

    private function getShippingCostByDistance($distanceKm, $cartItems) {
        $cost = 0;
        $hasBungaPapan = false;

        $bungaPapanCategoryNames = ['Wedding']; // Ganti dengan nama kategori bunga papan yang ada di DB Anda

        $bungaPapanCategories = $this->categoryModel->whereIn('nama_kategori', $bungaPapanCategoryNames)->findAll();
        $bungaPapanCategoryIds = array_column($bungaPapanCategories, 'category_id');

        if (!empty($bungaPapanCategoryIds)) {
            foreach ($cartItems as $item) {
                // Ensure product details are available for cart items to check category_id
                $productDetails = $this->productModel->find($item['id']);
                if ($productDetails && in_array($productDetails['category_id'], $bungaPapanCategoryIds)) {
                    $hasBungaPapan = true;
                    break;
                }
            }
        }

        log_message('debug', 'START Perhitungan Ongkir: Jarak: ' . $distanceKm . ' km. Ada Bunga Papan: ' . ($hasBungaPapan ? 'YA' : 'TIDAK'));

        // Aturan Ongkir:
        if ($hasBungaPapan) {
            log_message('debug', 'Logika Bunga Papan Aktif.');
            if ($distanceKm >= 16) { // >15km
                $cost = 100000;
                log_message('debug', 'Bunga Papan: Jarak >= 16km, Ongkir: 100000');
            } else { // <= 15km, gratis ongkir untuk bunga papan
                $cost = 0;
                log_message('debug', 'Bunga Papan: Jarak < 16km, Ongkir: 0 (Gratis)');
            }
        } else {
            log_message('debug', 'Logika Ongkir Normal Aktif.');
            // Perbaiki urutan dan kondisi ini
            if ($distanceKm > 15) { // Jarak > 15km (range tertinggi)
                $cost = 100000;
                log_message('debug', 'Normal: >15 km, Ongkir: 100000');
            } elseif ($distanceKm >= 11) { // Jarak 11-15 km
                $cost = 50000;
                log_message('debug', 'Normal: 11-15 km, Ongkir: 50000');
            } elseif ($distanceKm >= 6) { // Jarak 6-10 km
                $cost = 30000;
                log_message('debug', 'Normal: 6-10 km, Ongkir: 30000');
            } elseif ($distanceKm >= 1) { // Jarak 1-5 km
                $cost = 20000;
                log_message('debug', 'Normal: 1-5 km, Ongkir: 20000');
            } else { // Jika jarak < 1 km atau 0 km
                $cost = 0;
                log_message('debug', 'Normal: Jarak < 1 km, Ongkir: 0');
            }
        }
        log_message('debug', 'END Perhitungan Ongkir. Hasil akhir: ' . $cost);
        return $cost;
    }



    public function processOrder()
    {
        log_message('debug', 'Memulai proses pesanan di processOrder().');

        $tipePengantaran = $this->request->getPost('tipe_pengantaran');

        $rules = [
            'nama_depan'          => 'required|min_length[3]|max_length[100]',
            'nama_belakang'       => 'permit_empty|max_length[100]',
            'nomor_pemesan'       => 'required|max_length[20]',
           // Di dalam method processOrder() di CheckoutController.php
            'tanggal_pengantaran' => 'required|valid_date[Y-m-d\TH:i]',
            'tipe_pengantaran'    => 'required|in_list[Delivery,Self-Pickup]',
            'metode_pembayaran'   => 'required|in_list[Direct Bank Transfer,QRIS]',
            'catatan_penerima'    => 'permit_empty|max_length[500]',
        ];

        // Aturan validasi kondisional berdasarkan tipe pengantaran
        if ($tipePengantaran === 'Delivery') {
            $rules['penerima_nomor_hp'] = 'required|max_length[20]';
            $rules['alamat_pengiriman_teks'] = 'required|max_length[500]';
            $rules['alamat_latitude'] = 'required|decimal';
            $rules['alamat_longitude'] = 'required|decimal';
        }

        if (!$this->validate($rules)) {
            log_message('error', 'Validasi form GAGAL: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        log_message('debug', 'Validasi dasar form BERHASIL.');

        $cartItems = $this->session->get('cart') ?? [];
        if (empty($cartItems)) {
            log_message('error', 'Keranjang KOSONG saat submit proses pesanan.');
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang belanja Anda kosong.');
        }
        log_message('debug', 'Keranjang memiliki ' . count($cartItems) . ' item.');

        $totalHargaProduk = 0;
        foreach ($cartItems as $item) {
            $totalHargaProduk += $item['price'] * $item['quantity'];
        }
        log_message('debug', 'Subtotal produk: ' . $totalHargaProduk);

        $biayaPengiriman = 0;
        $latitude = null;
        $longitude = null;

        if ($tipePengantaran === 'Delivery') {
            $shippingOption = $this->request->getPost('shipping_option');
            if ($shippingOption === 'free_shipping') {
                $biayaPengiriman = 0;
            } elseif ($shippingOption === 'flat_rate') {
                $biayaPengiriman = 15000;
            } elseif ($shippingOption === 'local_pickup') {
                 $biayaPengiriman = 0;
            }

            $latitude = $this->request->getPost('alamat_latitude');
            $longitude = $this->request->getPost('alamat_longitude');

            if (empty($latitude) || empty($longitude) || !is_numeric($latitude) || !is_numeric($longitude)) {
                 log_message('error', 'Koordinat kosong atau tidak valid untuk pengiriman Tipe "Delivery". Lat: ' . $latitude . ', Lng: ' . $longitude);
                 return redirect()->back()->withInput()->with('error', 'Koordinat lokasi pengiriman wajib diisi untuk pengantaran. Mohon tentukan di peta.');
            }
            log_message('debug', "Tipe pengantaran: Delivery. Biaya: {$biayaPengiriman}. Lat: {$latitude}, Lng: {$longitude}");

        } else if ($tipePengantaran === 'Self-Pickup') {
             $biayaPengiriman = 0;
             $latitude = null;
             $longitude = null;
             log_message('debug', 'Tipe pengantaran: Self-Pickup. Biaya: 0.');
        } else {
             log_message('error', 'Tipe pengantaran tidak dikenali: ' . $tipePengantaran);
             return redirect()->back()->withInput()->with('error', 'Tipe pengantaran tidak valid.');
        }

        $totalKeseluruhan = $totalHargaProduk + $biayaPengiriman;
        log_message('debug', 'Total keseluruhan pesanan (produk + pengiriman): ' . $totalKeseluruhan);

        $penerimaNamaLengkap = trim($this->request->getPost('nama_depan') . ' ' . $this->request->getPost('nama_belakang'));
        log_message('debug', 'Nama Penerima Lengkap: ' . $penerimaNamaLengkap);
        log_message('debug', 'Nomor HP Penerima: ' . $this->request->getPost('penerima_nomor_hp'));
        log_message('debug', 'Alamat Teks: ' . $this->request->getPost('alamat_pengiriman_teks'));
        log_message('debug', 'Nomor Pemesan: ' . $this->request->getPost('nomor_pemesan'));
        log_message('debug', 'Tanggal Pengantaran: ' . $this->request->getPost('tanggal_pengantaran'));
        log_message('debug', 'Metode Pembayaran: ' . $this->request->getPost('metode_pembayaran'));

        $metodePembayaran = $this->request->getPost('metode_pembayaran');
        // Status untuk QRIS dan Bank Transfer disamakan, karena keduanya butuh upload bukti
        $statusPesanan = 'Menunggu Bukti Transfer';

        $orderDataTemp = [
            'user_id'             => $this->session->get('user_id') ?? null,
            'tanggal_pesan'       => date('Y-m-d H:i:s'),
            'status_pesanan'      => $statusPesanan,
            'total_harga'         => $totalKeseluruhan,
            'metode_pembayaran'   => $metodePembayaran,
            'tanggal_pengantaran' => $this->request->getPost('tanggal_pengantaran'),
            'tipe_pengantaran'    => $tipePengantaran,
            'catatan_penerima'    => $this->request->getPost('catatan_penerima'),
            'penerima_nama'       => $penerimaNamaLengkap,
            'penerima_nomor_hp'   => $this->request->getPost('penerima_nomor_hp'),
            'alamat_pengiriman_teks' => $this->request->getPost('alamat_pengiriman_teks'),
            'alamat_latitude'     => $latitude,
            'alamat_longitude'    => $longitude,
            'bukti_bayar'         => null, // Tambahkan ini dengan nilai awal null
            'nomor_pemesan'       => $this->request->getPost('nomor_pemesan'),
        ];
        log_message('debug', 'Initial $orderDataTemp: ' . json_encode($orderDataTemp));

        try {
            $this->db->transBegin();

            $insertSuccess = $this->orderModel->insert($orderDataTemp, false);
            $orderId = $this->orderModel->getInsertID();

            if (!$insertSuccess || !$orderId) {
                $this->db->transRollback();
                $modelErrors = $this->orderModel->errors();
                $dbError = $this->db->error();
                $errorMsg = !empty($modelErrors) ? json_encode($modelErrors) : json_encode($dbError);
                log_message('error', 'GAGAL insert Order awal: ' . $errorMsg);
                throw new \Exception('Failed to insert initial order: ' . $errorMsg);
            }
            log_message('debug', 'Order awal berhasil diinsert dengan ID: ' . $orderId);

            foreach ($cartItems as $productCode => $item) {
                $orderItemData = [
                    'order_id'   => $orderId,
                    'product_id' => $item['id'],
                    'kuantitas'  => $item['quantity'],
                    'harga_satuan' => $item['price'],
                    'custom_details' => $item['options']['custom_details'] ?? null, // Save custom details here
                ];
                $insertOrderItemSuccess = $this->orderItemModel->insert($orderItemData);
                if (!$insertOrderItemSuccess) {
                    $this->db->transRollback();
                    $orderItemErrors = $this->orderItemModel->errors();
                    log_message('error', 'Gagal insert order item ' . $item['id'] . ': ' . json_encode($orderItemErrors));
                    throw new \Exception('Failed to insert order item for product ' . $item['id'] . ': ' . json_encode($orderItemErrors));
                }
            }
            log_message('debug', 'Semua order items berhasil diinsert.');

            $this->db->transCommit();
            $this->session->remove('cart');

            if ($metodePembayaran === 'QRIS') {
                log_message('debug', 'QRIS dipilih, redirect ke halaman pembayaran QRIS untuk order ID: ' . $orderId);
                return redirect()->to(base_url('checkout/qris/' . $orderId));
            } else { // Default to Bank Transfer
                log_message('debug', 'Bank Transfer dipilih, redirect ke halaman konfirmasi Bank untuk order ID: ' . $orderId);
                return redirect()->to(base_url('payment/bank-transfer/' . $orderId));
            }

        } catch (\Exception $e) {

            $this->db->transRollback();
            log_message('error', 'Transaksi database Rolled Back.');
            log_message('error', 'EXCEPTION TERDETEKSI saat memproses pesanan: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memproses pesanan Anda. Mohon coba lagi. Detail: ' . $e->getMessage());
        }
    }

     public function estimateShipping() {
        $response = service('response');
        $request = service('request');
 log_message('debug', 'AJAX estimateShipping dipanggil.');

        $toLat = (float)$request->getPost('to_lat');
        $toLon = (float)$request->getPost('to_lon');
        $cartItemsJson = $request->getPost('cart_items_json'); // String JSON dari cart

        if (empty($toLat) || empty($toLon) || empty($cartItemsJson)) {
            return $response->setJSON(['status' => 'error', 'message' => 'Data koordinat atau keranjang tidak lengkap.']);
        }

        $cartItems = json_decode($cartItemsJson, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return $response->setJSON(['status' => 'error', 'message' => 'Format data keranjang tidak valid.']);
        }

        $distanceKm = $this->calculateHaversineDistance(
            self::STORE_LATITUDE, self::STORE_LONGITUDE,
            $toLat, $toLon
        );

        $shippingCost = $this->getShippingCostByDistance($distanceKm, $cartItems);

        return $response->setJSON([
            'status' => 'success',
            'distance_km' => round($distanceKm, 2),
            'shipping_cost' => $shippingCost,
            'formatted_shipping_cost' => 'Rp' . number_format($shippingCost, 0, ',', '.')
        ]);
    }
   public function orderSuccess($orderId)
    {
        log_message('debug', 'Mengakses halaman Order Success untuk Order ID: ' . $orderId);
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            log_message('error', 'Order ID ' . $orderId . ' tidak ditemukan saat menampilkan halaman sukses.');
            return redirect()->to(base_url('dashboard'))->with('error', 'Nomor pesanan tidak valid.');
        }

        $data['order'] = $order; // Kirim seluruh objek order ke view
        $data['orderId'] = $orderId; // Tetap kirim orderId secara terpisah jika diperlukan

        return view('order_success', $data);
    }

    public function showQrisPage($orderId)
    {
        $order = $this->orderModel->find($orderId);

        if (!$order) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order['metode_pembayaran'] !== 'QRIS') {
            return redirect()->to('/')->with('error', 'Metode pembayaran tidak valid untuk halaman ini.');
        }

        $data = [
            'order' => $order,
            'total_amount' => $order['total_harga']
        ];

        return view('payment_qris', $data);
    }
}