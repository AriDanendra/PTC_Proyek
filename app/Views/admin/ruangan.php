<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="mb-3">
    <a href="<?= base_url('admin/ruangan/tambah') ?>" class="btn btn-primary">Tambah Ruangan</a>
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


<div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>Nama Ruangan</th>
                <th>Kapasitas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ruangan as $row): ?>
                <tr>
                    <td><?= esc($row['nama_ruangan']) ?></td>
                    <td><?= esc($row['kapasitas']) ?></td>
                    <td>
                        <a href="<?= base_url('admin/ruangan/edit/' . $row['id_ruangan']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_ruangan'] ?>">Hapus</button>
                    </td>
                </tr>

                <!-- Modal Hapus -->
                <div class="modal fade" id="modalHapus<?= $row['id_ruangan'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konfirmasi Hapus</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                Apakah Anda yakin ingin menghapus ruangan <b><?= esc($row['nama_ruangan']) ?></b> dengan kapasitas <b><?= esc($row['kapasitas']) ?></b>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <a href="<?= base_url('admin/ruangan/hapus/' . $row['id_ruangan']) ?>" class="btn btn-danger">Hapus</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>