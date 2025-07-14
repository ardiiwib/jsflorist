<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Detail Pesanan #<?= esc($order['order_id']) ?> - JS Florist</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
</head>
<body>
    <div class="container-fluid fixed-top">
        </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="bg-light rounded p-5">
                    <h2 class="mb-4 text-center">Detail Pesanan #<?= esc($order['order_id']) ?></h2>
                    
                    <div class="mb-4">
                        <p><strong>Status Pesanan:</strong> <span class="badge bg-primary fs-5"><?= esc($order['status_pesanan']) ?></span></p>
                        <p><strong>Tanggal Pesan:</strong> <?= esc(date('d F Y, H:i', strtotime($order['tanggal_pesan']))) ?> WITA</p>
                        <p><strong>Tanggal & Jam Pengantaran:</strong> <?= esc(date('d F Y, H:i', strtotime($order['tanggal_pengantaran']))) ?> WITA</p>
                        <p><strong>Tipe Pengantaran:</strong> <?= esc($order['tipe_pengantaran']) ?></p>
                        <p><strong>Nama Penerima:</strong> <?= esc($order['penerima_nama']) ?></p>
                        <?php if (!empty($order['penerima_nomor_hp'])): ?>
                            <p><strong>Nomor HP Penerima:</strong> <?= esc($order['penerima_nomor_hp']) ?></p>
                        <?php endif; ?>
                        <p><strong>Nomor HP Pemesan:</strong> <?= esc($order['nomor_pemesan']) ?></p>
                       <?php if ($order['tipe_pengantaran'] === 'Delivery'): ?>
                            <p><strong>Alamat Pengiriman:</strong> <?= esc($order['alamat_pengiriman_teks']) ?></p>
                        <?php endif; ?>
                        <p><strong>Total Harga:</strong> Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></p>
                        <p><strong>Metode Pembayaran:</strong> <?= esc($order['metode_pembayaran']) ?></p>
                        <?php if (!empty($order['bukti_bayar'])): // Tampilkan bukti bayar jika ada ?>
                            <p><strong>Bukti Pembayaran:</strong> <a href="<?= base_url(esc($order['bukti_bayar'])) ?>" target="_blank">Lihat Bukti</a></p>
                        <?php else: // Atau tampilkan tombol untuk upload bukti jika belum ?>
                             <?php if ($order['status_pesanan'] === 'Menunggu Bukti Transfer'): ?>
                                <p class="text-danger"><strong>Bukti Pembayaran Belum Diunggah.</strong></p>
                                <?php
                                    $uploadUrl = '';
                                    if ($order['metode_pembayaran'] === 'QRIS') {
                                        $uploadUrl = base_url('checkout/qris/' . esc($order['order_id']));
                                    } else { // Default to Bank Transfer
                                        $uploadUrl = base_url('payment/bank-transfer/' . esc($order['order_id']));
                                    }
                                ?>
                                <a href="<?= $uploadUrl ?>" class="btn btn-warning btn-sm">Unggah Bukti Sekarang</a>
                             <?php endif; ?>
                        <?php endif; ?>
                        <?php if (!empty($order['catatan_penerima'])): ?>
                            <p><strong>Catatan/Ucapan:</strong> <?= nl2br(esc($order['catatan_penerima'])) ?></p>
                        <?php endif; ?>
                    </div>

                    <h3 class="mb-3">Item Pesanan:</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Satuan</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $itemSubtotal = 0; ?>
                                <?php foreach ($orderItems as $item): ?>
                                    <?php $currentSubtotal = $item['harga_satuan'] * $item['kuantitas']; ?>
                                    <?php $itemSubtotal += $currentSubtotal; ?>
                                    <tr>
                                        <td>
                                            <?php if (!empty($item['gambar_url'])): ?>
                                                <img src="<?= base_url('assets/img/gambar/' . esc($item['gambar_url'])) ?>" alt="<?= esc($item['nama_produk']) ?>" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                                            <?php else: ?>
                                                <img src="<?= base_url('assets/img/default-product.jpg') ?>" alt="No Image" style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= esc($item['nama_produk']) ?>
                                            <?php if (!empty($item['custom_details'])): ?>
                                                <?php 
                                                    // Decode JSON string dari custom_details
                                                    $details = json_decode($item['custom_details'], true);
                                                ?>
                                                <div class="mt-2 text-muted small">
                                                    <?php if (isset($details['jenis_item']) && !empty($details['jenis_item'])): ?>
                                                        <div><strong>Jenis:</strong> <?= esc($details['jenis_item']) ?></div>
                                                    <?php endif; ?>
                                                    <?php if (isset($details['jumlah_item']) && !empty($details['jumlah_item'])): ?>
                                                        <div><strong>Jumlah:</strong> <?= esc($details['jumlah_item']) ?></div>
                                                    <?php endif; ?>
                                                    <?php if (isset($details['bunga']) && is_array($details['bunga']) && !empty($details['bunga'])): ?>
                                                        <div><strong>Bunga:</strong> <?= esc(implode(', ', $details['bunga'])) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($item['kuantitas']) ?></td>
                                        <td>Rp<?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                                        <td>Rp<?= number_format($currentSubtotal, 0, ',', '.') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end"><strong>Total Item Pesanan:</strong></td>
                                    <td><strong>Rp<?= number_format($itemSubtotal, 0, ',', '.') ?></strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="text-center mt-4">
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary px-4 py-2 rounded-pill">Kembali ke Beranda</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        </div>
    <div class="container-fluid copyright bg-dark py-4">
        </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>