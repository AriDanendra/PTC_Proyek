<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="mb-3">
    <a href="<?= base_url('admin/pengguna/tambah') ?>" class="btn btn-primary">Tambah Pengguna</a>
</div>

<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>


<div class="table-responsive mb-4">
    <table class="table table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Nama Pengguna</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>Fingerprint ID</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengguna as $row): ?>
                <tr>
                    <td><?= esc($row['nama']) ?></td>
                    <td><?= esc($row['username']) ?></td>
                    <td><?= esc($row['password']) ?></td>
                    <td><?= esc($row['role']) ?></td>
                    <td><?= esc($row['fingerprint_id']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/pengguna/edit/' . $row['id_pengguna']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_pengguna'] ?>">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus<?= $row['id_pengguna'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus pengguna <b><?= esc($row['nama']) ?></b> dengan username <b><?= esc($row['username']) ?></b>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <a href="<?= base_url('admin/pengguna/hapus/' . $row['id_pengguna']) ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>