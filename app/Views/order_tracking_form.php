<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Lacak Pesanan - JS Florist</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
</head>
<body>
    <div class="container-fluid fixed-top">
        </div>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="bg-light rounded p-5">
                    <h2 class="mb-4 text-center">Lacak Pesanan Anda</h2>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= esc(session()->getFlashdata('error')) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <form action="<?= base_url('track-order/track') ?>" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="orderId" class="form-label">Nomor Pesanan:</label>
                            <input type="text" class="form-control" id="orderId" name="order_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomorPemesan" class="form-label">Nomor HP Pemesan:</label>
                            <input type="text" class="form-control" id="nomorPemesan" name="nomor_pemesan" required>
                            <div class="form-text">Gunakan nomor HP pemesan yang Anda masukkan saat checkout.</div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">Lacak</button>
                        </div>
                    </form>
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