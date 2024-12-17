<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;

class Dosen extends BaseController
{
    private $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dosen',
            'dosen' => $this->dosenModel->findAll()
        ];

        return view('admin/dosen', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Dosen',
        ];

        return view('admin/tambah_dosen', $data);
    }

    public function simpan()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required',
            'matakuliah' => 'required',
            'absen' => 'required|integer',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'matakuliah' => $this->request->getPost('matakuliah'),
            'absen' => $this->request->getPost('absen'),
        ];

        $this->dosenModel->insert($data);

        return redirect()->to(base_url('admin/dosen'))->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dosen = $this->dosenModel->find($id);

        if (!$dosen) {
            return redirect()->to(base_url('admin/dosen'))->with('error', 'Data dosen tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Dosen',
            'id_dosen' => $id, // Kirim ID dosen
            'dosen' => $dosen, // Kirim data dosen
        ];

        return view('admin/edit_dosen', $data);
    }


    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required',
            'matakuliah' => 'required',
            'absen' => 'required|integer',
        ]);

        if (!$this->validate($validation->getRules())) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'nama' => $this->request->getPost('nama'),
            'matakuliah' => $this->request->getPost('matakuliah'),
            'absen' => (int) $this->request->getPost('absen'), // Cast ke integer
        ];

        $this->dosenModel->update($id, $data);

        return redirect()->to(base_url('admin/dosen'))->with('success', 'Data dosen berhasil diperbarui.');
    }


    public function hapus($id)
    {
        $dosen = $this->dosenModel->find($id);

        if (!$dosen) {
            return redirect()->to(base_url('admin/dosen'))->with('error', 'Data dosen tidak ditemukan.');
        }

        $this->dosenModel->delete($id);

        return redirect()->to(base_url('admin/dosen'))->with('success', 'Data dosen berhasil dihapus.');
    }
}
