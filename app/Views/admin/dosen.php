<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>


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

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Mata Kuliah</th>
            <th>Absen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dosen as $row): ?>
            <tr>
                <td><?= esc($row['id']) ?></td>
                <td><?= esc($row['nama']) ?></td>
                <td><?= esc($row['matakuliah']) ?></td>
                <td><?= esc($row['absen']) ?></td>
                <td>
                    <a href="<?= base_url('admin/dosen/edit/' . $row['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id'] ?>">Hapus</button>
                </td>
            </tr>

            <!-- Modal Hapus -->
            <div class="modal fade" id="modalHapus<?= $row['id'] ?>" tabindex="-1" aria-labelledby="modalLabelHapus<?= $row['id'] ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabelHapus<?= $row['id'] ?>">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus dosen <b><?= esc($row['nama']) ?></b> dengan ID <b><?= esc($row['id']) ?></b>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <a href="<?= base_url('admin/dosen/hapus/' . $row['id']) ?>" class="btn btn-danger">Hapus</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>