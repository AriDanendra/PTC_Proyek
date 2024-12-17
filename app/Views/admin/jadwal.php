<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="mb-3">
    <a href="<?= base_url('admin/jadwal/tambah') ?>" class="btn btn-primary">Tambah Jadwal</a>
</div>

<form method="GET" action="<?= base_url('admin/jadwal') ?>" class="row g-3 mb-3">
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

<div class="table-responsive mb-4">
    <table class="table table-striped table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Hari</th>
                <th>Pekan</th>
                <th>Waktu</th>
                <th>Mata Kuliah</th>
                <th>Kelas</th>
                <th>Dosen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($jadwal) > 0): ?>
                <?php foreach ($jadwal as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($row['nama_ruangan'] ?? 'N/A') ?></td>
                        <td><?= esc($row['hari']) ?></td>
                        <td><?= esc($row['pekan']) ?></td>
                        <td><?= esc($row['waktu_mulai']) ?> - <?= esc($row['waktu_selesai']) ?></td>
                        <td><?= esc($row['mata_kuliah'] ?? '-') ?></td>
                        <td><?= esc($row['kelas'] ?? '-') ?></td>
                        <td><?= esc($row['nama_dosen'] ?? '-') ?></td>
                        <td>
                            <a href="<?= base_url('admin/jadwal/edit/' . $row['id_jadwal']) ?>" class="btn btn-warning btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row['id_jadwal'] ?>">Hapus</button>
                        </td>
                    </tr>

                    <!-- Modal Hapus -->
                    <div class="modal fade" id="modalHapus<?= $row['id_jadwal'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus jadwal ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <a href="<?= base_url('admin/jadwal/hapus/' . $row['id_jadwal']) ?>" class="btn btn-danger">Hapus</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data jadwal yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?= $this->endSection() ?>