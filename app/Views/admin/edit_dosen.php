<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<form action="<?= base_url('admin/dosen/update/' . $id_dosen) ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" id="nama" class="form-control" value="<?= old('nama', $dosen['nama']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="matakuliah">Mata Kuliah</label>
        <input type="text" name="matakuliah" id="matakuliah" class="form-control" value="<?= old('matakuliah', $dosen['matakuliah']) ?>" required>
    </div>
    <div class="mb-3">
        <label for="absen">Absen</label>
        <input type="number" name="absen" id="absen" class="form-control" value="<?= old('absen', (int) $dosen['absen']) ?>" required>
    </div>


    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
    <a href="<?= base_url('admin/dosen') ?>" class="btn btn-secondary mt-3">Batal</a>
</form>

<?= $this->endSection() ?>