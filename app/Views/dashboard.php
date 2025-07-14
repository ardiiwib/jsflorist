<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>JS Florist</title>
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
        <style>
            .service-item img {
    width: 100%; /* Pastikan gambar mengisi lebar kontainernya */
    height: 250px; /* Atur tinggi tetap yang Anda inginkan, misal 250px */
    object-fit: cover; /* Penting: Memastikan gambar mengisi area dan terpotong jika rasio aspeknya beda */
    object-position: center; /* Memposisikan bagian tengah gambar */
    /* Anda juga bisa menambahkan overflow: hidden; pada .service-item itu sendiri
       jika ada masalah clipping di browser lama */
}
       .fruite-item .fruite-img {
    width: 100%; /* Pastikan kontainer memiliki lebar penuh */
    height: 250px; /* Atur tinggi tetap yang Anda inginkan, misal 250px */
    overflow: hidden; /* Penting: menyembunyikan bagian gambar yang terpotong */
}

.fruite-item .fruite-img img {
    width: 100%;
    height: 100%; /* Membuat gambar mengisi tinggi kontainer */
    object-fit: cover; /* Penting: Memastikan gambar mengisi area dan terpotong jika rasio aspeknya beda */
    object-position: center; /* Memposisikan bagian tengah gambar */
}
/* public/assets/css/style.css */

.hero-header .carousel-item {
    height: 450px; /* Atur tinggi tetap untuk slide carousel */
    overflow: hidden;
}

.hero-header .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
/* public/assets/css/style.css */

.vesitable-item .vesitable-img {
    width: 100%;
    height: 200px; /* Atur tinggi tetap untuk gambar item carousel */
    overflow: hidden;
}

.vesitable-item .vesitable-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
          .fa-shopping-bag.fa-2x {
            color: #d09c4c!important; /* Contoh: Hijau - Ganti dengan warna yang Anda inginkan */
        }

        /* Mengubah warna latar belakang lingkaran notifikasi di keranjang (yang ada angka 3) */
        .position-absolute.bg-secondary {
            background-color: #ebd4b6 !important; /* Contoh: Ungu - Ganti dengan warna yang Anda inginkan */
        }

        /* Mengubah warna teks angka di dalam lingkaran notifikasi (angka 3) */
        .position-absolute.bg-secondary.text-dark {
            color: #ffffff !important; /* Contoh: Putih - Ganti dengan warna yang Anda inginkan */
        }

        /* Mengubah warna ikon user (profil) */
        .fas.fa-user.fa-2x {
            color:  color: #d09c4c  !important; /* Contoh: Hijau - Ganti dengan warna yang Anda inginkan */
        }

           /* Mengubah warna latar belakang tombol prev/next carousel */
        .carousel-control-prev,
        .carousel-control-next {
            background-color: #d09c4c !important; /* Warna kustom #d09c4c */
            width: 40px; /* Lebar tombol */
            height: 40px; /* Tinggi tombol */
            border-radius: 50%; /* Membuat tombol bulat */
            top: 50%; /* Posisikan di tengah vertikal */
            transform: translateY(-50%); /* Menyesuaikan posisi agar benar-benar di tengah */
        }

        /* Mengubah warna ikon panah (SVG) di dalam tombol prev/next carousel menjadi putih */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            /* Filter ini mengubah warna menjadi putih agar kontras dengan background #d09c4c */
            filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(288deg) brightness(102%) contrast(102%) !important;
            /* Atau gunakan background-image langsung dengan fill putih di SVG */
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e") !important;
        }

        /* Untuk ikon next (jika ingin spesifik, tapi umumnya sama dengan prev) */
        .carousel-control-next-icon {
            filter: invert(100%) sepia(100%) saturate(0%) hue-rotate(288deg) brightness(102%) contrast(102%) !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e") !important;
        }

        /* Mengubah warna ikon panah saat hover (opsional, menjadi hitam agar terlihat lebih baik) */
        .carousel-control-prev:hover .carousel-control-prev-icon,
        .carousel-control-next:hover .carousel-control-next-icon {
            filter: invert(0%) sepia(0%) saturate(0%) hue-rotate(0deg) brightness(0%) contrast(0%) !important; /* Contoh: Hitam saat hover */
        }
        .btn.btn-primary.border-2.border-secondary {
            background-color: #d09c4c !important; /* Contoh: Warna #d09c4c */
            border-color: #d09c4c !important; /* Border juga disamakan */
            color: #ffffff !important; /* Warna teks tombol (putih agar kontras) */
        }

        /* Mengubah warna saat tombol di-hover (opsional) */
        .btn.btn-primary.border-2.border-secondary:hover {
            background-color: #b0853e !important; /* Warna sedikit lebih gelap saat hover */
            border-color: #b0853e !important;
        }

         .featurs-item .featurs-icon.bg-secondary {
            background-color: #d09c4c !important; /* Contoh: Warna #d09c4c */
            /* Jika ada border juga, bisa ditambahkan: */
            border: 1px solid #d09c4c !important; /* Contoh: Border dengan warna yang sama */
        }

        /* Mengubah warna ikon di dalam lingkaran Featurs Section */
        /* Ikon-ikon ini sudah text-white, jadi kita ubah warna putihnya */
        .featurs-item .featurs-icon i.text-white {
            color: #ffffff !important; /* Contoh: Tetap putih agar kontras dengan #d09c4c */
            /* Atau jika Anda ingin warna lain: */
            /* color: #212529 !important; */ /* Contoh: Hitam */
        }
