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

<form action="<?= base_url('admin/jadwal/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="mb-3">
        <label for="id_ruangan" class="form-label">Ruangan</label>
        <select class="form-select" id="id_ruangan" name="id_ruangan" required>
            <option value="">-- Pilih Ruangan --</option>
            <?php foreach ($ruangan as $r): ?>
                <option value="<?= esc($r['id_ruangan']) ?>" <?= old('id_ruangan') == $r['id_ruangan'] ? 'selected' : '' ?>>
                    <?= esc($r['nama_ruangan']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="hari" class="form-label">Hari</label>
        <select class="form-select" id="hari" name="hari" required>
            <option value="Senin" <?= old('hari') == 'Senin' ? 'selected' : '' ?>>Senin</option>
            <option value="Selasa" <?= old('hari') == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
            <option value="Rabu" <?= old('hari') == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
            <option value="Kamis" <?= old('hari') == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
            <option value="Jumat" <?= old('hari') == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="pekan" class="form-label">Pekan</label>
        <input type="number" class="form-control" id="pekan" name="pekan" value="<?= old('pekan') ?>" required>
    </div>

    <div class="mb-3">
        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="<?= old('waktu_mulai') ?>" required>
    </div>

    <div class="mb-3">
        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" value="<?= old('waktu_selesai') ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="<?= base_url('admin/jadwal') ?>" class="btn btn-secondary">Kembali</a>
</form>

<?= $this->endSection() ?>
