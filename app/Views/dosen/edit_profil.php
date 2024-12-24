<?= $this->extend('dosen/layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Edit Profil</h4>
        </div>
        <div class="card-body">
            <form action="<?= base_url('dosen/profil/update') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= old('nama', $pengguna['nama']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= old('username', $pengguna['username']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="fingerprint_id" class="form-label">Fingerprint ID</label>
                    <select class="form-select" id="fingerprint_id" name="fingerprint_id" required>
                        <option value="" disabled>Pilih Fingerprint</option>
                        <?php foreach ($dosen as $fp): ?>
                            <option value="<?= esc($fp['id']) ?>" <?= $pengguna['fingerprint_id'] == $fp['id'] ? 'selected' : '' ?>>
                                <?= esc($fp['nama']) ?> (ID: <?= esc($fp['id']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-select" readonly>
                        <option value="Dosen" <?= $pengguna['role'] == 'Dosen' || !$pengguna['role'] ? 'selected' : '' ?>>Dosen</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="<?= base_url('dosen/profil') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
