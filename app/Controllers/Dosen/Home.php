<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\PenggunaModel;

class Home extends BaseController
{
    private $jadwalModel;
    private $penggunaModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->penggunaModel = new PenggunaModel();
    }

    public function index()
    {
        $session = session();
        $nama_dosen = $session->get('nama_dosen');

        if (!$nama_dosen) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil filter dari request dengan nilai default
        $hari = $this->request->getGet('hari') ?: 'Senin';
        $pekan = $this->request->getGet('pekan') ?: '1';


        // Ambil id dosen dari GET request atau dari daftar tersedia
        $id_dosen = $this->request->getGet('id_dosen');

        // Jika tidak ada ID yang diberikan, coba dapatkan ID dari nama dosen
        if (!$id_dosen) {
            $id_dosen = $this->penggunaModel->getDosenIdByName($nama_dosen);
        }

        // Fallback jika masih tidak mendapatkan ID
        if (!$id_dosen) {
            $dosenIds = $this->jadwalModel->getAllDosenIds();
            $id_dosen = !empty($dosenIds) ? reset($dosenIds) : null;
        }

        // Ambil jadwal dosen berdasarkan nama_dosen
        $jadwal = $this->jadwalModel->getJadwalByDosen($nama_dosen);

        // Filter tambahan berdasarkan hari dan pekan
        $filteredJadwal = array_filter($jadwal, function ($item) use ($hari, $pekan) {
            $matchHari = !$hari || $item['hari'] === $hari;
            $matchPekan = !$pekan || $item['pekan'] === $pekan;
            return $matchHari && $matchPekan;
        });

        // Sort jadwal berdasarkan hari dan waktu mulai
        usort($filteredJadwal, function ($a, $b) {
            return [$a['hari'], $a['waktu_mulai']] <=> [$b['hari'], $b['waktu_mulai']];
        });

        // Ambil status kehadiran dosen
        $statusKehadiran = $this->jadwalModel->getStatusKehadiranById($id_dosen);

        $data = [
            'title' => 'Jadwal Saya',
            'jadwal' => $filteredJadwal,
            'hari' => $hari,
            'pekan' => $pekan,
            'status_kehadiran' => $statusKehadiran,
            'id_dosen' => $id_dosen,
        ];

        return view('dosen/home', $data);
    }

    public function batalkan()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');

        if (!$id_jadwal) {
            return redirect()->back()->with('error', 'ID jadwal tidak valid.');
        }

        $jadwal = $this->jadwalModel->find($id_jadwal);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        if ($jadwal['status'] !== 'Dipesan') {
            return redirect()->back()->with('error', 'Jadwal belum dipesan.');
        }

        // Update status jadwal menjadi Tersedia dan hapus nilai absen
        $this->jadwalModel->update($id_jadwal, [
            'status' => 'Tersedia',
            'mata_kuliah' => null,
            'kelas' => null,
            'nama_dosen' => null,
            'absen' => null, // Tambahkan penghapusan nilai absen
        ]);

        return redirect()->back()->with('success', 'Pesanan jadwal berhasil dibatalkan.');
    }

    public function konfirmasiKehadiran()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');
        $session = session();
        $nama_dosen = $session->get('nama_dosen');

        // Dapatkan ID dosen berdasarkan nama dari pengguna
        $pengguna = $this->penggunaModel->getPenggunaByName($nama_dosen);

        if (!$pengguna || !isset($pengguna['fingerprint_id'])) {
            return redirect()->back()->with('error', 'Dosen tidak ditemukan.');
        }

        $id_dosen = $pengguna['fingerprint_id'];

        $jadwal = $this->jadwalModel->find($id_jadwal);

        if (!$jadwal) {
            return redirect()->back()->with('error', 'Jadwal tidak ditemukan.');
        }

        // Pastikan hanya jadwal yang dipesan oleh dosen bersangkutan yang bisa dikonfirmasi
        if ($jadwal['nama_dosen'] !== $nama_dosen) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengkonfirmasi jadwal ini.');
        }

        // Konfirmasi kehadiran
        $result = $this->jadwalModel->konfirmasiKehadiran($id_jadwal, $id_dosen);

        if ($result) {
            return redirect()->back()->with('success', 'Kehadiran berhasil dikonfirmasi.');
        } else {
            return redirect()->back()->with('error', 'Kehadiran gagal dikonfirmasi. Pastikan Sudah Scan sidik jari.');
        }
    }
    public function absenKeluar()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');
        $session = session();
        $nama_dosen = $session->get('nama_dosen');

        // Pastikan nama dosen ada di session
        if (!$nama_dosen) {
            return redirect()->back()->with('error', 'Sesi login habis. Silakan login kembali.');
        }

        // Absen keluar
        $result = $this->jadwalModel->absenKeluar($id_jadwal, $nama_dosen);

        if ($result) {
            return redirect()->back()->with('success', 'Absen keluar berhasil.');
        } else {
            return redirect()->back()->with('error', 'Absen keluar gagal. Pastikan Anda sudah scan sidik jari.');
        }
    }
}
