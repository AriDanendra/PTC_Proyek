<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JadwalModel;
use App\Models\RuanganModel;
use App\Models\PenggunaModel;

class Jadwal extends BaseController
{
    private $jadwalModel;
    private $ruanganModel;
    private $penggunaModel;

    public function __construct()
    {
        $this->jadwalModel = new JadwalModel();
        $this->ruanganModel = new RuanganModel();
        $this->penggunaModel = new PenggunaModel();
    }

    public function index()
    {
        $hari = $this->request->getGet('hari') ?? 'Senin';
        $pekan = $this->request->getGet('pekan') ?? '1';

        $data = [
            'title' => 'Data Jadwal',
            'jadwal' => $this->jadwalModel->getJadwalByHariAndPekan($hari, $pekan),
            'hari' => $hari,
            'pekan' => $pekan
        ];

        return view('admin/jadwal', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Jadwal',
            'ruangan' => $this->ruanganModel->findAll(),
            'pengguna' => $this->penggunaModel->findAll()
        ];

        return view('admin/tambah_jadwal', $data);
    }

    public function simpan()
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'id_ruangan'    => 'required',
            'hari'          => 'required',
            'pekan'         => 'required|integer',
            'waktu_mulai'   => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/]',
            'waktu_selesai' => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $waktuMulai = strtotime($this->request->getPost('waktu_mulai'));
        $waktuSelesai = strtotime($this->request->getPost('waktu_selesai'));

        if ($waktuSelesai <= $waktuMulai) {
            return redirect()->back()->withInput()->with('validation', [
                'waktu_selesai' => 'Waktu selesai harus setelah waktu mulai.',
            ]);
        }

        $data = [
            'id_ruangan'    => $this->request->getPost('id_ruangan'),
            'hari'          => $this->request->getPost('hari'),
            'pekan'         => $this->request->getPost('pekan'),
            'waktu_mulai'   => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
            'status'        => 'Tersedia',
        ];

        $this->jadwalModel->insert($data);

        return redirect()->to(base_url('admin/jadwal'))->with('success', 'Jadwal berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to(base_url('admin/jadwal'))->with('error', 'Jadwal tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Jadwal',
            'jadwal' => $jadwal,
            'ruangan' => $this->ruanganModel->findAll(),
        ];

        return view('admin/edit_jadwal', $data);
    }


    public function update($id)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'id_ruangan' => 'required',
            'hari' => 'required',
            'pekan' => 'required|integer',
            'waktu_mulai' => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/]',
            'waktu_selesai' => 'required|regex_match[/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('validation', $validation->getErrors());
        }

        $data = [
            'id_ruangan' => $this->request->getPost('id_ruangan'),
            'hari' => $this->request->getPost('hari'),
            'pekan' => $this->request->getPost('pekan'),
            'waktu_mulai' => $this->request->getPost('waktu_mulai'),
            'waktu_selesai' => $this->request->getPost('waktu_selesai'),
        ];

        $this->jadwalModel->update($id, $data);

        return redirect()->to(base_url('admin/jadwal'))->with('success', 'Jadwal berhasil diperbarui.');
    }


    public function hapus($id)
    {
        $jadwal = $this->jadwalModel->find($id);

        if (!$jadwal) {
            return redirect()->to(base_url('admin/jadwal'))->with('error', 'Jadwal tidak ditemukan.');
        }

        $this->jadwalModel->delete($id);

        return redirect()->to(base_url('admin/jadwal'))->with('success', 'Jadwal berhasil dihapus.');
    }
}