.featurs-item .featurs-icon::after {
    border-top-color: #b0853e !important; /* Warna oranye kecoklatan yang lebih gelap (contoh) */
    /* Ganti dengan warna yang Anda inginkan. Ini harus lebih gelap dari #d09c4c */
}
            </style>
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



        <!-- Modal Search Start -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content rounded-0">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body d-flex align-items-center">
                        <div class="input-group w-75 mx-auto d-flex">
                            <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                            <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Search End -->


        <!-- Hero Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">
               <h4 class="mb-3 text-secondary">Hadiah Sempurna untuk Setiap Momen</h4>
<h1 class="mb-5 display-3 text-primary">Bunga Segar untuk Buket, Ucapan & Acara Anda</h1>
                       
                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="<?= base_url('assets\img\hand_baket.jpg')?>" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Hand-Bouquet</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\balon_baket.jpeg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Ballon-Bouquet</a>
                                </div>
                                 <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\stending_baket.jpeg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Standing-Bouquet</a>
                                </div>
                                 <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\vas_bunga.jpg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Vase-Flowers</a>
                                </div>
                                 <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\flower_box.jpeg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">FLower-Box</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\bunga_mobil.jpeg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Bunga-Mobil</a>
                                </div>
                                 <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\bunga_salib.jpg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Bunga-Salib</a>
                                </div>
                                   <div class="carousel-item rounded">
                                    <img src="<?= base_url('assets\img\bunga_papan.jpg')?>" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">Bunga-Papan</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->


        <!-- Featurs Section Start -->
        <div class="container-fluid featurs py-5">
            <div class="container py-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-car-side fa-3x text-white"></i>
                            </div>
                           <div class="featurs-content text-center">
    <h5>Pengiriman Cepat</h5>
    <p class="mb-0">Bunga Tiba di Hari yang Sama</p>
</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fas fa-user-shield fa-3x text-white"></i>
                            </div>
                            <div class="featurs-content text-center">
    <h5>Pembayaran Aman</h5>
    <p class="mb-0">Transaksi Online Terlindungi


    </p>
</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                           <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
    <img src="<?= base_url('assets/img/bunga.svg') ?>" alt="Flower Icon" style="width: 48px; height: 48px; filter: invert(100%);">
    </div>
<div class="featurs-content text-center">
    <h5>Bunga Segar Terjamin</h5>
    <p class="mb-0">Garansi Kesegaran & Kualitas Terbaik</p>
