
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Checkout - JS Florist</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet"> 
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" /> <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link href="<?= base_url('assets/lib/lightbox/css/lightbox.min.css')?>" rel="stylesheet">
        <link href="<?= base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css')?>" rel="stylesheet">

        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

        <style>
             #map-container {
            height: 350px; /* Tinggi peta */
            width: 100%;
            border: 1px solid #ccc;
            margin-top: 15px;
            display: none; /* Awalnya sembunyikan */
        }
             /* Mengubah warna latar belakang primary */
            .bg-primary {
                background-color: #d09c4c !important;
            }
             .text-primary {
                color: #d09c4c !important;
            }
             .border-primary {
                border-color: #d09c4c !important;
            }
            .bg-secondary {
                background-color: #ebd4b6 !important;
            }
             .text-secondary {
                color: #ebd4b6 !important;
            }
             .border-secondary {
                border-color: #ebd4b6 !important;
            }
            .featurs-item .featurs-icon::after {
                border-top-color: #b0853e !important;
            }
            .table img {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 50%;
            }
            /* Styling untuk field yang disembunyikan/maps */
            /* #map-container dan #map-address-input sudah ada di atas */
            #alamat-latitude, #alamat-longitude { /* MENGUBAH ID INI */
                display: none; /* Sembunyikan field lat/long, diisi oleh JS/API */
            }
            .form-check-label sup {
                color: red;
            }
        </style>
    </head>

    <body>
  <?= $this->include('templates/navbar') ?>
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
        <div class="container-fluid page-header py-5">
            <h1 class="text-center text-white display-6">Checkout</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= base_url('cart') ?>">Keranjang</a></li>
                <li class="breadcrumb-item active text-white">Checkout</li>
            </ol>
        </div>
        <div class="container-fluid py-5">
            <div class="container py-5">
                <h1 class="mb-4">Detail Pengiriman & Pembayaran</h1> <?php if (session()->getFlashdata('errors')): ?>
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

                <form action="<?= base_url('checkout/process') ?>" method="POST">
                    <?= csrf_field() ?> <div class="row g-5">
                        <div class="col-md-12 col-lg-6 col-xl-7">
                            <p class="mb-2">Informasi Penerima Bunga:</p>
                            <div class="row">
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Nama Depan Penerima<sup>*</sup></label>
                                        <input type="text" class="form-control" name="nama_depan" value="<?= old('nama_depan', $loggedInUser['nama_depan'] ?? '') ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-6">
                                    <div class="form-item w-100">
                                        <label class="form-label my-3">Nama Belakang Penerima<sup>*</sup></label>
                                        <input type="text" class="form-control" name="nama_belakang" value="<?= old('nama_belakang', $loggedInUser['nama_belakang'] ?? '') ?>" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Container untuk Nomor HP Penerima, akan di show/hide -->
                            <div class="form-item" id="penerima-nomor-hp-container" style="display: none;">
                                <label class="form-label my-3">Nomor Telepon Penerima<sup>*</sup></label>
                                <input type="tel" class="form-control" id="penerima_nomor_hp_input" name="penerima_nomor_hp" value="<?= old('penerima_nomor_hp') ?>">
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Nomor Telepon Pemesan<sup>*</sup></label>
                                <input type="tel" class="form-control" name="nomor_pemesan" value="<?= old('nomor_pemesan', $loggedInUser['nomor_hp'] ?? '') ?>" required>
                            </div>
                            <div class="form-item">
                                <label class="form-label my-3">Alamat Lengkap Pengiriman<sup>*</sup></label>
                                <input type="text" class="form-control" name="alamat_pengiriman_teks" id="map-address-input" placeholder="Masukkan alamat pengiriman, lalu pilih lokasi di peta" value="<?= old('alamat_pengiriman_teks') ?>" required>
                                <input type="hidden" id="alamat-latitude" name="alamat_latitude" value="<?= old('alamat_latitude') ?>">
                                <input type="hidden" id="alamat-longitude" name="alamat_longitude" value="<?= old('alamat_longitude') ?>">
                                
                                <div id="map-container" style="height: 300px; width: 100%; border: 1px solid #ccc; margin-top: 15px;">
                                    </div>
                                <button type="button" id="get-current-location-btn" class="btn btn-sm btn-info mt-2" style="display: none;">Gunakan Lokasi Saat Ini</button> </div>
                            <div class="form-item">
                                <label class="form-label my-3">Email Anda (Opsional)</label>
                                <input type="email" class="form-control" name="email_anda" value="<?= old('email_anda', $loggedInUser['email'] ?? '') ?>">
                            </div>
                            
                            <div class="form-item">
                                <label class="form-label my-3">Tanggal & Jam Pengantaran/Pengambilan<sup>*</sup></label>
                                <small class="d-block text-muted mb-1">Waktu yang ditampilkan dan dipilih adalah Waktu Indonesia Tengah (WITA).</small>
                                <input type="datetime-local" class="form-control" id="datetime-picker-checkout" name="tanggal_pengantaran" value="<?= old('tanggal_pengantaran') ?>" required>
                            </div>

                            <hr class="my-5"> <div class="mb-4">
                                <label class="form-label mb-3">Pilih Tipe Pengantaran<sup>*</sup></label>
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0" id="deliveryOption" name="tipe_pengantaran" value="Delivery" <?= old('tipe_pengantaran') == 'Delivery' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="deliveryOption">Antar ke Alamat (Delivery)</label>
                                </div>
                                <div class="form-check text-start my-3">
                                    <input type="radio" class="form-check-input bg-primary border-0" id="pickupOption" name="tipe_pengantaran" value="Self-Pickup" <?= old('tipe_pengantaran') == 'Self-Pickup' ? 'checked' : '' ?> required>
                                    <label class="form-check-label" for="pickupOption">Ambil Sendiri (Self-Pickup)</label>
                                </div>
                            </div>
                            
                            <div class="form-item">
                                <label class="form-label my-3">Catatan Pesanan / Isi Kartu Ucapan (Opsional)</label>
                                <textarea name="catatan_penerima" class="form-control" spellcheck="false" cols="30" rows="5" placeholder="Tulis pesan untuk penerima atau catatan khusus lainnya."><?= old('catatan_penerima') ?></textarea>
                            </div>
                        </div>

                        <div class="col-md-12 col-lg-6 col-xl-5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Nama</th> <th scope="col">Harga</th>
                                            <th scope="col">Qty</th> <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $subtotalProduk = 0; ?>
                                        <?php if (!empty($cartItems)): ?>
                                            <?php foreach ($cartItems as $item): ?>
                                                <?php
                                                    $itemTotal = $item['price'] * $item['quantity'];
                                                    $subtotalProduk += $itemTotal;
                                                ?>
                                                <tr>
                                                    <th scope="row">
                                                        <div class="d-flex align-items-center mt-2">
                                                            <img src="<?= base_url('assets/img/gambar/' . esc($item['image'])) ?>" class="img-fluid rounded-circle" alt="<?= esc($item['name']) ?>">
                                                        </div>
                                                    </th>
                                                    <td class="py-5">
                                                        <?= esc($item['name']) ?>
                                                        <?php if (isset($item['options']['custom_details'])): ?>
                                                            <?php 
                                                                $details = json_decode($item['options']['custom_details'], true);
                                                            ?>
                                                            <div class="mt-2 text-muted small">
                                                                <?php if (!empty($details['jenis_item'])): ?>
                                                                    <div><strong>Jenis:</strong> <?= esc($details['jenis_item']) ?></div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($details['jumlah_item'])): ?>
                                                                    <div><strong>Jumlah:</strong> <?= esc($details['jumlah_item']) ?></div>
                                                                <?php endif; ?>
                                                                <?php if (!empty($details['bunga']) && is_array($details['bunga'])): ?>
                                                                    <div><strong>Bunga:</strong> <?= esc(implode(', ', $details['bunga'])) ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="py-5">Rp<?= number_format($item['price'], 0, ',', '.') ?></td>
                                                    <td class="py-5"><?= esc($item['quantity']) ?></td>
                                                    <td class="py-5">Rp<?= number_format($itemTotal, 0, ',', '.') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="5" class="text-center">Keranjang kosong.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-5">
                                <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Kode Kupon">
                                <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Terapkan Kupon</button>
                            </div>
                            
                            <div class="row g-4 justify-content-end">
                                <div class="col-sm-8 col-md-7 col-lg-6 col-xl-12"> <div class="bg-light rounded">
                                        <div class="p-4">
                                            <h1 class="display-6 mb-4">Total <span class="fw-normal">Pesanan</span></h1>
                                            <div class="d-flex justify-content-between mb-4">
                                                <h5 class="mb-0 me-4">Subtotal Produk:</h5>
                                                <p class="mb-0" id="subtotal_produk">Rp<?= number_format($subtotalProduk, 0, ',', '.') ?></p>
                                            </div>
                                            <div class="d-flex justify-content-between">
    <h5 class="mb-0 me-4">Pengiriman:</h5>
    <div class="">
        <p class="mb-0" id="shipping_cost_display">Rp0</p>
    </div>
