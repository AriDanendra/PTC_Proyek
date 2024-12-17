<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/ruangan/update/' . $id_ruangan) ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="nama_ruangan">Nama Ruangan</label>
        <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control" value="<?= old('nama_ruangan', $ruangan['nama_ruangan']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="kapasitas">Kapasitas</label>
        <input type="number" name="kapasitas" id="kapasitas" class="form-control" value="<?= old('kapasitas', $ruangan['kapasitas']) ?>" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    <a href="<?= base_url('admin/ruangan') ?>" class="btn btn-secondary mt-3">Batal</a>
</form>

<?= $this->endSection() ?>
