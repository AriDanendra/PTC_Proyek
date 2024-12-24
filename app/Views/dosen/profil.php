<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 ps-2">Profil Pengguna</h4>
        </div>
        <div class="card-body">
            <?php if ($pengguna): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th class="bg-light" style="width: 30%;">Nama</th>
                            <td class="ps-3"><?= esc($pengguna['nama']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Username</th>
                            <td class="ps-3"><?= esc($pengguna['username']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Fingerprint ID</th>
                            <td class="ps-3"><?= esc($pengguna['fingerprint_id']) ?></td>
                        </tr>
                        <tr>
                            <th class="bg-light">Role</th>
                            <td class="ps-3"><?= esc($pengguna['role']) ?></td>
                        </tr>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center" role="alert">
                    <strong class="ps-2">Data pengguna tidak ditemukan.</strong>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-footer text-end">
            <a href="<?= base_url('dosen/profil/edit/' . $pengguna['id_pengguna']) ?>" class="btn btn-warning">Edit Profil</a>
            <a href="<?= base_url('dosen/home') ?>" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>