</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="featurs-item text-center rounded bg-light p-4">
                            <div class="featurs-icon btn-square rounded-circle bg-secondary mb-5 mx-auto">
                                <i class="fa fa-phone-alt fa-3x text-white"></i>
                            </div>
                        <div class="featurs-content text-center">
    <h5>Layanan Konsultasi</h5>
    <p class="mb-0">Bantu Pilih Bunga Sempurna</p>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs Section End -->


       <!-- bagian melihat produk bouquet -->
        <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Semua Produk Bouquet Kami</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <?php $firstTab = true; // Flag untuk menandai tab pertama sebagai 'active' ?>
                            <?php foreach ($categories as $category): ?>
                                <li class="nav-item">
                                    <a class="d-flex m-2 py-2 bg-light rounded-pill <?= $firstTab ? 'active' : '' ?>"
                                       data-bs-toggle="pill" href="#tab-<?= esc($category['category_id']) ?>">
                                        <span class="text-dark" style="width: 130px;"><?= esc($category['nama_kategori']) ?></span>
                                    </a>
                                </li>
                                <?php $firstTab = false; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="tab-content">
                    <?php $firstTabContent = true; // Flag untuk menandai konten tab pertama sebagai 'active' ?>
                    <?php foreach ($categories as $category): ?>
                        <div id="tab-<?= esc($category['category_id']) ?>"
                             class="tab-pane fade show p-0 <?= $firstTabContent ? 'active' : '' ?>">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="row g-4">
                                        <?php
                                        // Periksa apakah ada produk untuk kategori ini
                                        if (isset($productsByCategory[$category['category_id']])):
                                            foreach ($productsByCategory[$category['category_id']] as $product):
                                        ?>
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>"
                                                                 class="img-fluid w-100 rounded-top" alt="<?= esc($product['nama_produk']) ?>">
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                                                            <?= esc($category['nama_kategori']) ?>
                                                        </div>
                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h4><?= esc($product['nama_produk']) ?></h4>
                                                            <p><?= esc($product['deskripsi_produk']) ?></p>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-0">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
                                                              <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_to_cart_btn" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            endforeach;
                                        else:
                                            ?>
                                            <div class="col-12">
                                                <p class="text-center mt-4">Belum ada produk di kategori ini.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $firstTabContent = false; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
         <!-- akhir bagian melihat produk bouquet -->


  
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-secondary rounded border border-secondary">
                                <img src="<?= base_url('assets\img\hand_baket.jpg')?>" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-primary text-center p-4 rounded">
                                        <h5 class="text-white">Hand Bouquet</h5>
                                        <h3 class="mb-0">20% OFF</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-dark rounded border border-dark">
                                <img src="<?= base_url('assets\img\bunga_segar.jpg')?>" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-light text-center p-4 rounded">
                                        <h5 class="text-primary">Bunga Segar</h5>
                                        <h3 class="mb-0">Free delivery</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <a href="#">
                            <div class="service-item bg-primary rounded border border-primary">
                                <img src="<?= base_url('assets\img\papan_bunga.jpg')?>" class="img-fluid rounded-top w-100" alt="">
                                <div class="px-4 rounded-bottom">
                                    <div class="service-content bg-secondary text-center p-4 rounded">
                                        <h5 class="text-white">Papan Bunga</h5>
                                        <h3 class="mb-0">Discount Rp50K</h3>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Featurs End -->


        <!-- Bagian Bunga Papan dan lain lain-->
        <div class="container-fluid vesitable py-5">
    <div class="container py-5">
        <h1 class="mb-0">Bunga Papan & Lain-lain</h1> <div class="owl-carousel vegetable-carousel justify-content-center">
            <?php if (!empty($nonBouquetProducts)): ?>
                <?php foreach ($nonBouquetProducts as $product): ?>
                    <div class="border border-primary rounded position-relative vesitable-item">
                        <div class="vesitable-img">
                            <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>"
                                 class="img-fluid w-100 rounded-top" alt="<?= esc($product['nama_produk']) ?>">
                        </div>
                        <?php
                            // Untuk menampilkan nama kategori di sini, Anda perlu
                            // mengambil nama kategorinya juga.
                            // Contoh sederhana: cari nama kategori berdasarkan ID dari $allExistingCategories
                            $productCategoryName = 'N/A';
                            foreach ($allExistingCategories as $cat) { // Anda perlu $allExistingCategories dari controller juga
                                if ($cat['category_id'] == $product['category_id']) {
                                    $productCategoryName = $cat['nama_kategori'];
                                    break;
                                }
                            }
                        ?>
                        <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;">
                            <?= esc($productCategoryName) ?>
                        </div>
                        <div class="p-4 rounded-bottom">
                            <h4><?= esc($product['nama_produk']) ?></h4>
                            <p><?= esc($product['deskripsi_produk']) ?></p>
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <p class="text-dark fs-5 fw-bold mb-0">Rp<?= number_format($product['harga'], 0, ',', '.') ?></p>
                                 <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_to_cart_btn" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                              
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center mt-4">
                    <p>Belum ada produk non-bouquet yang tersedia.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
        <!-- Akhir Bagian Bunga papan dan lain lain -->


        <!-- Artikel Carousel Start -->
         <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                    <h1 class="display-4">Tips & Cerita Florist</h1>
                    <p>Baca artikel terbaru kami untuk mendapatkan inspirasi, tips perawatan bunga, dan cerita menarik seputar dunia florist.</p>
                </div>
                <?php if (!empty($artikels)): ?>
                <div class="owl-carousel testimonial-carousel">
                    <?php foreach ($artikels as $artikel): ?>
                    <a href="<?= base_url('artikel/' . $artikel['id_artikel']) ?>" style="text-decoration: none; color: inherit;">
                        <div class="testimonial-item img-border-radius bg-light rounded p-4">
                            <div class="position-relative">
                                <img src="<?= base_url('assets/img/artikel/' . esc($artikel['gambar'])) ?>" class="img-fluid rounded w-100" alt="<?= esc($artikel['judul']) ?>" style="height: 200px; object-fit: cover;">
                                <div class="pt-4">
                                    <h4 class="mb-3"><?= esc($artikel['judul']) ?></h4>
                                    <p class="mb-0">
                                        <?php
                                        // Potong isi artikel menjadi 100 karakter
                                        $isi_singkat = substr(strip_tags($artikel['isi']), 0, 100);
                                        echo esc($isi_singkat) . (strlen(strip_tags($artikel['isi'])) > 100 ? '...' : '');
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                    <div class="col-12 text-center mt-4">
                        <p>Belum ada artikel yang tersedia.</p>
                    </div>
                <?php endif; ?>
                <div class="text-center mt-4">
                    <a href="<?= base_url('artikel') ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary">Lihat Selengkapnya <i class="fa fa-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
        <!-- Artikel Carousel End -->



        <!-- Bestsaler Product Start -->
      <div class="container-fluid py-5">
    <div class="container py-5">
        <div class="text-center mx-auto mb-5" style="max-width: 700px;">
            <h1 class="display-4">Buket Terlaris Kami</h1> <p>Pilihan buket paling populer dan favorit dari pelanggan kami.</p> </div>
        <div class="row g-4">
            <?php if (!empty($bestsellerBouquetProducts)): ?>
                <?php foreach ($bestsellerBouquetProducts as $product): ?>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>"
                                         class="img-fluid rounded-circle w-100" alt="<?= esc($product['nama_produk']) ?>">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5"><?= esc($product['nama_produk']) ?></a>
                                    <div class="d-flex my-3">
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star text-primary"></i>
                                        <i class="fas fa-star"></i> </div>
                                    <h4 class="mb-3">Rp<?= number_format($product['harga'], 0, ',', '.') ?></h4>
                                 <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary add_to_cart_btn" data-product-id="<?= htmlspecialchars($product['product_id']) ?>"><i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center mt-4">
                    <p>Belum ada produk terlaris dari kategori bouquet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
        <!-- Bestsaler Product End -->


        <!-- Fact Start -->
        <div class="container-fluid py-5">
            <div class="container">
                <div class="bg-light p-5 rounded">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>satisfied customers</h4>
                                <h1>1963</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>quality of service</h4>
                                <h1>99%</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>quality certificates</h4>
                                <h1>33</h1>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="counter bg-white rounded p-5">
                                <i class="fa fa-users text-secondary"></i>
                                <h4>Available Products</h4>
                                <h1>789</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fact Start -->


        <!-- Tastimonial Start -->
       <div class="container-fluid testimonial py-5">
    <div class="container py-5">
        <div class="testimonial-header text-center">
            <h4 class="text-primary">Review Pelanggan Kami</h4>
            <h1 class="display-5 mb-5 text-dark">Apa Kata Mereka!</h1>
        </div>
        <div class="elfsight-app-b5291630-3f1d-4b33-a927-00952a6f83fb" data-elfsight-app-lazy></div>
    </div>
