<div class="container-fluid fixed-top">
    <div class="container topbar bg-primary d-none d-lg-block">
        <div class="d-flex justify-content-between">
            <div class="top-info ps-2">
                <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Jl. Dahlia No.23, Komet, Kec. Banjarbaru Selatan, Kota Banjar Baru</a></small>
                <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">support@jsflorist.com</a></small>
            </div>
            <div class="top-link pe-2">
                <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
            </div>
        </div>
    </div>
    <div class="container px-0">
        <nav class="navbar navbar-light bg-white navbar-expand-xl">
            <a href="<?= site_url('/dashboard') ?>" class="navbar-brand">
                <h1 class="text-primary display-6">
                    <img src="<?= base_url('assets/img/logo_js.svg') ?>" alt="Logo Js Florist" style="height: 50px; vertical-align: middle; margin-right: 10px;">
                    Js Florist
                </h1>
            </a>
            <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="fa fa-bars text-primary"></span>
            </button>
            <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
            <div class="navbar-nav mx-auto">
                <?php $uri = service('uri'); ?>
                <a href="<?= site_url('/dashboard') ?>" class="nav-item nav-link <?= ($uri->getSegment(1) === 'dashboard' || $uri->getSegment(1) === '') ? 'active' : '' ?>">Home</a>
                <a href="<?= site_url('shop') ?>" class="nav-item nav-link <?= ($uri->getSegment(1) === 'shop') ? 'active' : '' ?>">Shop</a>
            </div>

                <div class="d-flex m-3 me-0">
                    <a href="<?= site_url('track-order') ?>" class="position-relative me-4 my-auto" title="Lacak Pesanan">
                        <i class="fas fa-truck fa-2x"></i>
                    </a>
                    <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                    <a href="<?= site_url('cart') ?>" class="position-relative me-4 my-auto">
                        <i class="fa fa-shopping-bag fa-2x"></i>
                        <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                            <?php
                                $totalItems = 0;
                                if (session()->has('cart')) {
                                    foreach (session('cart') as $item) {
                                        $totalItems += $item['quantity'] ?? 0;
                                    }
                                }
                                echo $totalItems;
                            ?>
                        </span>
                    </a>

                    <a href="#" class="my-auto">
                        <i class="fas fa-user fa-2x"></i>
                    </a>
                </div>
            </div>
        </nav>
    </div>
</div>
