<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Konfirmasi Transfer Bank - JS Florist</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <style>
        .bank-details-box {
            border: 1px solid #eee;
            padding: 20px;
            border-radius: 8px;
            background-color: #f9f9f9;
            margin-bottom: 30px;
        }
        .bank-details-box h4 {
            color: #d09c4c; /* Warna primary Anda */
            margin-bottom: 15px;
        }
        .bank-details-box p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container-fluid fixed-top">
        </div>

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Pembayaran Transfer Bank</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('checkout') ?>">Checkout</a></li>
            <li class="breadcrumb-item active text-white">Transfer Bank</li>
        </ol>
    </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="bg-light rounded p-5">
                    <h2 class="mb-4 text-center">Detail Pembayaran Pesanan #<?= esc($order['order_id']) ?></h2>
                    
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
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= esc(session()->getFlashdata('success')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <p class="lead text-center">Silakan lakukan transfer senilai <strong>Rp<?= number_format($order['total_harga'], 0, ',', '.') ?></strong> ke salah satu rekening berikut:</p>

                    <?php foreach ($bank_details as $bank): ?>
                        <div class="bank-details-box mb-4">
                            <h4><?= esc($bank['nama']) ?></h4>
                            <p>Nomor Rekening: <strong><?= esc($bank['nomor']) ?></strong></p>
                            <p>Atas Nama: <strong><?= esc($bank['atas_nama']) ?></strong></p>
                        </div>
                    <?php endforeach; ?>

                    <h3 class="mt-5 mb-3 text-center">Konfirmasi Pembayaran</h3>
                    <p class="text-center">Unggah bukti transfer Anda di sini agar pesanan dapat segera kami proses.</p>
                    
                    <form action="<?= base_url('payment/upload-proof') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="order_id" value="<?= esc($order['order_id']) ?>">
                        
                        <div class="mb-3">
                            <label for="bukti_transfer" class="form-label">Unggah Bukti Transfer (JPG, PNG, PDF - Max 2MB)<sup>*</sup></label>
                            <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept=".jpg,.jpeg,.png,.pdf" required>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-pill">Kirim Bukti Transfer</button>
                        </div>
                    </form>

                    <div class="text-center mt-5">
                        <a href="<?= base_url('track-order') ?>" class="btn btn-secondary px-4 py-2 rounded-pill">Lacak Pesanan</a>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-dark px-4 py-2 rounded-pill ms-2">Kembali ke Beranda</a>
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