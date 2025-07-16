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
    // Menampilkan daftar semua pesanan
public function dashboard()
{
    $orderModel = new OrderModel();
    $db = \Config\Database::connect();

    // --- PENDAPATAN HARI INI (LOGIKA DIPERBAIKI) ---
    // Logika ini juga kita perbaiki agar lebih akurat
    $pendapatanSelesaiHariIni = $orderModel->selectSum('total_harga')
                                          ->where('status_pesanan', 'Selesai')
                                          ->where('DATE(tanggal_diupdate)', date('Y-m-d')) // Berdasarkan tanggal status diubah jadi Selesai
                                          ->get()->getRow()->total_harga ?? 0;

    $potonganDikembalikanHariIni = ($orderModel->selectSum('total_harga')
                                              ->where('status_pesanan', 'Dikembalikan')
                                              ->where('DATE(tanggal_diupdate)', date('Y-m-d')) // Berdasarkan tanggal status diubah jadi Dikembalikan
                                              ->get()->getRow()->total_harga ?? 0) * 0.5;

    $data['pendapatan_bersih_hari_ini'] = $pendapatanSelesaiHariIni - $potonganDikembalikanHariIni;

    // --- STATISTIK LAIN (Tidak Berubah) ---
    $data['pesanan_baru_hari_ini'] = $orderModel->where('DATE(tanggal_pesan)', date('Y-m-d'))->countAllResults();
    $data['total_pelanggan'] = $orderModel->select('nomor_pemesan')->distinct()->countAllResults();

    // --- [PERBAIKAN FINAL] LOGIKA GRAFIK DENGAN DUA KONTEKS TANGGAL ---

    // 1. Ambil semua PENDAPATAN dari order 'Selesai' selama 7 hari terakhir, dikelompokkan per tanggal SELESAI.
    $completedBuilder = $db->table('orders');
    $completedBuilder->select("DATE(tanggal_diupdate) as tanggal, SUM(total_harga) as total");
    $completedBuilder->where('tanggal_diupdate >=', date('Y-m-d', strtotime('-6 days')));
    $completedBuilder->where('status_pesanan', 'Selesai');
    $completedBuilder->groupBy('DATE(tanggal_diupdate)');
    $completedSales = $completedBuilder->get()->getResultArray();
    
    // 2. Ambil semua POTONGAN (50%) dari order 'Dikembalikan' selama 7 hari terakhir, dikelompokkan per tanggal DIKEMBALIKAN.
    $returnedBuilder = $db->table('orders');
    $returnedBuilder->select("DATE(tanggal_diupdate) as tanggal, SUM(total_harga * 0.5) as total_potongan");
    $returnedBuilder->where('tanggal_diupdate >=', date('Y-m-d', strtotime('-6 days')));
    $returnedBuilder->where('status_pesanan', 'Dikembalikan');
    $returnedBuilder->groupBy('DATE(tanggal_diupdate)');
    $returnedSales = $returnedBuilder->get()->getResultArray();

    // 3. Petakan hasil query ke tanggal agar mudah diakses
    $revenueMap = [];
    foreach($completedSales as $sale) {
        $revenueMap[$sale['tanggal']] = (float) $sale['total'];
    }

    $deductionMap = [];
    foreach($returnedSales as $return) {
        $deductionMap[$return['tanggal']] = (float) $return['total_potongan'];
    }

    // 4. Gabungkan data di PHP untuk mendapatkan pendapatan bersih harian
    $labels = [];
    $totals = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('d M', strtotime($date));

        $dailyRevenue = $revenueMap[$date] ?? 0;
        $dailyDeduction = $deductionMap[$date] ?? 0;
        
        $netDailyRevenue = $dailyRevenue - $dailyDeduction;
        $totals[] = $netDailyRevenue;
    }
    
    $data['chart_labels'] = json_encode($labels);
    $data['chart_totals'] = json_encode($totals);

    // --- PESANAN TERAKHIR (Tidak Berubah) ---
    $data['pesanan_terakhir'] = $orderModel->orderBy('tanggal_pesan', 'DESC')->limit(5)->find();

    return view('admin/dashboard', $data);
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
  public function revenue()
{
    $orderModel = new OrderModel();

    $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
    $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

    // Hitung total dari pesanan 'Selesai'
    $totalPendapatanSelesai = $orderModel->selectSum('total_harga')
                                         ->where('status_pesanan', 'Selesai')
                                         ->where('tanggal_pesan >=', $startDate . ' 00:00:00')
                                         ->where('tanggal_pesan <=', $endDate . ' 23:59:59')
                                         ->get()->getRow()->total_harga ?? 0;

    // Hitung total dari pesanan 'Dikembalikan'
    $totalHargaDikembalikan = $orderModel->selectSum('total_harga')
                                          ->where('status_pesanan', 'Dikembalikan')
                                          ->where('tanggal_pesan >=', $startDate . ' 00:00:00')
                                          ->where('tanggal_pesan <=', $endDate . ' 23:59:59')
                                          ->get()->getRow()->total_harga ?? 0;

    // Hitung pendapatan bersih
    $data['total_revenue_bersih'] = $totalPendapatanSelesai + ($totalHargaDikembalikan * 0.5);
    
    // [BARU] Hitung total pengurangan untuk ditampilkan di view
    $data['total_deduction'] = $totalHargaDikembalikan * 0.5;

    // [BARU] Ambil daftar pesanan yang dikembalikan secara spesifik
    $data['returned_orders'] = $orderModel
        ->where('status_pesanan', 'Dikembalikan')
        ->where('tanggal_pesan >=', $startDate . ' 00:00:00')
        ->where('tanggal_pesan <=', $endDate . ' 23:59:59')
        ->orderBy('tanggal_pesan', 'DESC')
        ->findAll();

    // Ambil daftar pesanan yang selesai untuk tabel utama
    $data['completed_orders'] = $orderModel
        ->where('status_pesanan', 'Selesai')
        ->where('tanggal_pesan >=', $startDate . ' 00:00:00')
        ->where('tanggal_pesan <=', $endDate . ' 23:59:59')
        ->orderBy('tanggal_pesan', 'DESC')
        ->findAll();

    // Data lain untuk metrik dan filter
    $data['total_orders_selesai'] = count($data['completed_orders']);
    $data['average_order_value'] = ($data['total_orders_selesai'] > 0) ? $totalPendapatanSelesai / $data['total_orders_selesai'] : 0;
    $data['start_date'] = $startDate;
    $data['end_date'] = $endDate;

    return view('admin/revenue/index', $data);
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

   public function productAnalysis()
{
    $db = \Config\Database::connect();

    // --- Query untuk Produk Terlaris (Tidak Berubah) ---
    $builder = $db->table('order_items');
    $builder->select('order_items.product_id, products.nama_produk, products.gambar_url, SUM(order_items.kuantitas) as total_terjual, SUM(order_items.kuantitas * order_items.harga_satuan) as total_pendapatan');
    $builder->join('products', 'products.product_id = order_items.product_id'); // Sesuaikan dengan primary key Anda
    $builder->join('orders', 'orders.order_id = order_items.order_id');
    $builder->where('orders.status_pesanan', 'Selesai');
    $builder->groupBy('order_items.product_id, products.nama_produk, products.gambar_url');
    $builder->orderBy('total_terjual', 'DESC');
    $builder->limit(10); 

    $data['produk_terlaris'] = $builder->get()->getResultArray();

    // --- [FITUR BARU] Query untuk Analisis Kategori ---
    $categoryBuilder = $db->table('order_items');
    $categoryBuilder->select('categories.nama_kategori, COUNT(DISTINCT orders.order_id) as jumlah_transaksi, SUM(order_items.kuantitas * order_items.harga_satuan) as total_pendapatan_kategori');
    $categoryBuilder->join('products', 'products.product_id = order_items.product_id');
    $categoryBuilder->join('categories', 'categories.category_id = products.category_id');
    $categoryBuilder->join('orders', 'orders.order_id = order_items.order_id');
    $categoryBuilder->where('orders.status_pesanan', 'Selesai');
    $categoryBuilder->groupBy('categories.category_id, categories.nama_kategori');
    $categoryBuilder->orderBy('total_pendapatan_kategori', 'DESC');

    $data['analisis_kategori'] = $categoryBuilder->get()->getResultArray();

    return view('admin/products/analysis', $data);
}
    
}
