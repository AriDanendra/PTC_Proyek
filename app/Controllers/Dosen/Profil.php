<?php

namespace App\Controllers\Dosen;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Profil extends BaseController
{
    private $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
    }

    public function index()
    {
        $session = session();
        $nama = $session->get('nama'); // Ambil nama dari session

        $pengguna = $this->penggunaModel->getPenggunaByName($nama);

        $data = [
            'title' => 'Profil Saya',
            'pengguna' => $pengguna
        ];

        return view('dosen/profil', $data);
    }

    public function edit()
    {
        $session = session();
        $nama = $session->get('nama'); // Ambil nama dari session
        $pengguna = $this->penggunaModel->getPenggunaByName($nama);

        if (!$pengguna) {
            return redirect()->to('dosen/profil')->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Ambil data fingerprint (atau dosen)
        $dosen = $this->penggunaModel->getFingerprints(); // Sesuaikan method ini

        $data = [
            'title' => 'Edit Profil',
            'pengguna' => $pengguna,
            'dosen' => $dosen // Tambahkan ke data yang dilewatkan ke view
        ];

        return view('dosen/edit_profil', $data);
    }

    public function update()
    {
        $session = session();
        $nama = $session->get('nama');
        $pengguna = $this->penggunaModel->getPenggunaByName($nama);

        if (!$pengguna) {
            return redirect()->to('dosen/profil')->with('error', 'Data pengguna tidak ditemukan.');
        }

        $id = $pengguna['id_pengguna'];
        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'fingerprint_id' => $this->request->getPost('fingerprint_id'),
            'role' => $this->request->getPost('role')
        ];

        $this->penggunaModel->update($id, $data);

        return redirect()->to('dosen/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
