<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
    <title>Login</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
</head>

<body>
    <div class="signin-wrapper">
        <div class="form-wrapper">

            <div class="text-center mb-3">
                <!-- Logo SVG -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400" width="80" height="80">
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
            </div>

            <h2 class="mb-15 text-center">Smart Room ITH</h2>
            <p class="text-sm mb-25 text-center">Please sign in to continue.</p>

            <?php if (!empty(session()->getFlashdata('pesan'))) : ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('pesan') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif ?>

            <form method="POST" action="<?= base_url('login') ?>">
                <div class="input-style-1">
                    <label>Username</label>
                    <i class="bi bi-person-circle"></i>
                    <input type="text" class="<?= ($validation->hasError('username')) ? 'is-invalid' : '' ?> form-control" placeholder="Username" name="username">
                    <div class="invalid-feedback">
                        <?= $validation->getError('username') ?>
                    </div>
                </div>

                <div class="input-style-1">
                    <label>Password</label>
                    <i class="bi bi-lock-fill"></i>
                    <input type="password" class="<?= ($validation->hasError('password')) ? 'is-invalid' : '' ?> form-control" placeholder="Password" name="password">
                    <div class="invalid-feedback">
                        <?= $validation->getError('password') ?>
                    </div>
                </div>

                <div class="button-group d-flex justify-content-center">
                    <button type="submit" class="main-btn w-100">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>
