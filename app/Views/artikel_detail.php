<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>JS Florist - <?= esc($artikel['judul']) ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?= base_url('assets/lib/lightbox/css/lightbox.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css')?>" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href= "<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>

    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div> -->
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?= $this->include('templates/navbar') ?>
    <!-- Navbar End -->

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Detail Artikel</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active text-white">Detail Artikel</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Artikel Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <h1 class="mb-4"><?= esc($artikel['judul']) ?></h1>
                        <p class="text-muted">Dipublikasikan pada: <?= date('d F Y', strtotime($artikel['tanggal_dibuat'])) ?></p>
                    </div>
                    <div class="mb-4">
                        <img src="<?= base_url('assets/img/artikel/' . esc($artikel['gambar'])) ?>" class="img-fluid rounded w-100" alt="<?= esc($artikel['judul']) ?>">
                    </div>
                    <div class="artikel-content">
                        <?= $artikel['isi'] // Tampilkan isi artikel lengkap ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Artikel Detail End -->

    <!-- Produk Terkait Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="fw-bold mb-4">Produk Terkait</h1>
            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php if (!empty($relatedProducts)): ?>
                    <?php foreach ($relatedProducts as $product): ?>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img" style="height: 250px; overflow: hidden;">
                                <a href="<?= site_url('shop/product/' . $product['product_id']) ?>">
                                    <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>" class="img-fluid w-100 rounded-top" alt="<?= esc($product['nama_produk']) ?>" style="height: 100%; object-fit: cover;">
                                </a>
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?= esc($product['nama_kategori']) ?></div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <h4><?= esc($product['nama_produk']) ?></h4>
                                <p><?= esc(substr($product['deskripsi_produk'], 0, 50)) . '...' ?></p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_to_cart_btn" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <p class="text-center">Tidak ada produk terkait untuk artikel ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Produk Terkait End -->


    <!-- Footer Start -->
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
    <!-- Footer End -->

    <!-- Copyright Start -->
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
    <!-- Copyright End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>   

    
<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/lib/easing/easing.min.js')?>"></script>
<script src="<?= base_url('assets/lib/waypoints/waypoints.min.js')?>"></script>
<script src="<?= base_url('assets/lib/lightbox/js/lightbox.min.js')?>"></script>
<script src="<?= base_url('assets/lib/owlcarousel/owl.carousel.min.js')?>"></script>
<!-- Template Javascript -->
<script src="<?= base_url('assets/js/main.js')?>"></script>
<script>
$(document).ready(function() {
    // Mengambil jumlah produk terkait dari variabel PHP
    var relatedProductCount = <?= count($relatedProducts) ?>;

    // Menargetkan carousel produk terkait di halaman ini
    var relatedProductsCarousel = $('.vegetable-carousel');

    // Hanya jalankan jika carousel dan produknya ada di halaman ini
    if (relatedProductsCarousel.length > 0 && relatedProductCount > 0) {
        
        // Asumsi carousel menampilkan hingga 4 item di layar besar.
        // Jika jumlah produk 4 atau kurang, kita nonaktifkan 'loop' agar tidak ada duplikasi.
        if (relatedProductCount <= 4) {
            // Hancurkan instance carousel yang ada (yang mungkin diinisialisasi oleh main.js)
            relatedProductsCarousel.trigger('destroy.owl.carousel');

            // Inisialisasi ulang carousel dengan `loop: false`
            relatedProductsCarousel.owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                center: false,
                dots: true,
                loop: false, // <-- Perubahan utamanya di sini
                margin: 25,
                nav : true,
                navText : [
                    '<i class="bi bi-arrow-left"></i>',
                    '<i class="bi bi-arrow-right"></i>'
                ],
                responsive: { 0: { items:1 }, 576: { items:1 }, 768: { items:2 }, 992: { items:3 }, 1200: { items:4 } }
            });
        }
        // Jika jumlah produk lebih dari 4, kita biarkan pengaturan default dari main.js (dengan loop: true) berjalan.
    }
});
</script>
</body>
</html>
