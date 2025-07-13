<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table        = 'orders';
    protected $primaryKey   = 'order_id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // PASTIKAN SEMUA KOLOM DARI TABEL 'orders' YANG ANDA KIRIM ADA DI SINI
    // DAN KOLOM 'NOT NULL' DARI DB TANPA DEFAULT VALUE JUGA ADA DI SINI
    protected $allowedFields = [
        'user_id',             // NULLABLE di DB
        'tanggal_pesan',       // TEXT di DB, akan diisi manual
        'status_pesanan',      // Ada default 'Pending', tapi kita juga kirim
        'total_harga',         // NOT NULL
        'metode_pembayaran',   // NOT NULL
        'tanggal_pengantaran', // NOT NULL
        'tipe_pengantaran',    // NOT NULL
        'catatan_penerima',    // NULLABLE
        'penerima_nama',       // NOT NULL
        'penerima_nomor_hp',   // NOT NULL
        'alamat_pengiriman_teks', // NULLABLE
        'alamat_latitude',     // NULLABLE
        'alamat_longitude',    // NULLABLE
        'bukti_bayar',
        'nomor_pemesan'
    ];

    // Kita tidak menggunakan useTimestamps di model ini
    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $dateFormat    = 'datetime';

    // Validasi model (ini akan berjalan jika kita panggil $model->validate($data))
    // Tapi kita melakukan validasi di controller, jadi ini kurang relevan saat ini
    protected $validationRules = []; // Kosongkan saja jika validasi di controller
    protected $validationMessages = [];
    protected $skipValidation = true; // Lewati validasi model agar tidak konflik dengan controller

    public function getOrderWithUser(int $orderId)
    {
        return $this->select('orders.*, users.nama_depan, users.nama_belakang, users.email')
                    ->join('users', 'users.user_id = orders.user_id')
                    ->where('orders.order_id', $orderId)
                    ->first();
    }
}