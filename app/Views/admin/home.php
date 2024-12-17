<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="row">
    <!-- Total User -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon purple">
                <i class="lni lni-user"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Total User</h6>
                <h3 class="text-bold mb-10"><?= $totalPengguna; ?></h3>
            </div>
        </div>
    </div>
    <!-- Total Ruangan -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon success">
                <i class="lni lni-home"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Total Ruangan</h6>
                <h3 class="text-bold mb-10"><?= $totalRuangan; ?></h3>
            </div>
        </div>
    </div>
    <!-- Total Jadwal -->
    <div class="col-xl-3 col-lg-4 col-sm-6">
        <div class="icon-card mb-30">
            <div class="icon warning">
                <i class="lni lni-calendar"></i>
            </div>
            <div class="content">
                <h6 class="mb-10">Total Jadwal</h6>
                <h3 class="text-bold mb-10"><?= $totalJadwal; ?></h3>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