</div>
<script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
        <!-- Tastimonial End -->


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
                        <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                        <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                        <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
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
    // Event listener untuk tombol "Add to Cart"
    $(document).on('click', '.add_to_cart_btn', function(e) {
        e.preventDefault(); // Mencegah link mengikuti href="#"

        var productId = $(this).data('product-id'); // Ini baris krusialnya
var quantity = 1;
        // --- DEBUGGING: TAMBAHKAN LOG INI ---
        console.log('DOM Element:', this); // Lihat elemen HTML yang diklik
        console.log('Value of data-product-id from element:', $(this).attr('data-product-id')); // Ambil atribut langsung
        console.log('Value of productId variable (from .data()):', productId);
        // --- AKHIR DEBUGGING LOG ---

        if (productId === undefined || productId === null || productId === '') {
            console.error('DEBUG: Product ID kosong atau tidak valid di JavaScript.');
            alert('Error Internal: ID produk tidak dapat diambil dari tombol. Mohon periksa konsol browser.');
            return; // Hentikan proses AJAX jika ID tidak valid di frontend
        }

        // ... sisa kode AJAX (sama seperti sebelumnya) ...
        $.ajax({
            url: '<?= base_url('cart/add') ?>',
            method: 'POST',
            data: { product_id: productId, quantity: quantity },
            dataType: 'json',
            success: function(response) {
                 alert(response.message); 
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error, xhr.responseText);
                alert('Terjadi kesalahan saat menambahkan produk ke keranjang.');
            }
        });
    });
    });
</script>
    </body>

</html>
