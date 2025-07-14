<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Keranjang Belanja - JS Florist</title> <meta content="width=device-width, initial-scale=1.0" name="viewport">
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

        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">

        <style>
             /* Mengubah warna latar belakang primary */
            .bg-primary {
                background-color: #d09c4c !important; /* Contoh: Warna tema utama */
            }
             .text-primary {
                color: #d09c4c !important; /* Contoh: Warna tema utama */
            }
             .border-primary {
                border-color: #d09c4c !important; /* Contoh: Warna tema utama */
            }
            .bg-secondary {
                background-color: #ebd4b6 !important; /* Contoh: Warna sekunder */
            }
             .text-secondary {
                color: #ebd4b6 !important; /* Contoh: Warna sekunder */
            }
             .border-secondary {
                border-color: #ebd4b6 !important; /* Contoh: Warna sekunder */
            }
            .featurs-item .featurs-icon::after {
                border-top-color: #b0853e !important; /* Warna oranye kecoklatan yang lebih gelap */
            }
            /* Menyesuaikan ukuran gambar di keranjang agar seragam */
            .table img {
                width: 80px;
                height: 80px;
                object-fit: cover; /* Penting agar gambar tidak distorsi */
                border-radius: 50%; /* Jika ingin tetap bulat seperti template */
            }
             /* Menyesuaikan tombol minus/plus */
            .input-group.quantity .btn-sm {
                width: 30px; /* Sesuaikan ukuran tombol */
                height: 30px; /* Sesuaikan ukuran tombol */
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .input-group.quantity .form-control-sm {
                height: 30px; /* Sesuaikan tinggi input agar sejajar tombol */
            }
            .table button.btn.btn-md.rounded-circle.bg-light.border {
                background-color: #f8f9fa !important; /* Warna latar belakang tombol hapus */
                border-color: #e2e3e5 !important; /* Warna border tombol hapus */
            }
            .table button.btn.btn-md.rounded-circle.bg-light.border i.fa-times {
                color: #dc3545 !important; /* Warna ikon silang */
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
            <h1 class="text-center text-white display-6">Keranjang Belanja</h1> <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item active text-white">Keranjang</li> </ol>
        </div>
        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Produk</th>
                            <th scope="col">Nama</th> <th scope="col">Harga</th>
                            <th scope="col">Kuantitas</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th> </tr>
                        </thead>
                        <tbody>
                            <?php $grandTotal = 0; ?>
                            <?php if (!empty($cartItems)): ?>
                                <?php foreach ($cartItems as $item): ?>
                                    <?php
                                        $itemTotal = $item['price'] * $item['quantity'];
                                        $grandTotal += $itemTotal;
                                    ?>
                                    <tr data-product-id="<?= esc($item['id']) ?>"> <th scope="row">
                                            <div class="d-flex align-items-center">
                                                <img src="<?= base_url('assets/img/gambar/' . esc($item['image'])) ?>" class="img-fluid me-5 rounded-circle" alt="<?= esc($item['name']) ?>">
                                            </div>
                                        </th>
                                        <td>
                                            <p class="mb-0 mt-4"><?= esc($item['name']) ?></p>
                                            <?php if (isset($item['options']['custom_details'])): ?>
                                                <?php 
                                                    // Decode JSON string dari custom_details
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
                                        <td>
                                            <p class="mb-0 mt-4">Rp<?= number_format($item['price'], 0, ',', '.') ?></p>
                                        </td>
                                        <td>
                                            <div class="input-group quantity mt-4" style="width: 100px;">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border quantity-btn" data-action="minus">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control form-control-sm text-center border-0 quantity-input" value="<?= esc($item['quantity']) ?>" min="1">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border quantity-btn" data-action="plus">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 mt-4">Rp<?= number_format($itemTotal, 0, ',', '.') ?></p>
                                        </td>
                                        <td>
                                            <button class="btn btn-md rounded-circle bg-light border mt-4 remove-from-cart-btn">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-4">Keranjang belanja Anda kosong. <a href="<?= base_url('dashboard') ?>">Mulai Belanja Sekarang!</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">Total Belanja:</th>
                                <th class="text-start">Rp<?= number_format($grandTotal, 0, ',', '.') ?></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-5">
                    <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4" placeholder="Kode Kupon"> <button class="btn border-secondary rounded-pill px-4 py-3 text-primary" type="button">Terapkan Kupon</button> </div>
                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Ringkasan <span class="fw-normal">Belanja</span></h1> <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0">Rp<?= number_format($grandTotal, 0, ',', '.') ?></p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Pengiriman:</h5> <div class="">
                                        <p class="mb-0">Akan dihitung saat Checkout</p> </div>
                                </div>
                                </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total:</h5>
                                <p class="mb-0 pe-4">Rp<?= number_format($grandTotal, 0, ',', '.') ?></p> </div>
                            <a href="<?= base_url('checkout') ?>" class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Lanjutkan ke Checkout</a> </div>
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

    <script src="<?= base_url('assets/js/main.js')?>"></script>

    <script>
         $(document).ready(function() {

        // --- Kode JavaScript dari fungsi-fungsi lain di dashboard.php (jika ada yang dipindahkan ke sini) ---
        // Contoh: searchProducts(), loadProducts(), dll.
        // HANYA jika Anda memutuskan memindahkannya ke cart.php
        // Pastikan juga event listener category-link, page-link juga digabung jika ada

        // --- Event listener untuk menghapus item dari keranjang ---
        $(document).on('click', '.remove-from-cart-btn', function() {
            var productId = $(this).closest('tr').data('product-id');
            if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
                $.ajax({
                    url: '<?= base_url('cart/remove/') ?>' + productId,
                    method: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            location.reload();
                        } else {
                            alert('Gagal menghapus produk: ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error, xhr.responseText);
                        alert('Terjadi kesalahan saat menghapus produk.');
                    }
                });
            }
        });

        // --- Fungsi untuk mengupdate kuantitas (tombol plus/minus) ---
        $(document).on('click', '.quantity-btn', function() {
            var $row = $(this).closest('tr');
            var productId = $row.data('product-id');
            var $qtyInput = $row.find('.quantity-input');
            var currentQuantity = parseInt($qtyInput.val());
            var action = $(this).data('action');

            var newQuantity = currentQuantity;
            if (action === 'minus') {
                newQuantity = Math.max(1, currentQuantity - 1);
            } else if (action === 'plus') {
                newQuantity = currentQuantity + 1;
            }
            
            $qtyInput.val(newQuantity); // Update input secara visual
            
            // Kirim update ke server hanya jika kuantitas berubah
            if (newQuantity !== currentQuantity) { // Pastikan perubahan terjadi
                sendQuantityUpdate(productId, newQuantity, currentQuantity);
            }
        });

        // --- Fungsi untuk mengupdate kuantitas (input manual) ---
        $(document).on('change', '.quantity-input', function() {
            var $row = $(this).closest('tr');
            var productId = $row.data('product-id');
            var newQuantity = parseInt($(this).val());
            var currentQuantity = parseInt($(this).data('current-qty')); // Simpan kuantitas sebelum perubahan

            if (isNaN(newQuantity) || newQuantity < 1) {
                alert('Kuantitas harus angka positif.');
                $(this).val(currentQuantity || 1); // Kembalikan ke nilai sebelumnya atau 1
                return;
            }
            sendQuantityUpdate(productId, newQuantity, currentQuantity);
        });

        // --- Fungsi pembantu untuk mengirim update kuantitas ke server ---
        function sendQuantityUpdate(productId, newQuantity, oldQuantity) {
            $.ajax({
                url: '<?= base_url('cart/update') ?>',
                method: 'POST',
                data: { product_id: productId, quantity: newQuantity },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        location.reload(); // Muat ulang halaman untuk update total
                    } else {
                        alert('Gagal memperbarui kuantitas: ' + response.message);
                        // Opsional: Kembalikan nilai input ke oldQuantity jika gagal
                        // Misalnya, $(`tr[data-product-id="${productId}"]`).find('.quantity-input').val(oldQuantity);
                        location.reload(); // Reload juga bisa untuk kembalikan nilai
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error, xhr.responseText);
                    alert('Terjadi kesalahan saat memperbarui kuantitas.');
                    // Opsional: Kembalikan nilai input ke oldQuantity jika gagal
                    // Misalnya, $(`tr[data-product-id="${productId}"]`).find('.quantity-input').val(oldQuantity);
                    location.reload(); // Reload juga bisa untuk kembalikan nilai
                }
            });
        }

            // Update cart item count di navbar saat halaman dimuat
            function updateNavbarCartCount() {
                $.ajax({
                    url: '<?= base_url('cart/totalItems') ?>', // Perlu endpoint baru di Cart controller
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('.navbar .position-relative .rounded-circle').text(response.total_items);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error fetching cart total items:", error);
                    }
                });
            }
            // updateNavbarCartCount(); // Panggil saat halaman dimuat
            // Perlu disesuaikan karena struktur navbar berbeda dengan dashboard.php

        });
    </script>
    </body>

</html>
