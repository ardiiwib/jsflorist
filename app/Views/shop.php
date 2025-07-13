<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Shop - JS Florist</title> <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&amp;family=Raleway:wght@600;800&amp;display=swap" rel="stylesheet"> 

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link href="<?= base_url('assets/lib/lightbox/css/lightbox.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet">


        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
        <style>
            /* Styles for the active pagination item */
/* Ensure the main pagination container uses flexbox and is centered */
.pagination {
    display: flex;
    flex-wrap: wrap; /* Allows items to wrap if screen size is small */
    justify-content: center; /* Centers the pagination block */
    padding-left: 0; /* Remove default padding from ul */
    list-style: none; /* Remove list bullets */
    border-radius: 0.25rem; /* Standard Bootstrap border-radius for the group */
}

/* Style for each individual pagination item (li) */
.pagination .page-item {
    margin: 0; /* Remove any external margins */
    /* If items are still sticking, try adding a very small right margin: */
    /* margin-right: 2px; */
}

/* Style for the actual link (a) inside each page item */
.pagination .page-item .page-link {
    position: relative; /* Needed for z-index on active */
    display: block; /* Ensure the link takes full space and allows padding */
    padding: 0.375rem 0.75rem; /* Standard Bootstrap padding for links */
    text-decoration: none; /* Remove underline */
    line-height: 1.5; /* Standard line height */
    color: #0d6efd; /* Bootstrap blue, adjust if needed for your theme */
    background-color: #fff; /* White background */
    border: 1px solid #dee2e6; /* Light gray border */
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

/* Specific styling for rounded corners on the first and last items if needed */
.pagination .page-item:first-child .page-link {
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}
.pagination .page-item:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
/* Ensure borders collapse neatly between items */
.pagination .page-item:not(:first-child) .page-link {
    margin-left: -1px;
}


/* Styles for the active page */
.pagination .page-item.active .page-link {
    z-index: 3;
    color: #fff; /* White text */
    background-color: #d09c4c; /* Your primary color */
    border-color: #d09c4c; /* Your primary color */
}

/* Styles for hover state on non-active pages */
.pagination .page-item:not(.active) .page-link:hover,
.pagination .page-item:not(.active) .page-link:focus {
    color: #0a58ca; /* Darker blue on hover */
    background-color: #e9ecef; /* Light gray background on hover */
    border-color: #dee2e6;
}

/* Ensure active page doesn't change style on hover/focus */
.pagination .page-item.active .page-link:hover,
.pagination .page-item.active .page-link:focus {
    color: #fff;
    background-color: #d09c4c;
    border-color: #d09c4c;
    cursor: default; /* Indicate it's not clickable */
}
            /* Tambahkan CSS kustom dari dashboard.php agar konsisten */
            .bg-primary { background-color: #d09c4c !important; }
            .text-primary { color: #d09c4c !important; }
            .border-primary { border-color: #d09c4c !important; }
            .bg-secondary { background-color: #ebd4b6 !important; }
            .text-secondary { color: #ebd4b6 !important; }
            .border-secondary { border-color: #ebd4b6 !important; }
            .fruite-img img {
                height: 300px; /* Tinggi gambar produk seragam */
                object-fit: cover;
            }
            .fruite-item {
                display: flex;
                flex-direction: column;
                height: 100%;
            }
            .fruite-item .p-4 {
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }
            .fruite-item h4 {
                flex-grow: 1; /* Agar judul produk bisa mengambil sisa ruang */
            }
        </style>
    </head>

    <body>

        <?= $this->include('templates/navbar') ?>

        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cari berdasarkan kata kunci</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="Kata kunci" aria-describedby="search-icon-1"> <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid page-header py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?= base_url('assets/img/page-header.webp') ?>) center center no-repeat; background-size: cover;">
            <h1 class="text-center text-white display-6">Shop</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item active text-white">Shop</li>
            </ol>
        </div>
        <div class="container-fluid fruite py-5">
            <div class="container py-5">
                <h1 class="mb-4">JS Florist Shop</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <form action="<?= base_url('shop') ?>" method="get" class="row g-4 align-items-center">
                                    <div class="col-xl-9">
                                        <div class="input-group w-100 mx-auto d-flex">
                                            <input type="search" name="keyword" class="form-control p-3" placeholder="Cari produk..." aria-describedby="search-icon-1" value="<?= esc($keyword ?? '') ?>">
                                            <button type="submit" id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="bg-light py-3 rounded d-flex justify-content-center">
                                            <a href="<?= base_url('shop') ?>" class="btn btn-danger">Reset Filter</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row g-4 mt-4">
                            <div class="col-lg-3">
                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <h4>Kategori</h4> <ul class="list-unstyled fruite-categorie">
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="<?= base_url('shop?keyword=' . urlencode($keyword ?? '')) ?>" class="<?= empty($selectedCategory) ? 'text-danger fw-bold' : '' ?>">
                                                            <i class="fas fa-stream me-2"></i>Semua Kategori
                                                        </a>
                                                    </div>
                                                </li>
                                                <?php if (!empty($categories)): ?>
                                                    <?php foreach ($categories as $category): ?>
                                                    <li>
                                                        <div class="d-flex justify-content-between fruite-name">
                                                            <a href="<?= base_url('shop?category=' . $category['category_id'] . '&amp;keyword=' . urlencode($keyword ?? '')) ?>" class="<?= ($selectedCategory == $category['category_id']) ? 'text-danger fw-bold' : '' ?>">
                                                                <i class="fas fa-fan me-2"></i><?= esc($category['nama_kategori']) ?>
                                                            </a>
                                                        </div>
                                                    </li>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="row g-4 justify-content-center">
                                    <?php if (!empty($products)): ?>
                                        <?php foreach ($products as $product): ?>
                                            <div class="col-md-6 col-lg-6 col-xl-4">
                                                <div class="rounded position-relative fruite-item h-100 d-flex flex-column">
                                                    <div class="fruite-img">
                                                        <a href="<?= site_url('shop/product/' . $product['product_id']) ?>"> <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'], 'attr')) ?>" class="img-fluid w-100 rounded-top" alt="<?= esc($product['nama_produk'], 'attr') ?>">
                                                        </a>
                                                    </div>

                                                    <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                        <?php 
                                                            $categoryName = 'N/A';
                                                            if (!empty($categories)) {
                                                                foreach($categories as $cat) {
                                                                    if ($cat['category_id'] == $product['category_id']) {
                                                                        $categoryName = $cat['nama_kategori'];
                                                                        break;
                                                                    }
                                                                }
                                                            }
                                                            echo esc(explode(' ', $categoryName)[0]);
                                                        ?>
                                                    </div>
                                                    <div class="p-4 border border-secondary border-top-0 rounded-bottom d-flex flex-column flex-grow-1">
                                                        <a href="<?= site_url('shop/product/' . $product['product_id']) ?>" class="text-dark"><h4 class="flex-grow-1"><?= esc($product['nama_produk']) ?></h4></a>
                                                        <p><?= esc(substr($product['deskripsi_produk'], 0, 70)) . (strlen($product['deskripsi_produk']) > 70 ? '...' : '') ?></p>

                                                        <div class="d-flex justify-content-between flex-lg-wrap mt-auto align-items-center">
                                                            <p class="text-dark fs-5 fw-bold mb-0">Rp <?= number_format($product['harga'], 0, ',', '.') ?></p>
                                                            <form action="<?= base_url('cart/add') ?>" method="post" class="add-to-cart-form">
                                                                <?= csrf_field() ?>
                                                                <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
                                                                <input type="hidden" name="product_name" value="<?= esc($product['nama_produk']) ?>">
                                                                <input type="hidden" name="product_price" value="<?= esc($product['harga']) ?>">
                                                                <input type="hidden" name="quantity" value="1">
                                                                <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="col-12">
                                            <div class="alert alert-warning text-center" role="alert">
                                                Produk tidak ditemukan.
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <div class="pagination d-flex justify-content-center mt-5">
                                            <?php if ($pager) : ?>
                                                <?= $pager->links('shop_group') ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container-fluid py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="<?= base_url('dashboard') ?>">
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
                           <a href="<?= base_url('about-us') ?>" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Tentang Kami</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Jam Operasional</h4>
                            <p>Setiap Hari: 08:00 - 22:00 WITA</p>
                            <p>Kecuali Kamis: 08:00 - 20:00 WITA</p>
                            <h4 class="text-light mb-3 mt-4">Peta Lokasi</h4>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.99340916056!2d114.80280877490076!3d-3.454210496582452!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2de682283839218d%3A0xc39f9920b7d34d28!2sJl.%20Dahlia%2C%20Komet%2C%20Kec.%20Banjarbaru%20Selatan%2C%20Kota%20Banjar%20Baru%2C%20Kalimantan%20Selatan!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Kontak</h4>
                            <p>Alamat: Jl. Dahlia No.23, Komet, Kec. Banjarbaru Selatan, Kota Banjar Baru, Kalimantan Selatan 70714</p>
                            <p>Email: support@jsflorist.com</p>
                            <p>Telepon/WhatsApp: +62 822 5493 8586</p>
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
                        <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>JS Florist</a>, All right reserved.</span>
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
    <script src="<?= base_url('assets/lib/easing/easing.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/waypoints/waypoints.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/lightbox/js/lightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/owlcarousel/owl.carousel.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <script>
        $(document).ready(function() {
            // Tangani submission form "Add to Cart" via AJAX
            $(document).on('submit', '.add-to-cart-form', function(e) {
                e.preventDefault(); // Mencegah form dikirim secara tradisional

                const form = $(this);
                const button = form.find('button[type="submit"]');
                const originalButtonText = button.html();

                button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Adding...');

                $.ajax({
                    url: form.attr('action'), // Ambil URL dari atribut action form
                    method: form.attr('method'), // Ambil method dari atribut method form
                    data: form.serialize(), // Serialisasi semua data form
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#alertModalTitle').text('Berhasil Ditambahkan!');
                            $('#alertModalBody').html('<p>' + response.message + '</p><p>Item berhasil ditambahkan ke keranjang Anda.</p>');
                            $('#alertModal').modal('show');
                            // Opsional: Update jumlah item di ikon keranjang di navbar
                            updateCartCount(response.cart_total_items);
                        } else {
                            $('#alertModalTitle').text('Gagal Menambahkan!');
                            $('#alertModalBody').html('<p>' + response.message + '</p><p>Silakan coba lagi.</p>');
                            $('#alertModal').modal('show');
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#alertModalTitle').text('Terjadi Kesalahan!');
                        $('#alertModalBody').html('<p>Maaf, terjadi kesalahan pada server.</p><p>Silakan coba beberapa saat lagi.</p><p>Error: ' + error + '</p>');
                        $('#alertModal').modal('show');
                        console.error("AJAX Error:", status, error, xhr.responseText);
                    },
                    complete: function() {
                        button.prop('disabled', false).html(originalButtonText);
                    }
                });
            });

            // Fungsi untuk mengupdate jumlah item di ikon keranjang navbar
            function updateCartCount(totalItems) {
                // Asumsi elemen span jumlah keranjang di navbar memiliki ID atau bisa ditarget
                // Contoh: <span class="position-absolute ... text-dark px-1" id="navbar-cart-count">3</span>
                // Jika tidak ada ID, Anda perlu menambahkan ID ke span tersebut atau menyesuaikan selektor
                $('.navbar .position-relative .rounded-circle').text(totalItems);
            }
        });
    </script>

    <div class="modal fade" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alertModalTitle">Pesan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="alertModalBody">
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    </body>

</html>
