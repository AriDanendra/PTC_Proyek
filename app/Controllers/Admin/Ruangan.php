<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RuanganModel;

class Ruangan extends BaseController
{
    private $ruanganModel;

    public function __construct()
    {
        $this->ruanganModel = new RuanganModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Ruangan',
            'ruangan' => $this->ruanganModel->findAll()
        ];

        return view('admin/Ruangan', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Ruangan',
        ];

        return view('admin/tambah_ruangan', $data);
    }

    public function simpan()
    {
        $validation = \Config\Services::validation();

        // Validasi data input
        $validation->setRules([
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kapasitas' => $this->request->getPost('kapasitas'),
        ];

        // Simpan data ke Firebase
        $this->ruanganModel->insert($data);

        return redirect()->to(base_url('admin/ruangan'))->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $ruangan = $this->ruanganModel->find($id);

        if (!$ruangan) {
            return redirect()->to(base_url('admin/ruangan'))->with('error', 'Data ruangan tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Ruangan',
            'ruangan' => $ruangan,
            'id_ruangan' => $id
        ];

        return view('admin/edit_ruangan', $data);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();

        // Validasi data input
        $validation->setRules([
            'nama_ruangan' => 'required',
            'kapasitas' => 'required|numeric',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kapasitas' => $this->request->getPost('kapasitas'),
        ];

        // Update data ke Firebase
        $this->ruanganModel->update($id, $data);

        return redirect()->to(base_url('admin/ruangan'))->with('success', 'Data ruangan berhasil diperbarui.');
    }

    public function hapus($id)
    {
        $ruangan = $this->ruanganModel->find($id);

        if (!$ruangan) {
            return redirect()->to(base_url('admin/ruangan'))->with('error', 'Data ruangan tidak ditemukan.');
        }

        // Hapus data dari Firebase
        $this->ruanganModel->delete($id);

        return redirect()->to(base_url('admin/ruangan'))->with('success', 'Data ruangan berhasil dihapus.');
    }
}
