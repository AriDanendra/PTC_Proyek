<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;
use App\Models\RuanganModel;
use App\Models\JadwalModel;

class Home extends BaseController
{
    private $penggunaModel;
    private $ruanganModel;
    private $jadwalModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
        $this->ruanganModel = new RuanganModel();
        $this->jadwalModel = new JadwalModel();
    }

    public function index()
    {
        // Dapatkan total pengguna, ruangan, dan jadwal
        $totalPengguna = count($this->penggunaModel->findAll());
        $totalRuangan = count($this->ruanganModel->findAll());
        $totalJadwal = count($this->jadwalModel->findAll());

        $data = [
            'title' => 'Home',
            'totalPengguna' => $totalPengguna,
            'totalRuangan' => $totalRuangan,
            'totalJadwal' => $totalJadwal,
        ];

        return view('admin/home', $data);
    }
}
