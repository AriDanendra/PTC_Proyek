<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenggunaModel;

class Pengguna extends BaseController
{
    private $penggunaModel;

    public function __construct()
    {
        $this->penggunaModel = new PenggunaModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pengguna',
            'pengguna' => $this->penggunaModel->findAll()
        ];

        return view('admin/Pengguna', $data);
    }
    public function tambah()
    {
        $fingerprints = $this->penggunaModel->getFingerprints();

        $data = [
            'title' => 'Tambah Pengguna',
            'dosen' => $fingerprints,
        ];

        return view('admin/tambah_pengguna', $data);
    }


    public function simpan()
    {
        $validation = \Config\Services::validation();

        // Validasi data input
        $validation->setRules([
            'nama' => 'required',
            'username' => 'required|is_unique[pengguna.username]',
            'password' => 'required|min_length[6]',
            'role' => 'required',
            'fingerprint_id' => 'required|numeric'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'password' => $this->request->getPost('password'),
            'role' => $this->request->getPost('role'),
            'fingerprint_id' => $this->request->getPost('fingerprint_id'),
        ];

        // Simpan data ke Firebase
        $this->penggunaModel->insert($data);

        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Data pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengguna = $this->penggunaModel->find($id);

        if (!$pengguna) {
            return redirect()->to(base_url('admin/pengguna'))->with('error', 'Data pengguna tidak ditemukan.');
        }

        $fingerprints = $this->penggunaModel->getFingerprints();

        $data = [
            'title' => 'Edit Pengguna',
            'pengguna' => $pengguna,
            'dosen' => $fingerprints,
            'id_pengguna' => $id,
        ];

        return view('admin/edit_pengguna', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        // Validasi data input
        $validation->setRules([
            'nama' => 'required',
            'username' => 'required',
            'password' => 'permit_empty|min_length[6]', // Tidak wajib, tapi harus valid jika diisi
            'role' => 'required',
            'fingerprint_id' => 'required|numeric'
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'username' => $this->request->getPost('username'),
            'role' => $this->request->getPost('role'),
            'fingerprint_id' => $this->request->getPost('fingerprint_id'),
        ];

        // Update password jika diisi
        $password = $this->request->getPost('password');
        if ($password) {
            $data['password'] = $password; // Bisa gunakan hashing jika perlu
        }

        // Update data ke Firebase
        $this->penggunaModel->update($id, $data);

        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $pengguna = $this->penggunaModel->find($id);

        if (!$pengguna) {
            return redirect()->to(base_url('admin/pengguna'))->with('error', 'Data pengguna tidak ditemukan.');
        }

        // Hapus data dari Firebase
        $this->penggunaModel->delete($id);

        return redirect()->to(base_url('admin/pengguna'))->with('success', 'Data pengguna berhasil dihapus.');
    }
}
