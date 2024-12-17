<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= base_url('dosen/jadwal/pesan') ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="id_jadwal" value="<?= esc($id_jadwal) ?>">

    <div class="mb-3">
        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
        <input type="text" class="form-control" id="nama_ruangan" value="<?= esc($jadwal['nama_ruangan']) ?>" disabled>
    </div>

    <div class="mb-3">
        <label for="nama_dosen" class="form-label">Nama Dosen</label>
        <input type="text" class="form-control" id="nama_dosen" value="<?= esc($nama_dosen) ?>" readonly>
    </div>

    <div class="mb-3">
        <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
        <input type="text" class="form-control" id="mata_kuliah" name="mata_kuliah" required>
    </div>

    <div class="mb-3">
        <label for="kelas" class="form-label">Kelas</label>
        <input type="text" class="form-control" id="kelas" name="kelas" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('dosen/jadwal') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