</div>
<div class="d-flex justify-content-between mb-2">
    <h5 class="mb-0 me-4">Pilihan Metode:</h5>
</div>
<div class="d-flex flex-column mb-3" id="shipping_options_group">
    <div class="form-check text-start">
        <input type="radio" class="form-check-input bg-primary border-0 shipping-option" id="freeShipping" name="shipping_option" value="free_shipping" checked>
        <label class="form-check-label" for="freeShipping">Gratis Pengiriman</label>
    </div>
    <div class="form-check text-start">
        <input type="radio" class="form-check-input bg-primary border-0 shipping-option" id="flatRate" name="shipping_option" value="flat_rate">
        <label class="form-check-label" for="flatRate">Biaya Flat: Rp15.000</label>
    </div>
    <div class="form-check text-start">
        <input type="radio" class="form-check-input bg-primary border-0 shipping-option" id="localPickup" name="shipping_option" value="local_pickup">
        <label class="form-check-label" for="localPickup">Ambil Sendiri: Rp0</label>
    </div>
</div>
<p class="mb-0 text-end" id="shipping_note">Pilih opsi pengiriman.</p>
                                        </div>
                                        <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                            <h5 class="mb-0 ps-4 me-4">TOTAL KESELURUHAN</h5>
                                            <p class="mb-0 pe-4" id="total_keseluruhan">Rp<?= number_format($subtotalProduk, 0, ',', '.') ?></p>
                                        </div>
                                        
                                       <h5 class="mb-3 ps-4 me-4">Metode Pembayaran</h5>
                                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                            <div class="col-12">
                                                <div class="form-check text-start my-3">
                                                    <input type="radio" class="form-check-input bg-primary border-0 payment-method" id="bankTransfer" name="metode_pembayaran" value="Direct Bank Transfer" checked required>
                                                    <label class="form-check-label" for="bankTransfer">Transfer Bank Langsung</label>
                                                </div>
                                                <p class="text-start text-dark">Lakukan pembayaran langsung ke rekening bank kami. Harap gunakan ID Pesanan Anda sebagai referensi pembayaran. Pesanan Anda tidak akan diproses sampai dana telah masuk dan bukti transfer diverifikasi.</p>
                                            </div>
                                        </div>
                                        <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                                            <div class="col-12">
                                                <div class="form-check text-start my-3">
                                                    <input type="radio" class="form-check-input bg-primary border-0 payment-method" id="qrisPayment" name="metode_pembayaran" value="QRIS" required>
                                                    <label class="form-check-label" for="qrisPayment">QRIS</label>
                                                </div>
                                                <p class="text-start text-dark">Bayar dengan memindai kode QR. Kode akan ditampilkan setelah Anda membuat pesanan.</p>
                                            </div>
                                        </div>

                                        <div class="row g-4 text-center align-items-center justify-content-center pt-4">
                                            <button type="submit" class="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary">Buat Pesanan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
    <script src="<?= base_url('assets/lib/easing/easing.min.js')?>"></script>
    <script src="<?= base_url('assets/lib/waypoints/waypoints.min.js')?>"></script>
    <script src="<?= base_url('assets/lib/lightbox/js/lightbox.min.js')?>"></script>
    <script src="<?= base_url('assets/lib/owlcarousel/owl.carousel.min.js')?>"></script>

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script src="<?= base_url('assets/js/main.js')?>"></script>

    
    
    <script>
        // Variabel global untuk peta
        let map;
        let marker;
        let geocoderControl; // Untuk pencarian alamat

        // Variabel elemen yang perlu diakses secara global atau diinisialisasi ulang
        // di dalam ready() tapi dideklarasikan di luar
        let subtotalProdukElement;
        let totalKeseluruhanElement;
        let shippingNoteElement;
        let shippingCostDisplayElement;
        let subtotalProduk;
        let cartItemsData; // Untuk menyimpan data keranjang dari PHP

        // Fungsi pembantu untuk mengupdate koordinat dan memicu fetchShippingCost
        function updateCoordinatesAndFetch(lat, lng) {
            $('#alamat-latitude').val(lat);
            $('#alamat-longitude').val(lng);
            console.log('Koordinat diupdate secara terprogram:', lat, lng);
            fetchShippingCost(); // Panggil fetchShippingCost setelah koordinat diupdate
        }

        // Fungsi initMap akan dipanggil saat tipe pengantaran "Delivery" dipilih
        function initMap() {
    console.log('initMap dipanggil.');
    const mapContainer = document.getElementById("map-container");

    // Hapus peta yang sudah ada jika dipanggil lagi
    if (map && map.remove) {
        map.off();
        map.remove();
        console.log('Peta yang sudah ada dihapus.');
    }

    // Koordinat default toko (Palangkaraya, Kalimantan Tengah, Indonesia)
    // Ini akan digunakan sebagai fallback jika geolocation gagal atau tidak diizinkan.
    const defaultLocation = { lat: -3.4398799, lng: 114.8332947 };

    // Inisialisasi peta dengan lokasi default terlebih dahulu
    // Ini penting agar peta langsung terlihat meskipun geolocation butuh waktu atau gagal
    map = L.map(mapContainer).setView(defaultLocation, 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    marker = L.marker(defaultLocation, { draggable: true }).addTo(map);

    // --- LOGIC BARU: Coba dapatkan lokasi pengguna saat ini ---
    if (navigator.geolocation) {
        console.log('Mencoba mendapatkan lokasi saat ini sebagai lokasi default...');
        navigator.geolocation.getCurrentPosition(function(position) {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            const latLng = L.latLng(pos.lat, pos.lng);

            // Perbarui tampilan peta dan marker ke lokasi pengguna
            map.setView(latLng, 15);
            marker.setLatLng(latLng);
            updateCoordinatesAndFetch(pos.lat, pos.lng); // Update input field dan panggil fetch
            reverseGeocode(pos.lat, pos.lng); // Dapatkan alamat dari koordinat
            console.log('Peta disetel ke lokasi saat ini:', pos.lat, pos.lng);
        }, function(error) {
            console.warn('Gagal mendapatkan lokasi saat ini. Menggunakan lokasi default. Error:', error.message);
            // Jika gagal, peta akan tetap di defaultLocation yang sudah diatur
            alert('Gagal mendapatkan lokasi Anda. Pastikan layanan lokasi diaktifkan dan berikan izin. Menggunakan lokasi default toko. Error: ' + error.message);
            // Tetapkan nilai dari defaultLocation
            updateCoordinatesAndFetch(defaultLocation.lat, defaultLocation.lng);
            reverseGeocode(defaultLocation.lat, defaultLocation.lng);
        });
    } else {
        console.warn('Browser tidak mendukung Geolocation. Menggunakan lokasi default.');
        alert('Browser Anda tidak mendukung Geolocation. Menggunakan lokasi default toko.');
        // Tetapkan nilai dari defaultLocation
        updateCoordinatesAndFetch(defaultLocation.lat, defaultLocation.lng);
        reverseGeocode(defaultLocation.lat, defaultLocation.lng);
    }
    // --- AKHIR LOGIC BARU ---

    // Setel nilai latitude dan longitude awal jika sudah ada dari old()
    // Penting: Logic ini harus dijalankan setelah upaya Geolocation,
    // agar nilai 'old()' dapat menimpa lokasi Geolocation jika ada.
    if ($('#alamat-latitude').val() && $('#alamat-longitude').val()) {
        const initialLat = parseFloat($('#alamat-latitude').val());
        const initialLng = parseFloat($('#alamat-longitude').val());
        if (!isNaN(initialLat) && !isNaN(initialLng)) {
            const initialPos = L.latLng(initialLat, initialLng);
            marker.setLatLng(initialPos);
            map.setView(initialPos, 15);
            updateCoordinatesAndFetch(initialLat, initialLng); // Pastikan ini juga mengupdate dan memanggil fetch
            reverseGeocode(initialLat, initialLng); // Pastikan juga reverse geocoding dilakukan
            console.log('Peta disetel ke koordinat awal dari old():', initialLat, initialLng);
        }
    }


    // Event listener: Saat marker diseret, update hidden input fields
    marker.off('dragend').on('dragend', function(e) {
        const coords = e.target.getLatLng();
        updateCoordinatesAndFetch(coords.lat, coords.lng);
        reverseGeocode(coords.lat, coords.lng);
        console.log('Marker diseret ke:', coords.lat, coords.lng);
    });

    // Event listener: Saat peta diklik, pindahkan marker dan update hidden input fields
    map.off('click').on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateCoordinatesAndFetch(e.latlng.lat, e.latlng.lng);
        reverseGeocode(e.latlng.lat, e.latlng.lng);
        console.log('Peta diklik di:', e.latlng.lat, e.latlng.lng);
    });

    // Inisialisasi geocoder control untuk pencarian alamat
    if (geocoderControl && map.hasLayer(geocoderControl)) {
        map.removeControl(geocoderControl);
    }
    geocoderControl = L.Control.geocoder({
        defaultMarkGeocode: false,
        collapsed: false,
        placeholder: 'Cari alamat...',
        geocoder: L.Control.Geocoder.nominatim()
    }).on('markgeocode', function(e) {
        const bbox = e.geocode.bbox;
        const center = e.geocode.center;
        const name = e.geocode.name;

        map.fitBounds(bbox);
        marker.setLatLng(center);

        $('#map-address-input').val(name);
        updateCoordinatesAndFetch(center.lat, center.lng);
        console.log('Alamat dicari:', name, center.lat, center.lng);
    }).addTo(map);

    // Fungsi untuk mendapatkan lokasi pengguna saat ini (Geolocation) - ini adalah fungsi yang sama
    // Tetapi sekarang dipanggil sebagai default di awal fungsi initMap()
    // Tombol ini tetap ada untuk pengguna yang ingin mendapatkan lokasi mereka lagi secara manual.
    const getCurrentLocationBtn = document.getElementById('get-current-location-btn');
    if (getCurrentLocationBtn) { // Pastikan tombol ada sebelum melampirkan event listener
        $(getCurrentLocationBtn).off('click').on('click', function() {
            if (navigator.geolocation) {
                console.log('Mencoba mendapatkan lokasi saat ini dari tombol...');
                navigator.geolocation.getCurrentPosition(function(position) {
                    const pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    const latLng = L.latLng(pos.lat, pos.lng);
                    map.setView(latLng, 15);
                    marker.setLatLng(latLng);
                    updateCoordinatesAndFetch(pos.lat, pos.lng);
                    reverseGeocode(pos.lat, pos.lng);
                    console.log('Lokasi saat ini ditemukan (dari tombol):', pos.lat, pos.lng);
                }, function(error) {
                    console.error('Gagal mendapatkan lokasi Anda (dari tombol):', error.message);
                    alert('Gagal mendapatkan lokasi Anda. Pastikan layanan lokasi diaktifkan dan berikan izin. Error: ' + error.message);
                });
            } else {
                alert('Browser Anda tidak mendukung Geolocation.');
                console.warn('Browser tidak mendukung Geolocation.');
            }
        });
    }

    // Memastikan peta di-resize jika kontainer awalnya display:none
    map.invalidateSize();
    console.log('Peta Leaflet diinisialisasi dan di-resize.');
}

        // Fungsi reverse geocoding untuk mendapatkan alamat dari koordinat
        function reverseGeocode(lat, lng) {
            console.log('Mencoba reverse geocoding untuk Lat:', lat, 'Lng:', lng);
            $.get(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`, function(data) {
                if (data && data.display_name) {
                    $('#map-address-input').val(data.display_name);
                    console.log('Reverse geocoding berhasil:', data.display_name);
                } else {
                    $('#map-address-input').val('Alamat tidak ditemukan.');
                    console.warn('Reverse geocoding: Alamat tidak ditemukan.');
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                $('#map-address-input').val('Gagal mendapatkan alamat.');
                console.error('Reverse geocoding gagal:', textStatus, errorThrown, jqXHR.responseText);
            });
        }

        // Fungsi untuk mengirim permintaan AJAX ke backend untuk estimasi ongkir
        function fetchShippingCost() {
            const tipePengantaran = $('input[name="tipe_pengantaran"]:checked').val();
            const toLat = $('#alamat-latitude').val();
            const toLon = $('#alamat-longitude').val();

            console.log('fetchShippingCost dipanggil. Tipe Pengantaran:', tipePengantaran, 'Lat:', toLat, 'Lon:', toLon);

            // Hanya lakukan fetch jika Delivery dipilih dan koordinat ada
            if (tipePengantaran === 'Delivery' && toLat && toLon && toLat !== "" && toLon !== "") {
                shippingNoteElement.text('Menghitung biaya pengiriman...');
                shippingCostDisplayElement.text('...');
                
                // Pastikan cartItemsData ada dan tidak kosong
                if (typeof cartItemsData === 'undefined' || cartItemsData === null || Object.keys(cartItemsData).length === 0) {
                    console.warn('cartItemsData kosong di frontend. Tidak dapat menghitung ongkir.');
                    shippingNoteElement.text('Keranjang kosong, ongkir Rp0.');
                    shippingCostDisplayElement.text('Rp0');
                    calculateTotal(0);
                    return;
                }

                $.ajax({
                    url: '<?= base_url('checkout/estimateShipping') ?>',
                    method: 'POST',
                    data: {
                        to_lat: toLat,
                        to_lon: toLon,
                        cart_items_json: JSON.stringify(cartItemsData),
                        // CSRF token untuk CodeIgniter 4
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('AJAX estimateShipping Success Response:', response);
                        if (response.status === 'success') {
                            let calculatedCost = response.shipping_cost; // Biaya murni dari backend
                            
                            // Hapus LOGIKA OVERRIDE INI, karena biaya murni dari backend
                            // if (selectedShippingOption === 'free_shipping') { calculatedCost = 0; }
                            // else if (selectedShippingOption === 'flat_rate' && tipePengantaran === 'Delivery') { calculatedCost = 15000; }
                            // else if (selectedShippingOption === 'local_pickup' && tipePengantaran === 'Delivery') { calculatedCost = 15000; }
                            
                            let noteText = `Jarak: ${response.distance_km} km.`;
                            if (calculatedCost === 0 && response.distance_km > 0) {
                                 noteText += " (Gratis Ongkir)";
                            } else if (response.distance_km === 0) {
                                 noteText = "Jarak: 0 km. (Ambil sendiri di toko)";
                            }
                            
                            shippingNoteElement.text(noteText);
                            shippingCostDisplayElement.text(`Rp${calculatedCost.toLocaleString('id-ID')}`);
                            calculateTotal(calculatedCost); // Panggil fungsi total dengan biaya dari backend
                        } else {
                            shippingNoteElement.text('Gagal menghitung biaya pengiriman: ' + response.message);
                            shippingCostDisplayElement.text('Rp0');
                            calculateTotal(0);
                            console.error('Error estimasi ongkir:', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        shippingNoteElement.text('Gagal menghitung biaya pengiriman.');
                        shippingCostDisplayElement.text('Rp0');
                        calculateTotal(0);
                        console.error("AJAX Error estimateShipping:", status, error, xhr.responseText);
                    }
                });
            } else {
                // Jika bukan Delivery, atau koordinat belum ada (saat Self-Pickup atau awal)
                let finalShippingCost = 0;
                if (tipePengantaran === 'Self-Pickup') {
                    finalShippingCost = 0;
                    shippingNoteElement.text('Ambil sendiri di toko.');
                } else if (tipePengantaran === 'Delivery') {
                    finalShippingCost = 0;
                    shippingNoteElement.text('Pilih lokasi di peta untuk menghitung ongkir.');
                } else { // Jika belum ada tipe pengantaran yang dipilih
                    finalShippingCost = 0;
                    shippingNoteElement.text('Pilih tipe pengantaran untuk melihat biaya.');
                }
                shippingCostDisplayElement.text(`Rp${finalShippingCost.toLocaleString('id-ID')}`);
                calculateTotal(finalShippingCost);
            }
        }

        // Fungsi untuk menghitung total keseluruhan (subtotal + biaya pengiriman)
        function calculateTotal(currentShippingCost = 0) {
            const totalKeseluruhan = subtotalProduk + currentShippingCost;
            totalKeseluruhanElement.text('Rp' + totalKeseluruhan.toLocaleString('id-ID'));
            console.log('Final Total (Subtotal + Shipping):', totalKeseluruhan);
        }


        $(document).ready(function () {
            console.log('Document ready. Memulai inisialisasi form checkout.');

            // Inisialisasi variabel elemen saat DOM siap
            subtotalProdukElement = $('#subtotal_produk');
            totalKeseluruhanElement = $('#total_keseluruhan');
            shippingNoteElement = $('#shipping_note');
            shippingCostDisplayElement = $('#shipping_cost_display');
            
            // Inisialisasi subtotalProduk (nilai awal dari PHP)
            subtotalProduk = parseFloat(subtotalProdukElement.text().replace('Rp', '').replace(/\./g, '')) || 0;
            console.log('Subtotal Produk Awal:', subtotalProduk);

            // Ambil data keranjang dari PHP untuk digunakan di fetchShippingCost
            cartItemsData = <?= json_encode($cartItems) ?>;

            // Event listener untuk pilihan tipe pengantaran
            $('input[name="tipe_pengantaran"]').on('change', function() {
                const selectedType = $(this).val();
                const addressInputFieldContainer = $('#map-address-input').closest('.form-item');
                const mapContainer = $('#map-container');
                const getCurrentLocationBtn = $('#get-current-location-btn');

                const penerimaHpContainer = $('#penerima-nomor-hp-container');
                const penerimaHpInput = $('#penerima_nomor_hp_input');
                const alamatPengirimanInput = $('#map-address-input');
                const alamatLatitudeInput = $('#alamat-latitude');
                const alamatLongitudeInput = $('#alamat-longitude');

                console.log('Tipe pengantaran berubah menjadi:', selectedType);

                if (selectedType === 'Delivery') {
                    $('.shipping-option').closest('.form-check').show();
                    addressInputFieldContainer.show();
                    mapContainer.show();
                    getCurrentLocationBtn.show();
                    penerimaHpContainer.show();
                    penerimaHpInput.prop('required', true);
                    
                    alamatPengirimanInput.prop('required', true);

                    if (typeof L !== 'undefined' && typeof L.map === 'function') {
                        if (!map) {
                            initMap(); 
                        } else {
                            map.invalidateSize();
                        }
                    } else {
                        console.error('Leaflet JS belum dimuat atau tidak tersedia.');
                    }
                    // Event listeners peta diatur di initMap() sekarang, tidak perlu off/on lagi di sini
                    // Namun, pemicu ongkir perlu dipanggil lagi
                    // fetchShippingCost() akan dipanggil oleh initMap() atau event peta
                } else { // Self-Pickup
                    $('.shipping-option').closest('.form-check').hide();
                    $('#localPickup').closest('.form-check').show().find('input').prop('checked', true);
                    
                    addressInputFieldContainer.hide();
                    mapContainer.hide();
                    getCurrentLocationBtn.hide();
                    penerimaHpContainer.hide();
                    penerimaHpInput.prop('required', false).val(''); // Kosongkan nilainya

                    alamatPengirimanInput.prop('required', false);
                    alamatLatitudeInput.val('');
                    alamatLongitudeInput.val('');
                    console.log('Field alamat dan peta disembunyikan, koordinat dikosongkan.');
                }
                fetchShippingCost(); // Panggil ini untuk update biaya saat tipe pengantaran berubah
            });

            // Event listener untuk pilihan biaya pengiriman
            $('input[name="shipping_option"]').on('change', fetchShippingCost);

            // Inisialisasi tampilan awal saat halaman dimuat
            const initialDeliveryType = $('input[name="tipe_pengantaran"]:checked').val();
            if (initialDeliveryType !== 'Delivery') {
                $('#map-address-input').closest('.form-item').hide();
                $('#map-container').hide();
                $('#get-current-location-btn').hide();
                $('#penerima-nomor-hp-container').hide();
                $('#penerima_nomor_hp_input').prop('required', false);
                
                $('#map-address-input').prop('required', false);
                $('#alamat-latitude').val('');
                $('#alamat-longitude').val('');
            } else {
                $('#penerima-nomor-hp-container').show();
                $('#penerima_nomor_hp_input').prop('required', true);
                $('#map-address-input').prop('required', true);
                if ($('#map-container').is(':visible')) {
                    if (!map) initMap();
                    if (map) map.invalidateSize();
                }
            }
            fetchShippingCost(); // Panggil ini untuk update biaya awal halaman dimuat

            // Event listener untuk update ongkir saat input alamat berubah
            // Ini akan menangani perubahan yang tidak langsung dari interaksi peta
            $('#map-address-input').on('blur', function() {
                // Berikan sedikit waktu agar event change Leaflet/Geocoder sempat mengisi lat/lng
                setTimeout(fetchShippingCost, 200); 
            });

        });
    </script>
    <script>
        // Script untuk datetime picker di checkout.php
        document.addEventListener('DOMContentLoaded', function() {
            const dateTimePicker = document.getElementById('datetime-picker-checkout');

            function setMinDateTime() {
                const now = new Date();
                // Tambah 2 jam dari waktu sekarang
                now.setHours(now.getHours() + 2);

                // Format ke YYYY-MM-DDTHH:mm
                const year = now.getFullYear();
                const month = (now.getMonth() + 1).toString().padStart(2, '0');
                const day = now.getDate().toString().padStart(2, '0');
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');

                const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                
                // Atur atribut 'min' pada elemen input
                dateTimePicker.setAttribute('min', minDateTime);
            }

            // Panggil fungsi saat halaman dimuat
            setMinDateTime();
        });
    </script>
    </body>

</html>
