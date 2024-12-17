<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon" />
    <title>Dashboard Smart Room</title>

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

    <!-- ======== sidebar-nav start =========== -->
    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="index.html">
                <img style="width: 100%;" src="assets/images/logo/logo-utama.svg" alt="logo" />
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item mb-2">
                    <a href="dashboard.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-home">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item nav-item-has-children mb-2">
                    <a
                        href="jadwal.html"
                        class="collapsed"
                        data-bs-toggle="collapse"
                        data-bs-target="#ddmenu_1"
                        aria-controls="ddmenu_1"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-hour-4">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 12l3 2" />
                            <path d="M12 7v5" />
                        </svg>
                        <span class="text">Jadwal</span>
                    </a>
                    <ul id="ddmenu_1" class="collapse dropdown-nav">
                        <li>
                            <a href="index.html"> Pekan 1 </a>
                        </li>
                        <li>
                            <a href="index.html"> Pekan 2 </a>
                        </li>
                        <li>
                            <a href="index.html"> Pekan 3 </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item mb-2">
                    <a href="invoice.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                        </svg>
                        <span class="text">Profil</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="invoice.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                            <path d="M9 12h12l-3 -3" />
                            <path d="M18 15l3 -3" />
                        </svg>
                        <span class="text">Logout</span>
                    </a>
                </li>

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
                                                <img src="assets/images/profile/profile-image.png" alt="" />
                                            </div>
                                            <div>
                                                <h6 class="fw-500">Adam Joe</h6>
                                                <p>Admin</p>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                                    <li>
                                        <div class="author-info flex items-center !p-1">
                                            <div class="image">
                                                <img src="assets/images/profile/profile-image.png" alt="image">
                                            </div>
                                            <div class="content">
                                                <h4 class="text-sm">Adam Joe</h4>
                                                <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs"
                                                    href="#">Email@gmail.com</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#0">
                                            <i class="lni lni-user"></i> View Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#0">
                                            <i class="lni lni-alarm"></i> Notifications
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#0"> <i class="lni lni-inbox"></i> Messages </a>
                                    </li>
                                    <li>
                                        <a href="#0"> <i class="lni lni-cog"></i> Settings </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="#0"> <i class="lni lni-exit"></i> Sign Out </a>
                                    </li>
                                </ul>
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
                                <h2>Title</h2>
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
                    <div class="col-md-6">
                        <div class="terms d-flex justify-content-center justify-content-md-end">
                            <a href="#0" class="text-sm">Term & Conditions</a>
                            <a href="#0" class="text-sm ml-15">Privacy & Policy</a>
                        </div>
                    </div>
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
</body>

</html>