<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Admin JS Florist</title>
    <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"/>
    <style>
        /* General Body & Wrapper Styles */
        body {
            background-color: #f8f9fa;
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        #wrapper {
            display: flex;
            padding-top: 56px; /* Height of the navbar */
        }

        /* Sidebar Styles */
        #sidebar-wrapper {
            min-width: 250px;
            max-width: 250px;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
            transition: transform 0.3s ease-in-out;
            position: sticky; /* Sticky on desktop */
            top: 56px; /* Align with bottom of navbar */
            height: calc(100vh - 56px); /* Full height minus navbar */
            overflow-y: auto;
        }
        .sidebar-heading {
            padding: 1rem 1.25rem;
            font-size: 1.2rem;
            font-weight: 600;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
        .list-group-item {
            border: none;
            background-color: transparent;
            color: #212529;
            padding: 1rem 1.5rem;
            transition: all 0.2s;
            border-radius: 0.25rem;
            margin: 0 1rem 0.25rem 1rem;
            width: calc(100% - 2rem);
        }
        .list-group-item:hover, .list-group-item.active {
            background-color: #d09c4c !important;
            color: #fff !important;
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
        }
        .list-group-item i {
            transition: color 0.2s;
        }
        .list-group-item:hover i, .list-group-item.active i {
            color: #fff !important;
        }

        /* Page Content Styles */
        #page-content-wrapper {
            width: 100%;
            padding: 1.5rem;
        }

        /* Mobile Responsive Styles (Off-canvas) */
        @media (max-width: 991.98px) {
            #sidebar-wrapper {
                position: fixed; /* Fixed position for overlay */
                top: 0;
                left: 0;
                height: 100vh;
                z-index: 1040; /* Higher than navbar */
                transform: translateX(-100%); /* Hidden by default */
            }
            #wrapper.toggled #sidebar-wrapper {
                transform: translateX(0); /* Shown when toggled */
            }
            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1030; /* Below sidebar, above content */
                display: none;
            }
            #wrapper.toggled .sidebar-overlay {
                display: block;
            }
        }

        /* Navbar Styles */
        .navbar {
            z-index: 1035; /* High z-index */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button (Visible only on mobile) -->
            <button class="btn btn-outline-secondary d-lg-none me-2" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a href="<?= base_url('admin/orders') ?>" class="navbar-brand">
                <h1 class="text-primary" style="font-size: 1.5rem; margin: 0;">JS Florist Admin</h1>
            </a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <span class="navbar-text me-3 text-dark">Selamat Datang, Admin!</span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger btn-sm" href="<?= base_url('logout') ?>">
                            <i class="fas fa-sign-out-alt me-1"></i>Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="wrapper">
        <!-- Sidebar Overlay (for mobile) -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading">Navigasi Admin</div>
            <div class="list-group list-group-flush">
                <a href="<?= base_url('admin/orders') ?>" class="list-group-item list-group-item-action <?= service('uri')->getSegment(2) == 'orders' ? 'active' : '' ?>">
                    <i class="fas fa-clipboard-list me-2"></i> Pemesanan
                </a>
                <a href="<?= base_url('admin/custom-requests') ?>" class="list-group-item list-group-item-action <?= service('uri')->getSegment(2) == 'custom-requests' ? 'active' : '' ?>">
                    <i class="fas fa-comments me-2"></i> Custom Requests
                </a>
                <a href="<?= base_url('admin/revenue') ?>" class="list-group-item list-group-item-action <?= service('uri')->getSegment(2) == 'revenue' ? 'active' : '' ?>">
                    <i class="fas fa-chart-line me-2"></i> Pendapatan
                </a>
                <a href="<?= base_url('admin/products') ?>" class="list-group-item list-group-item-action <?= service('uri')->getSegment(2) == 'products' ? 'active' : '' ?>">
                    <i class="fas fa-boxes me-2"></i> Produk
                </a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const wrapper = document.getElementById('wrapper');
            const overlay = document.querySelector('.sidebar-overlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    wrapper.classList.toggle('toggled');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    wrapper.classList.remove('toggled');
                });
            }
        });
    </script>
    <?= $this->renderSection('extra_js') ?>
</body>
</html>
