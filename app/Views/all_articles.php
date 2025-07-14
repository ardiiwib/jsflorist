// app/Views/all_articles.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Semua Artikel - JS Florist</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="<?= base_url('assets/lib/lightbox/css/lightbox.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css')?>" rel="stylesheet">

    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <link href= "<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
    <style>
        /* CSS kustom Anda (dari dashboard.php atau style.css) */
        .bg-primary { background-color: #d09c4c !important; }
        .text-primary { color: #d09c4c !important; }
        .border-primary { border-color: #d09c4c !important; }
        .bg-secondary { background-color: #ebd4b6 !important; }
        .text-secondary { color: #ebd4b6 !important; }
        .border-secondary { border-color: #ebd4b6 !important; }
        .artikel-item img {
            width: 100%;
            height: 200px; /* Tinggi gambar artikel seragam */
            object-fit: cover;
        }
        .artikel-item {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .artikel-item .p-4 {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .artikel-item h4 {
            flex-grow: 1; /* Agar judul artikel bisa mengambil sisa ruang */
        }
    </style>
</head>
<body>

    <?= $this->include('templates/navbar') ?>
    <div class="container-fluid page-header py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?= base_url('assets/img/page-header.webp') ?>) center center no-repeat; background-size: cover;">
        <h1 class="text-center text-white display-6">Semua Artikel</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active text-white">Artikel</li>
        </ol>
    </div>
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Daftar Semua Artikel</h1>
            <div class="row g-4 justify-content-center">
                <?php if (!empty($artikels)): ?>
                    <?php foreach ($artikels as $artikel): ?>
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="rounded position-relative artikel-item h-100 d-flex flex-column">
                                <div class="artikel-img">
                                    <a href="<?= site_url('artikel/' . $artikel['id_artikel']) ?>">
                                        <img src="<?= base_url('assets/img/artikel/' . esc($artikel['gambar'])) ?>"
                                             class="img-fluid w-100 rounded-top" alt="<?= esc($artikel['judul']) ?>">
                                    </a>
                                </div>
                                <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column flex-grow-1">
                                    <a href="<?= site_url('artikel/' . $artikel['id_artikel']) ?>" class="text-dark">
                                        <h4 class="flex-grow-1"><?= esc($artikel['judul']) ?></h4>
                                    </a>
                                    <p class="text-muted small mb-2">Dipublikasikan: <?= date('d M Y', strtotime($artikel['tanggal_dibuat'])) ?></p>
                                    <p><?= esc(substr(strip_tags($artikel['isi']), 0, 100)) . (strlen(strip_tags($artikel['isi'])) > 100 ? '...' : '') ?></p>
                                    <div class="d-flex justify-content-end mt-auto">
                                        <a href="<?= site_url('artikel/' . $artikel['id_artikel']) ?>" class="btn border border-primary rounded-pill px-3 text-primary">Baca Selengkapnya <i class="fa fa-arrow-right ms-2"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            Tidak ada artikel yang tersedia.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">JsFlorist</h1>
                            <p class="text-secondary mb-0">Produk dan Bunga Segar</p>
                        </a>
                    </div>

                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                       <h4 class="text-light mb-3">Mengapa Memilih JS Florist?</h4>
                       <p class="mb-4">Kami menghadirkan koleksi bunga segar pilihan, dirangkai sepenuh hati oleh florist ahli kami untuk setiap momen istimewa Anda. Kepuasan Anda adalah prioritas utama.</p>
                       <a href="/about-us" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Tentang Kami</a>
                    </div>
                </div>
              <div class="col-lg-4 col-md-6">
    <div class="footer-item">
        <h4 class="text-light mb-3">Jam Operasional</h4>
<p>Setiap Hari: 08:00 - 22:00 WITA</p>
<p>Kecuali Kamis: 08:00 - 20:00 WITA</p>
<h4 class="text-light mb-3 mt-4">Peta Lokasi</h4>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.6298570447516!2d114.83060487497242!3d-3.43988819653459!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de681005cf941bd%3A0x75ae39760ce6a15e!2sJS%20Florist%20Banjarbaru!5e0!3m2!1sid!2sid!4v1722798845838!5m2!1sid!2sid" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</div>

                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Kontak</h4>
                        <p>Jl. Dahlia No.23, Komet, Kec. Banjarbaru Selatan, Kota Banjar Baru, Kalimantan Selatan 70714</p>
                        <p>adminjs@jsflorist.com</p>
                        <p>Phone : 088888888</p>
                        <p>Pembayaran yang diterima</p>
                        <img src="<?= base_url('assets/img/payment.png')?>" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Your Site Name</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">HTML Codex</a> Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </div>
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/lib/easing/easing.min.js')?>"></script>
<script src="<?= base_url('assets/lib/waypoints/waypoints.min.js')?>"></script>
<script src="<?= base_url('assets/lib/lightbox/js/lightbox.min.js')?>"></script>
<script src="<?= base_url('assets/lib/owlcarousel/owl.carousel.min.js')?>"></script>
<script src="<?= base_url('assets/js/main.js')?>"></script>
</body>
</html>