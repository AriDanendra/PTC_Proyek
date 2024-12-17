<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\RuanganModel;

class Jadwal extends BaseController
{
    private $jadwalModel;
    private $ruanganModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {

        $hari = $this->request->getGet('hari') ?: 'Senin';
        $pekan = $this->request->getGet('pekan') ?: '1';

        $data = [
            'title' => 'Jadwal Dosen',
            'jadwal' => $this->jadwalModel->getJadwalByHariAndPekan($hari, $pekan),
            'hari' => $hari,
            'pekan' => $pekan
        ];

        return view('dosen/jadwal', $data);
    }

    public function pesan($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to(base_url('dosen/jadwal'))->with('error', 'Jadwal tidak ditemukan.');
        }

        if ($jadwal['status'] !== 'Tersedia') {
            return redirect()->to(base_url('dosen/jadwal'))->with('error', 'Jadwal sudah dipesan.');
        }

        $data = [
            'status' => 'Dipesan',
            'nama_dosen' => session()->get('nama_dosen'), // Pastikan data nama dosen ada di session
            'absen' => 0 // Tambahkan nilai absen dengan default 0
        ];

        $this->jadwalModel->update($id, $data);

        return redirect()->to(base_url('dosen/jadwal'))->with('success', 'Jadwal berhasil dipesan.');
    }

    public function formPesan($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to(base_url('dosen/jadwal'))->with('error', 'Jadwal tidak ditemukan.');
        }

        $data = [
            'title' => 'Form Pesan Jadwal',
            'jadwal' => $jadwal,
            'id_jadwal' => $id,
            'nama_dosen' => session()->get('nama_dosen') // Ambil nama dosen dari session
        ];

        return view('dosen/form_pesan', $data);
    }

    public function prosesPesan()
    {
        $id_jadwal = $this->request->getPost('id_jadwal');
        $mata_kuliah = $this->request->getPost('mata_kuliah');
        $kelas = $this->request->getPost('kelas');
        $nama_dosen = session()->get('nama_dosen'); // Ambil nama dosen dari session

        if (!$id_jadwal || !$mata_kuliah || !$kelas) {
            return redirect()->back()->with('error', 'Semua kolom wajib diisi.');
        }

        $jadwal = $this->jadwalModel->find($id_jadwal);

        if (!$jadwal) {
            return redirect()->to(base_url('dosen/jadwal'))->with('error', 'Jadwal tidak ditemukan.');
        }

        if ($jadwal['status'] !== 'Tersedia') {
            return redirect()->to(base_url('dosen/jadwal'))->with('error', 'Jadwal sudah dipesan.');
        }

        // Data yang akan di-update
        $data = [
            'status' => 'Dipesan',
            'mata_kuliah' => $mata_kuliah,
            'kelas' => $kelas,
            'nama_dosen' => $nama_dosen, // Simpan nama dosen ke jadwal
            'absen' => 0 // Tambahkan nilai absen dengan default 0
        ];

        $this->jadwalModel->update($id_jadwal, $data);

        return redirect()->to(base_url('dosen/jadwal'))->with('success', 'Jadwal berhasil dipesan.');
    }
}
