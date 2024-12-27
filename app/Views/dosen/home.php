<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>

<form method="GET" action="<?= base_url('dosen/home') ?>" class="row g-3 mb-3">
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
                <th>No</th>
                <th>Hari</th>
                <th>Pekan</th>
                <th>Waktu</th>
                <th>Absen</th>
                <th>Waktu Absen</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($jadwal) > 0): ?>
                <?php foreach ($jadwal as $index => $row): ?>
                    <tr class="text-center">
                        <!-- Nomor -->
                        <td><?= $index + 1 ?></td>
                        <!-- Hari -->
                        <td><?= esc($row['hari']) ?></td>
                        <!-- Pekan -->
                        <td><?= esc($row['pekan']) ?></td>
                        <!-- Waktu -->
                        <td><?= esc($row['waktu_mulai']) ?> - <?= esc($row['waktu_selesai']) ?></td>
                        <!-- Absen -->
                        <td>
                            <?php if (isset($row['absen']) && $row['absen'] === 1): ?>
                                <span class="badge bg-success">Hadir</span>
                                <form action="<?= base_url('dosen/absen-keluar') ?>" method="post" class="mt-2">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_jadwal" value="<?= $row['id_jadwal'] ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Absen Keluar</button>
                                </form>
                            <?php else: ?>
                                <form action="<?= base_url('dosen/konfirmasi-kehadiran') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_jadwal" value="<?= $row['id_jadwal'] ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Konfirmasi Kehadiran</button>
                                </form>
                            <?php endif; ?>
                        </td>
                        <!-- Waktu Absen -->
                        <td>
                            <?php if (isset($row['absen']) && $row['absen'] === 1): ?>
                                <?= esc($row['waktu_absen'] ?? '-') ?>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <!-- Aksi -->
                        <td>
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $row['id_jadwal'] ?>">
                                Detail
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalBatalkan<?= $row['id_jadwal'] ?>">
                                Hapus
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div class="modal fade" id="modalDetail<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="modalDetailLabel<?= $row['id_jadwal'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalDetailLabel<?= $row['id_jadwal'] ?>">Detail Jadwal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Mata Kuliah:</strong> <?= esc($row['mata_kuliah'] ?? '-') ?></p>
                                    <p><strong>Kelas:</strong> <?= esc($row['kelas'] ?? '-') ?></p>
                                    <p><strong>Ruangan:</strong> <?= esc($row['nama_ruangan'] ?? '-') ?></p>
                                    <p><strong>Hari:</strong> <?= esc($row['hari']) ?></p>
                                    <p><strong>Pekan:</strong> <?= esc($row['pekan']) ?></p>
                                    <p><strong>Waktu:</strong> <?= esc($row['waktu_mulai']) ?> - <?= esc($row['waktu_selesai']) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Pembatalan -->
                    <div class="modal fade" id="modalBatalkan<?= $row['id_jadwal'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $row['id_jadwal'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel<?= $row['id_jadwal'] ?>">Konfirmasi Penghapusan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus pesanan untuk jadwal ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form method="POST" action="<?= base_url('dosen/home/batalkan') ?>" class="d-inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_jadwal" value="<?= esc($row['id_jadwal']) ?>">
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada jadwal ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>