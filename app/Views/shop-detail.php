// app/Views/shop-detail.php
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Fruitables - Vegetable Website Template</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

        <link href="<?= base_url('assets/lib/lightbox/css/lightbox.min.css') ?>" rel="stylesheet">
        <link href="<?= base_url('assets/lib/owlcarousel/assets/owl.carousel.min.css') ?>" rel="stylesheet">


        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">

        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
        <style>
            /* Konsistensi warna */
            .bg-primary { background-color: #d09c4c !important; }
            .text-primary { color: #d09c4c !important; }
            .border-primary { border-color: #d09c4c !important; }
            .bg-secondary { background-color: #ebd4b6 !important; }
            .text-secondary { color: #ebd4b6 !important; }
            .border-secondary { border-color: #ebd4b6 !important; }
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
        <div class="container-fluid page-header py-5" style="background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(<?= base_url('assets/img/page-header.webp') ?>) center center no-repeat; background-size: cover;">
            <h1 class="text-center text-white display-6">Detail Produk</h1>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="<?= site_url('dashboard') ?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= site_url('shop') ?>">Shop</a></li>
                <li class="breadcrumb-item active text-white">Detail Produk</li>
            </ol>
        </div>
        <div class="container-fluid py-5 mt-5">
            <div class="container py-5">
                <div class="row g-4 mb-5">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>" data-lightbox="product-image">
                                        <img src="<?= base_url('assets/img/gambar/' . esc($product['gambar_url'])) ?>" class="img-fluid rounded" alt="<?= esc($product['nama_produk']) ?>" style="width:100%; height:auto; object-fit: cover;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3"><?= esc($product['nama_produk']) ?></h4>
                                <p class="mb-3">Kategori: <?= esc($product['nama_kategori']) ?></p>
                                <h5 class="fw-bold mb-3 price-display">Rp<?= number_format($product['harga'], 0, ',', '.') ?></h5>

                                <?php if ($product['product_id'] === 'PRDKUANG'): ?>
                                    <p class="mb-4">Silakan isi form di bawah ini untuk membuat buket uang Anda. Harga yang tertera adalah <strong>biaya jasa rangkai saja</strong>, belum termasuk nominal uang.</p>
                                    <form id="custom_product_form" action="<?= site_url('cart/add') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
                                        <input type="hidden" name="product_name" value="<?= esc($product['nama_produk']) ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="custom_details[upah]" id="calculated_upah" value="0">
                                        <input type="hidden" name="custom_details[money_source_type]" id="money_source_type_input" value="uang_sendiri">
                                        <input type="hidden" name="product_price" id="product_total_price_for_cart" value="0">


                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Pilihan Sumber Uang</strong></label>
                                            <div class="d-flex">
                                                <div class="form-check me-4">
                                                    <input class="form-check-input money-source-radio" type="radio" name="money_source" id="money_source_own" value="uang_sendiri" required checked>
                                                    <label class="form-check-label" for="money_source_own">Uang Sendiri (Diantar ke Toko)</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input money-source-radio" type="radio" name="money_source" id="money_source_store" value="uang_dari_toko" required>
                                                    <label class="form-check-label" for="money_source_store">Uang dari Toko</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label class="form-label"><strong>Pilih Pecahan Uang</strong></label>
                                            <div class="d-flex">
                                                <div class="form-check me-4">
                                                    <input class="form-check-input pecahan-radio" type="radio" name="custom_details[pecahan]" id="pecahan_100k" value="100000" required checked>
                                                    <label class="form-check-label" for="pecahan_100k">Rp 100.000</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input pecahan-radio" type="radio" name="custom_details[pecahan]" id="pecahan_50k" value="50000" required>
                                                    <label class="form-check-label" for="pecahan_50k">Rp 50.000</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="nominal_uang" class="form-label"><strong>Isi Nominal Buket</strong> (misal: 1000000)</label>
                                            <input type="number" id="nominal_uang" name="custom_details[nominal]" class="form-control" min="50000" step="50000" required>
                                        </div>

                                        <div class="form-group mb-2">
                                            <p class="mb-0"><strong>Jumlah Lembar:</strong> <span id="display_lembar" class="fw-bold">0 Lembar</span></p>
                                            <p class="mb-0"><strong>Upah Jasa:</strong> <span id="display_upah" class="fw-bold">Rp 0</span></p>
                                            <p class="mb-0"><strong>Total yang harus dibayar:</strong> <span id="display_total_bayar" class="fw-bold text-primary">Rp 0</span></p>
                                        </div>

                                        <div id="limit_alert" class="alert alert-danger mt-3" style="display: none;">
                                            Permintaan melebihi 100 lembar. Untuk pesanan di atas 100 lembar, harga jasa berbeda. Silakan hubungi Customer Service kami via WhatsApp untuk penawaran khusus.
                                        </div>
                                        <div id="min_nominal_alert" class="alert alert-danger mt-3" style="display: none;">
                                            Jumlah lembar uang minimal adalah 5.
                                        </div>

                                        <button type="submit" id="submit_uang_request" class="btn border-secondary rounded-pill px-4 py-2 mb-4 text-primary mt-3">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Tambahkan ke Keranjang
                                        </button>
                                    </form>
                                <?php elseif ($product['product_id'] === 'PRDKCUST'): ?>
                                    <p class="mb-4">Silakan isi form di bawah ini untuk membuat pesanan kustom Anda.</p>
                                    <form action="<?= site_url('custom/checkout') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
                                        <input type="hidden" name="product_name" value="<?= esc($product['nama_produk']) ?>">
                                        <input type="hidden" name="product_price" value="<?= esc($product['harga']) ?>">
                                        <input type="hidden" name="quantity" value="1">

                                        <div class="form-group mb-3">
                                            <label for="jenis_item" class="form-label"><strong>Jenis Item</strong> (misal: beng-beng, hotwheels)</label>
                                            <input type="text" id="jenis_item" name="custom_details[jenis_item]" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="jumlah_item" class="form-label"><strong>Jumlah Item</strong> </label>
                                            <input type="text" id="jumlah_item" name="custom_details[jumlah_item]" class="form-control" required>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label class="form-label"><strong>Request Bunga</strong> (pilih satu atau lebih)</label>
                                            <div class="row">
                                                <?php
                                                    // Anggap $available_flowers adalah array dari controller
                                                    $available_flowers = ['Mawar Merah', 'Mawar Putih', 'Lily', 'Tulip', 'Anggrek', 'Anyelir'];
                                                    foreach ($available_flowers as $flower):
                                                ?>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="custom_details[bunga][]" value="<?= esc($flower) ?>" id="flower_<?= str_replace(' ', '_', $flower) ?>">
                                                        <label class="form-check-label" for="flower_<?= str_replace(' ', '_', $flower) ?>"><?= esc($flower) ?></label>
                                                    </div>
                                                </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-paper-plane me-2 text-primary"></i> Lanjutkan & Ajukan Permintaan</button>
                                    </form>
                                <?php else: ?>
                                    <p class="mb-4"><?= nl2br(esc($product['deskripsi_produk'])) ?></p>
                                    <form action="<?= site_url('cart/add') ?>" method="post" class="add-to-cart-form-detail">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="product_id" value="<?= esc($product['product_id']) ?>">
                                        <input type="hidden" name="product_name" value="<?= esc($product['nama_produk']) ?>">
                                        <input type="hidden" name="product_price" value="<?= esc($product['harga']) ?>">

                                        <div class="input-group quantity mb-5" style="width: 120px;">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-minus rounded-circle bg-light border" type="button">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </div>
                                            <input type="text" name="quantity" class="form-control form-control-sm text-center border-0" value="1" min="1">
                                            <div class="input-group-btn">
                                                <button class="btn btn-sm btn-plus rounded-circle bg-light border" type="button">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                    </div>
                                        <button type="submit" class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary"><i class="fa fa-shopping-bag me-2 text-primary"></i> Tambah ke Keranjang</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description</button>
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p><?= nl2br(esc($product['deskripsi_produk'])) ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <h1 class="fw-bold mb-0">Produk Terkait</h1>
                <div class="vesitable">
                    <div class="owl-carousel vegetable-carousel justify-content-center">
                        <?php if (!empty($relatedProducts)): ?>
                            <?php foreach ($relatedProducts as $related): ?>
                                <div class="border border-primary rounded position-relative vesitable-item">
                                    <div class="vesitable-img" style="height: 250px; overflow: hidden;">
                                        <a href="<?= site_url('shop/product/' . $related['product_id']) ?>">
                                            <img src="<?= base_url('assets/img/gambar/' . esc($related['gambar_url'])) ?>" class="img-fluid w-100 rounded-top" alt="<?= esc($related['nama_produk']) ?>" style="height: 100%; object-fit: cover;">
                                        </a>
                                    </div>
                                    <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?= esc($product['nama_kategori']) ?></div>
                                    <div class="p-4 pb-0 rounded-bottom">
                                        <h4><?= esc($related['nama_produk']) ?></h4>
                                        <p><?= esc(substr($related['deskripsi_produk'], 0, 50)) . '...' ?></p>
                                        <div class="d-flex justify-content-between flex-lg-wrap">
                                            <p class="text-dark fs-5 fw-bold">Rp<?= number_format($related['harga'], 0, ',', '.') ?></p>
                                            <a href="<?= site_url('shop/product/' . $related['product_id']) ?>" class="btn border border-secondary rounded-pill px-3 py-1 mb-4 text-primary"><i class="fa fa-eye me-2 text-primary"></i> Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada produk terkait.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <a href="#">
                                <h1 class="text-primary mb-0">JS Florist</h1>
                                <p class="text-secondary mb-0">Produk Segar</p>
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="position-relative mx-auto">
                                <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number" placeholder="Your Email">
                                <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="d-flex justify-content-end pt-3">
                                <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Why People Like us!</h4>
                            <p class="mb-4">typesetting, remaining essentially unchanged. It was
                                popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                            <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read More</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Shop Info</h4>
                            <a class="btn-link" href="">About Us</a>
                            <a class="btn-link" href="">Contact Us</a>
                            <a class="btn-link" href="">Privacy Policy</a>
                            <a class="btn-link" href="">Terms & Condition</a>
                            <a class="btn-link" href="">Return Policy</a>
                            <a class="btn-link" href="">FAQs & Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="d-flex flex-column text-start footer-item">
                            <h4 class="text-light mb-3">Account</h4>
                            <a class="btn-link" href="">My Account</a>
                            <a class="btn-link" href="">Shop details</a>
                            <a class="btn-link" href="">Shopping Cart</a>
                            <a class="btn-link" href="">Wishlist</a>
                            <a class="btn-link" href="">Order History</a>
                            <a class="btn-link" href="">International Orders</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-item">
                            <h4 class="text-light mb-3">Contact</h4>
                            <p>Address: 1429 Netus Rd, NY 48247</p>
                            <p>Email: Example@gmail.com</p>
                            <p>Phone: +0123 4567 8910</p>
                            <p>Payment Accepted</p>
                            <img src="<?= base_url('assets/img/payment.png') ?>" class="img-fluid" alt="">
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
    <script src="<?= base_url('assets/lib/easing/easing.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/waypoints/waypoints.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/lightbox/js/lightbox.min.js') ?>"></script>
    <script src="<?= base_url('assets/lib/owlcarousel/owl.carousel.min.js') ?>"></script>

    <script src="<?= base_url('assets/js/main.js') ?>"></script>
    <script>
        $(document).ready(function() {
            // Quantity buttons
            $('.btn-plus').on('click', function() {
                var input = $(this).closest('.quantity').find('input[name="quantity"]');
                input.val(parseInt(input.val()) + 1);
            });
            $('.btn-minus').on('click', function() {
                var input = $(this).closest('.quantity').find('input[name="quantity"]');
                var value = parseInt(input.val());
                if (value > 1) {
                    input.val(value - 1);
                }
            });
        });

        // --- Script khusus untuk form Buket Uang (PRDKUANG) ---
        const customProductForm = document.getElementById('custom_product_form');
        const pecahanRadios = document.querySelectorAll('input[name="custom_details[pecahan]"]');
        const nominalInput = document.getElementById('nominal_uang');
        const displayLembar = document.getElementById('display_lembar');
        const displayUpah = document.getElementById('display_upah');
        const displayTotalBayar = document.getElementById('display_total_bayar');
        const limitAlert = document.getElementById('limit_alert');
        const minNominalAlert = document.getElementById('min_nominal_alert');
        const submitButton = document.getElementById('submit_uang_request');
        const calculatedUpahInput = document.getElementById('calculated_upah');
        const moneySourceRadios = document.querySelectorAll('.money-source-radio');
        const moneySourceTypeInput = document.getElementById('money_source_type_input');
        const productTotalPriceForCart = document.getElementById('product_total_price_for_cart');


        function calculateUpah(lembar) {
            let upah = 0;
            if (lembar >= 5 && lembar <= 20) {
                upah = 250000;
            } else if (lembar >= 21 && lembar <= 40) {
                upah = 400000;
            } else if (lembar >= 41 && lembar <= 60) {
                upah = 600000;
            } else if (lembar >= 61 && lembar <= 80) {
                upah = 800000;
            } else if (lembar >= 81 && lembar <= 100) {
                upah = 1000000;
            }
            return upah;
        }

        function updateMoneyBouquetSummary() {
            if (!nominalInput || !displayLembar || !displayUpah || !displayTotalBayar || !limitAlert || !minNominalAlert || !submitButton || !calculatedUpahInput || !moneySourceTypeInput || !customProductForm || !productTotalPriceForCart) return;

            const selectedPecahan = parseInt(document.querySelector('input[name="custom_details[pecahan]"]:checked').value);
            const nominal = parseInt(nominalInput.value);
            const selectedMoneySource = document.querySelector('input[name="money_source"]:checked').value;

            // Reset alerts and button status
            limitAlert.style.display = 'none';
            minNominalAlert.style.display = 'none';
            submitButton.disabled = false;

            if (isNaN(nominal) || nominal <= 0 || nominal % selectedPecahan !== 0) {
                displayLembar.textContent = 'Nominal tidak valid';
                displayUpah.textContent = 'Rp 0';
                displayTotalBayar.textContent = 'Rp 0';
                calculatedUpahInput.value = 0;
                productTotalPriceForCart.value = 0; // Reset for cart
                submitButton.disabled = true;
                return;
            }

            const lembar = nominal / selectedPecahan;
            displayLembar.textContent = `${lembar} Lembar`;

            if (lembar < 5) {
                minNominalAlert.style.display = 'block';
                submitButton.disabled = true;
                displayUpah.textContent = 'Rp 0';
                displayTotalBayar.textContent = 'Rp 0';
                calculatedUpahInput.value = 0;
                productTotalPriceForCart.value = 0;
                return;
            }

            if (lembar > 100) {
                limitAlert.style.display = 'block';
                submitButton.disabled = true;
                displayUpah.textContent = 'Rp 0';
                displayTotalBayar.textContent = 'Rp 0';
                calculatedUpahInput.value = 0;
                productTotalPriceForCart.value = 0;
                return;
            }

            const upahJasa = calculateUpah(lembar);
            displayUpah.textContent = `Rp ${upahJasa.toLocaleString('id-ID')}`;
            calculatedUpahInput.value = upahJasa; // Set hidden input value

            let totalBayar = 0;
            // Both "uang_sendiri" and "uang_dari_toko" will now go through cart/add
            customProductForm.action = '<?= site_url('cart/add') ?>';
            submitButton.textContent = 'Tambahkan ke Keranjang';

            if (selectedMoneySource === 'uang_sendiri') {
                totalBayar = upahJasa; // Only pay upah
                moneySourceTypeInput.value = 'uang_sendiri'; // Update hidden input
                productTotalPriceForCart.value = totalBayar; // Set price for cart (only upah)
            } else if (selectedMoneySource === 'uang_dari_toko') {
                totalBayar = nominal + upahJasa; // Pay nominal + upah
                moneySourceTypeInput.value = 'uang_dari_toko'; // Update hidden input
                productTotalPriceForCart.value = totalBayar; // Set price for cart (nominal + upah)
            }
            displayTotalBayar.textContent = `Rp ${totalBayar.toLocaleString('id-ID')}`;
        }

        if (nominalInput) {
            pecahanRadios.forEach(radio => {
                radio.addEventListener('change', updateMoneyBouquetSummary);
            });
            nominalInput.addEventListener('input', updateMoneyBouquetSummary);
            moneySourceRadios.forEach(radio => {
                radio.addEventListener('change', updateMoneyBouquetSummary);
            });

            updateMoneyBouquetSummary(); // Initial call to set correct values on load
        }
    </script>
    </body>

</html>