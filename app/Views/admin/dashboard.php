<?= $this->extend('admin/layout/main') ?>

<?= $this->section('title') ?>
Dashboard Admin
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Dashboard</h1>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pendapatan (Hari Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp<?= number_format($pendapatan_hari_ini, 0, ',', '.') ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pesanan Baru (Hari Ini)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($pesanan_baru_hari_ini) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pelanggan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($total_pelanggan) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan (7 Hari Terakhir)</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">5 Pesanan Terakhir</h6>
        </div>
        <div class="card-body p-2"> <div class="list-group list-group-flush">
                <?php if (!empty($pesanan_terakhir)): ?>
                    <?php foreach ($pesanan_terakhir as $order): ?>
                        <?php
                            // Kode dari Anda untuk menentukan warna dan ikon
                            $status = $order['status_pesanan'];
                            $icon   = 'bi-question-circle';
                            $color  = 'bg-dark';

                            switch ($status) {
                                case 'Menunggu Bukti Transfer':
                                    $color = 'bg-secondary'; $icon = 'bi-wallet2'; break;
                                case 'Diproses':
                                    $color = 'bg-warning'; $icon = 'bi-hourglass-split'; break;
                                case 'Dikirim':
                                    $color = 'bg-info'; $icon = 'bi-truck'; break;
                                case 'Selesai':
                                    $color = 'bg-success'; $icon = 'bi-check-circle-fill'; break;
                                case 'Dibatalkan':
                                    $color = 'bg-danger'; $icon = 'bi-x-circle-fill'; break;
                            }
                        ?>
                        <a href="<?= base_url('admin/orders/detail/' . $order['order_id']) ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Pesanan #<?= esc($order['order_id']) ?></h6>
                                <small><?= date('d M Y', strtotime($order['tanggal_pesan'])) ?></small>
                            </div>
                            <p class="mb-1"><?= esc($order['penerima_nama']) ?></p>
                            
                            <small>
                                <span class="badge <?= $color ?> text-white">
                                    <i class="bi <?= $icon ?> me-1"></i>
                                    <?= esc($status) ?>
                                </span>
                            </small>

                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center p-3">Tidak ada pesanan terbaru.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('myAreaChart').getContext('2d');
    var myAreaChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $chart_labels ?>,
            datasets: [{
                label: "Pendapatan",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?= $chart_totals ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        callback: function(value, index, values) {
                            return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>