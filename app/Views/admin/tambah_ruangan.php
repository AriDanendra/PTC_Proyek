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


<form action="<?= base_url('admin/ruangan/simpan') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
        <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" value="<?= old('nama_ruangan') ?>" required>
    </div>
    <div class="mb-3">
        <label for="kapasitas" class="form-label">Kapasitas</label>
        <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?= old('kapasitas') ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/ruangan') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
