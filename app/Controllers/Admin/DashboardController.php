<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\CustomRequestModel;
use App\Models\UserModel; // Asumsikan Anda punya model untuk user/pelanggan

class DashboardController extends BaseController
{
 public function dashboard()
{
    // Inisialisasi model
    $orderModel = new OrderModel();

    // 1. Ambil data untuk "Statistik Kunci" (KPIs)
    
    // [PERBAIKAN] Pendapatan hanya dihitung dari pesanan yang statusnya 'Selesai'
    $data['pendapatan_hari_ini'] = $orderModel->selectSum('total_harga')
                                             ->where('DATE(tanggal_pesan)', date('Y-m-d'))
                                             ->where('status_pesanan', 'Selesai') // <-- Diubah di sini
                                             ->get()->getRow()->total_harga ?? 0;

    $data['pesanan_baru_hari_ini'] = $orderModel->where('DATE(tanggal_pesan)', date('Y-m-d'))
                                               ->countAllResults();
    
    $data['total_pelanggan'] = $orderModel->select('nomor_pemesan')
                                         ->distinct()
                                         ->countAllResults();

    // 2. Ambil data untuk "Grafik Penjualan 7 Hari Terakhir"
    
    // [PERBAIKAN] Grafik juga hanya menampilkan pendapatan dari pesanan 'Selesai'
    $salesData = $orderModel->select("DATE(tanggal_pesan) as tanggal, SUM(total_harga) as total")
                            ->where('tanggal_pesan >=', date('Y-m-d', strtotime('-6 days')))
                            ->where('status_pesanan', 'Selesai') // <-- Diubah di sini
                            ->groupBy('DATE(tanggal_pesan)')
                            ->orderBy('tanggal', 'ASC')
                            ->get()->getResultArray();
    
    // Proses data agar siap digunakan oleh Chart.js (tidak ada perubahan di sini)
    $labels = [];
    $totals = [];
    for ($i = 6; $i >= 0; $i--) {
        $date = date('Y-m-d', strtotime("-$i days"));
        $labels[] = date('d M', strtotime($date));
        $totalForDate = 0;
        foreach ($salesData as $row) {
            if ($row['tanggal'] == $date) {
                $totalForDate = $row['total'];
                break;
            }
        }
        $totals[] = $totalForDate;
    }

    $data['chart_labels'] = json_encode($labels);
    $data['chart_totals'] = json_encode($totals);

    // 3. Ambil data untuk "5 Pesanan Terakhir" (tidak ada perubahan di sini)
    $data['pesanan_terakhir'] = $orderModel->orderBy('tanggal_pesan', 'DESC')
                                           ->limit(5)
                                           ->find();

    // Kirim semua data ke view
    return view('admin/dashboard', $data);
}
}
