<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title><?= $title ?></title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/lineicons.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/materialdesignicons.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/fullcalendar.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.21.0/tabler-icons.min.css" integrity="sha512-XrgoTBs7P5YtpkeKqKOKkruURsawIaRrhe8QrcWeMnFeyRZiOcRNjBAX+AQeXOvx9/9fSY32dVct1PccRoCICQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->
    <style>
        /* Sidebar wrapper styles */
        .sidebar-nav-wrapper {
            background: #ffffff;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar navigation container */
        .sidebar-nav {
            padding: 0 15px;
        }

        /* Navigation item container */
        .sidebar-nav .nav-item {
            position: relative;
            margin: 5px 0;
        }

        /* Basic link styling */
        .sidebar-nav .nav-item .nav-link {
            color: #64748b;
            padding: 12px 15px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            background: transparent;
        }

        /* Icon styling */
        .sidebar-nav .nav-item .nav-link .icon {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
        }

        /* Hover effect */
        .sidebar-nav .nav-item .nav-link:hover {
            background: #f1f5f9;
            color: #4A6CF7;
        }

        .sidebar-nav .nav-item .nav-link:hover .icon {
            color: #4A6CF7;
        }

        /* Active state styling */
        .sidebar-nav .nav-item .nav-link.active {
            background: linear-gradient(to right, #4A6CF7, #818CF8);
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(74, 108, 247, 0.2);
        }

        .sidebar-nav .nav-item .nav-link.active .icon {
            color: #ffffff;
        }

        /* Text styling */
        .sidebar-nav .nav-item .nav-link .text {
            font-size: 0.95rem;
            letter-spacing: 0.3px;
        }

        /* Special styling for logout */
        .sidebar-nav .nav-item:last-child .nav-link {
            color: #ef4444;
        }

        .sidebar-nav .nav-item:last-child .nav-link:hover {
            background: #fef2f2;
            color: #dc2626;
        }

        .sidebar-nav .nav-item:last-child .nav-link:hover .icon {
            color: #dc2626;
        }

        /* Logo section styling */
        .navbar-logo {
            padding: 20px 25px;
            border-bottom: 1px solid #e2e8f0;
        }

        .navbar-logo h3 {
            color: #1e293b;
            font-weight: 600;
            font-size: 1.25rem;
        }
    </style>
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="#">
                <div class="logo-wrapper" style="display: flex; align-items: center; gap: 10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" width="40" height="40">
                        <!-- Background circles -->
                        <circle cx="200" cy="200" r="190" fill="black" />
                        <circle cx="200" cy="200" r="180" fill="white" />
                        <circle cx="200" cy="200" r="170" fill="black" />
                        <!-- Centered fingerprint icon, scaled up from 24x24 -->
                        <g transform="translate(100, 100) scale(8)" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                            <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                            <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                            <path d="M8 15a18 18 0 0 0 1.8 6" />
                            <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
                        </g>
                    </svg>
                    <h3 style="font-size: 1.2rem; margin: 0;">Smart Room ITH</h3>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <?php
            $current_url = current_url();
            $base_url = base_url();
            ?>
            <ul>
                <li class="nav-item">
                    <a href="<?= base_url('dosen/home') ?>"
                        class="nav-link <?= (strpos($current_url, 'dosen/home') !== false) ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('dosen/jadwal') ?>"
                        class="nav-link <?= (strpos($current_url, 'dosen/jadwal') !== false) ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 12l3 2" />
                            <path d="M12 7v5" />
                        </svg>
                        <span class="text">Jadwal</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('dosen/profil') ?>"
                        class="nav-link <?= (strpos($current_url, 'dosen/profil') !== false) ? 'active' : '' ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path d="M12 12c2.828 0 4.828-2 4.828-4.828S14.828 2.344 12 2.344 7.172 4.344 7.172 7.172 9.172 12 12 12z"></path>
                            <path d="M21 20.657v1.343H3v-1.343c0-3.313 5.373-6 9-6s9 2.687 9 6z"></path>
                        </svg>
                        <span class="text">Profil</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?= base_url('logout') ?>"
                        class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M9 12h12l-3 -3" />
                            <path d="M18 15l3 -3" />
                        </svg>
                        <span class="text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>

    <div class="overlay"></div>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <header class="header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-5 col-6">
                        <div class="header-left d-flex align-items-center">
                            <div class="menu-toggle-btn mr-15">
                                <button id="menu-toggle" class="main-btn primary-btn btn-hover">
                                    <i class="lni lni-chevron-left me-2"></i> Menu
                                </button>
                            </div>
                            <!-- Date and time display beside the menu button -->
                            <div class="date-time-box ms-3">
                                <span id="current-date-time" class="fw-500 text-uppercase"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7 col-6">
                        <div class="header-right">

                            <!-- profile start -->
                            <div class="profile-box ml-15">
                                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="profile-info">
                                        <div class="info">
                                            <div class="image">
                                                <img src="<?= base_url('assets/images/profile/profile-image.png') ?>" alt="" />
                                            </div>
                                            <div>
                                                <h6 class="fw-500 text-uppercase"><?= session()->get('username') ?></h6>
                                                <p><?= session()->get('role_id') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </div>
                            <!-- profile end -->
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2><?= $title ?></h2>
                            </div>
                        </div>
                        <!-- end col -->

                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->

                <?= $this->renderSection('content') ?>
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 order-last order-md-first">
                        <div class="copyright text-center text-md-start">

                        </div>
                    </div>
                    <!-- end col-->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </footer>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/jvectormap.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/polyfill.js') ?>"></script>
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- Date and time script -->
    <script>
        function updateDateTime() {
            const dateTimeElement = document.getElementById("current-date-time");
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            dateTimeElement.textContent = now.toLocaleDateString('id-ID', options);
        }

        // Update date and time every second
        setInterval(updateDateTime, 1000);
    </script>

</body>

</html>