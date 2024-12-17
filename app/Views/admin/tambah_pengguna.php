<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('validation')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('validation') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?= base_url('admin/pengguna/simpan') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama') ?>" required>
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?= old('username') ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="Admin">Admin</option>
            <option value="Dosen">Dosen</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="fingerprint_id" class="form-label">Fingerprint ID</label>
        <select class="form-select" id="fingerprint_id" name="fingerprint_id" required>
            <option value="" disabled selected>Pilih Fingerprint</option>
            <?php foreach ($dosen as $fp): ?>
                <option value="<?= esc($fp['id']) ?>"><?= esc($fp['nama']) ?> (ID: <?= esc($fp['id']) ?>)</option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/pengguna') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>