<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Daftar Pesanan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Manajemen Pesanan</h1>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('success')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<!-- Tabel Pesanan Aktif -->
<h2 class="mt-5">Pesanan Aktif (Belum Selesai)</h2>
    <div class="table-responsive">
            <table class="table table-striped table-bordered">

        <thead class="bg-primary text-white">
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal Pesan</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($incomplete_orders)): ?>
                <?php foreach ($incomplete_orders as $order): ?>
                    <?php
                        $status = $order['status_pesanan'];
                        $icon = 'bi-question-circle';
                        $color = 'bg-dark';

                        switch ($status) {
                            case 'Menunggu Bukti Transfer':
                                $color = 'bg-secondary'; $icon = 'bi-wallet2'; break;
                            case 'Menunggu Verifikasi Admin':
                                $color = 'bg-warning'; $icon = 'bi-hourglass-split'; break;
                            case 'Diproses':
                                $color = 'bg-warning'; $icon = 'bi-hourglass-split'; break;
                            case 'Siap Dikirim/Diambil':
                                $color = 'bg-info'; $icon = 'bi-truck'; break;
                                 case 'Dalam Pengiriman':
                                $color = 'bg-info'; $icon = 'bi-truck'; break;
                            case 'Selesai':
                                $color = 'bg-success'; $icon = 'bi-check-circle'; break;
                            case 'Dibatalkan':
                                $color = 'bg-danger'; $icon = 'bi-x-circle'; break;
                            case 'Dikembalikan':
                                $color = 'bg-danger'; $icon = 'bi-x-circle'; break;
                        }
                    ?>
                    <tr>
                        <td><?= esc($order['order_id']) ?></td>
                        <td><?= esc(date('d M Y H:i', strtotime($order['tanggal_pesan']))) ?></td>
                        <td><?= esc($order['penerima_nama']) ?> (<?= esc($order['nomor_pemesan']) ?>)</td>
                        <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                        <td><?= esc($order['metode_pembayaran']) ?></td>
                        <td>
                            <span class="badge <?= $color ?> text-white badge-status">
                                <i class="bi <?= $icon ?>"></i> <?= esc($status) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/orders/detail/' . $order['order_id']) ?>" 
                               class="btn btn-sm btn-primary btn-icon" 
                               title="Lihat detail pesanan">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada pesanan aktif yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pager -->
<div class="d-flex justify-content-center">
    <?php if ($pager) :?>
        <?= $pager->links('incomplete', 'default_full') ?>
    <?php endif ?>
</div>

<!-- Tabel Pesanan Selesai Hari Ini -->
<h2 class="mt-5 pt-4 border-top">Pesanan Selesai Hari Ini</h2>
    <div class="table-responsive">
            <table class="table table-striped table-bordered">

        <thead class="bg-primary text-white">
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal Selesai</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($completed_today)): ?>
                <?php foreach ($completed_today as $order): ?>
                    <?php
                        $status = $order['status_pesanan'];
                        $icon = 'bi-question-circle';
                        $color = 'bg-dark';

                        switch ($status) {
                            case 'Belum Dibayar':
                                $color = 'bg-secondary'; $icon = 'bi-wallet2'; break;
                            case 'Diproses':
                                $color = 'bg-warning'; $icon = 'bi-hourglass-split'; break;
                            case 'Dikirim':
                                $color = 'bg-info'; $icon = 'bi-truck'; break;
                            case 'Selesai':
                                $color = 'bg-success'; $icon = 'bi-check-circle'; break;
                            case 'Dibatalkan':
                                $color = 'bg-danger'; $icon = 'bi-x-circle'; break;
                        }
                    ?>
                    <tr>
                        <td><?= esc($order['order_id']) ?></td>
                        <td><?= esc(date('d M Y H:i', strtotime($order['updated_at']))) ?></td>
                        <td><?= esc($order['penerima_nama']) ?> (<?= esc($order['nomor_pemesan']) ?>)</td>
                        <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                        <td><?= esc($order['metode_pembayaran']) ?></td>
                        <td>
                            <span class="badge <?= $color ?> text-white badge-status">
                                <i class="bi <?= $icon ?>"></i> <?= esc($status) ?>
                            </span>
                        </td>
                        <td>
                            <a href="<?= base_url('admin/orders/detail/' . $order['order_id']) ?>" 
                               class="btn btn-sm btn-secondary btn-icon" 
                               title="Lihat kembali pesanan">
                                <i class="bi bi-arrow-clockwise"></i> Lihat Kembali
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada pesanan yang diselesaikan hari ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>
