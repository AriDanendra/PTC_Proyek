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

    <aside class="sidebar-nav-wrapper">
        <div class="navbar-logo">
            <a href="index.html">
                <h3>Smart Room ITH</h3>
            </a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li class="nav-item mb-2">
                    <a href="<?= base_url('dosen/home') ?>" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                        </svg>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="<?= base_url('dosen/jadwal') ?>" class="nav-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M12 12l3 2" />
                            <path d="M12 7v5" />
                        </svg>
                        <span class="text">Jadwal</span>
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="<?= base_url('logout') ?>" class="nav-link">
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