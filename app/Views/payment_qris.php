<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran QRIS - JS Florist</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .qris-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .qris-container h1 {
            color: #d09c4c;
            margin-bottom: 20px;
        }
        .qris-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?= $this->include('templates/navbar') ?>
    <div class="container">
        <div class="qris-container">
            <h1>Scan untuk Membayar</h1>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <p>Silakan pindai kode QR di bawah ini untuk menyelesaikan pembayaran Anda.</p>
            <img src="<?= base_url('assets/img/qris.png') ?>" alt="QRIS Payment Code">
            <h4 class="mt-4">ID Pesanan Anda: <strong class="text-primary"><?= esc($order['order_id']) ?></strong></h4>
            <p>Total Pembayaran: <strong>Rp<?= number_format($total_amount ?? 0, 0, ',', '.') ?></strong></p>
            <p>Setelah pembayaran berhasil, unggah bukti pembayaran Anda di bawah ini.</p>

            <form action="<?= base_url('payment/upload-proof') ?>" method="POST" enctype="multipart/form-data" class="mt-4">
                <?= csrf_field() ?>
                <input type="hidden" name="order_id" value="<?= esc($order['order_id']) ?>">
                <div class="mb-3 text-start">
                    <label for="bukti_transfer" class="form-label">Unggah Bukti Pembayaran (JPG, PNG, PDF - Max 2MB)<sup>*</sup></label>
                    <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Kirim Bukti Pembayaran</button>
            </form>

            <a href="<?= site_url('/track-order') ?>" class="btn btn-secondary mt-3">Lacak Pesanan Saya</a>
        </div>
    </div>
</body>
</html>
