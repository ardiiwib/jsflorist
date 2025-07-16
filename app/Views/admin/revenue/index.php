<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Laporan Pendapatan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Laporan Pendapatan</h1>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="<?= base_url('admin/revenue') ?>" method="get">
            <div class="row align-items-end">
                <div class="col-md-5"><label for="start_date" class="form-label">Tanggal Mulai</label><input type="date" class="form-control" id="start_date" name="start_date" value="<?= esc($start_date) ?>"></div>
                <div class="col-md-5"><label for="end_date" class="form-label">Tanggal Akhir</label><input type="date" class="form-control" id="end_date" name="end_date" value="<?= esc($end_date) ?>"></div>
                <div class="col-md-2"><button type="submit" class="btn btn-primary w-100">Filter</button></div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pendapatan (Bersih)</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp<?= number_format($total_revenue_bersih, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Pesanan Selesai</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($total_orders_selesai) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata Nilai Pesanan</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">Rp<?= number_format($average_order_value, 0, ',', '.') ?></div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-primary">Rincian Pendapatan Diterima (Status: Selesai)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th><th>Nama Pemesan</th><th>Tanggal</th><th>Total Harga</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($completed_orders)): ?>
                        <?php foreach ($completed_orders as $order): ?>
                            <tr>
                                <td><?= esc($order['order_id']) ?></td>
                                <td><?= esc($order['penerima_nama']) ?></td>
                                <td><?= esc(date('d M Y H:i', strtotime($order['tanggal_pesan']))) ?></td>
                                <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                                <td><a href="<?= base_url('admin/orders/detail/' . $order['order_id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">Tidak ada pesanan yang selesai pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h6 class="m-0 font-weight-bold text-danger">Rincian Pesanan Dikembalikan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID Pesanan</th><th>Nama Pemesan</th><th>Tanggal</th><th>Harga Awal</th><th>Pengurangan (50%)</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($returned_orders)): ?>
                        <?php foreach ($returned_orders as $order): ?>
                            <tr>
                                <td><?= esc($order['order_id']) ?></td>
                                <td><?= esc($order['penerima_nama']) ?></td>
                                <td><?= esc(date('d M Y H:i', strtotime($order['tanggal_pesan']))) ?></td>
                                <td>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></td>
                                <td class="text-danger">- Rp<?= number_format($order['total_harga'] * 0.5, 0, ',', '.') ?></td>
                                <td><a href="<?= base_url('admin/orders/detail/' . $order['order_id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Tidak ada pesanan yang dikembalikan pada periode ini.</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="4" class="text-end">Total Pengurangan dari Pengembalian:</th>
                        <th class="text-danger" colspan="2">- Rp<?= number_format($total_deduction, 0, ',', '.') ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>