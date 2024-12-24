<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>

<div class="mb-3">

</div>

<form method="GET" action="<?= base_url('dosen/jadwal') ?>" class="row g-3 mb-3">
    <div class="col-md-3">
        <label for="hari" class="form-label">Pilih Hari:</label>
        <select name="hari" id="hari" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Hari --</option>
            <option value="Senin" <?= ($hari == 'Senin') ? 'selected' : '' ?>>Senin</option>
            <option value="Selasa" <?= ($hari == 'Selasa') ? 'selected' : '' ?>>Selasa</option>
            <option value="Rabu" <?= ($hari == 'Rabu') ? 'selected' : '' ?>>Rabu</option>
            <option value="Kamis" <?= ($hari == 'Kamis') ? 'selected' : '' ?>>Kamis</option>
            <option value="Jumat" <?= ($hari == 'Jumat') ? 'selected' : '' ?>>Jumat</option>
        </select>
    </div>

    <div class="col-md-3">
        <label for="pekan" class="form-label">Pilih Pekan:</label>
        <select name="pekan" id="pekan" class="form-select" onchange="this.form.submit()">
            <option value="">-- Semua Pekan --</option>
            <option value="1" <?= ($pekan == '1') ? 'selected' : '' ?>>Pekan 1</option>
            <option value="2" <?= ($pekan == '2') ? 'selected' : '' ?>>Pekan 2</option>
            <option value="3" <?= ($pekan == '3') ? 'selected' : '' ?>>Pekan 3</option>
            <option value="4" <?= ($pekan == '4') ? 'selected' : '' ?>>Pekan 4</option>
        </select>
    </div>
</form>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php elseif (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Ruangan</th>
                <th>Waktu Mulai</th>
                <th>Waktu Selesai</th>
                <th>Status</th>
                <th>Dosen</th>
                <th>Mata Kuliah</th>
                <th>Kelas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($jadwal) > 0): ?>
                <?php foreach ($jadwal as $row): ?>
                    <tr class="text-center">
                        <!-- Ruangan -->
                        <td><?= esc($row['nama_ruangan'] ?? '-') ?></td>
                        <!-- Waktu Mulai -->
                        <td><?= esc($row['waktu_mulai'] ?? '-') ?></td>
                        <!-- Waktu Selesai -->
                        <td><?= esc($row['waktu_selesai'] ?? '-') ?></td>
                        <!-- Status -->
                        <td>
                            <?php if ($row['status'] == 'Tersedia'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Dipakai</span>
                            <?php endif; ?>
                        </td>
                        <!-- Dosen -->
                        <td><?= esc($row['nama_dosen'] ?? '-') ?></td>
                        <!-- Mata Kuliah -->
                        <td><?= esc($row['mata_kuliah'] ?? '-') ?></td>
                        <!-- Kelas -->
                        <td><?= esc($row['kelas'] ?? '-') ?></td>
                        <!-- Aksi -->
                        <td>
                            <?php if ($row['status'] == 'Tersedia'): ?>
                                <a href="<?= base_url('dosen/jadwal/pesan/' . $row['id_jadwal']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-cart-plus"></i> Pesan
                                </a>
                            <?php else: ?>
                                <span class="text-danger">Tidak Tersedia</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada jadwal tersedia.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?>