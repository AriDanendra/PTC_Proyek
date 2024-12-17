<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>

<h3>Edit Profil</h3>

<form action="<?= base_url('dosen/pengguna/profil/update') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?= old('nama', $pengguna['nama']) ?>">
    </div>
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $pengguna['username']) ?>">
    </div>
    <div class="mb-3">
        <label for="password">Password (Kosongkan jika tidak ingin diubah)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="<?= base_url('dosen/pengguna') ?>" class="btn btn-secondary">Batal</a>
</form>

<?= $this->endSection() ?>
