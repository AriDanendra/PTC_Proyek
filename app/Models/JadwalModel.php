<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Firebase;

class JadwalModel
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function findAll()
    {
        $reference = $this->database->getReference('jadwal');
        $firebaseData = $reference->getValue() ?: [];

        $ruangan = $this->getAllRuangan();

        $result = [];
        foreach ($firebaseData as $key => $value) {
            $value['id_jadwal'] = $key;
            $value['nama_ruangan'] = $ruangan[$value['id_ruangan']]['nama_ruangan'] ?? 'N/A';
            $result[] = $value;
        }

        return $result;
    }

    public function find($id)
    {
        $reference = $this->database->getReference('jadwal/' . $id);
        $jadwal = $reference->getValue();

        if ($jadwal) {
            $jadwal['id_jadwal'] = $id;
            $ruangan = $this->getAllRuangan();
            $jadwal['nama_ruangan'] = $ruangan[$jadwal['id_ruangan']]['nama_ruangan'] ?? 'N/A';
        }

        return $jadwal;
    }

    public function insert($data)
    {
        $newKey = $this->database->getReference('jadwal')->push()->getKey();
        $this->database->getReference('jadwal/' . $newKey)->set($data);
        return $newKey;
    }

    public function update($id, $data)
    {
        $this->database->getReference('jadwal/' . $id)->update($data);
    }

    public function delete($id)
    {
        $this->database->getReference('jadwal/' . $id)->remove();
    }

    public function getAllRuangan()
    {
        $reference = $this->database->getReference('ruangan');
        $firebaseData = $reference->getValue() ?: [];

        $result = [];
        foreach ($firebaseData as $key => $value) {
            $value['id_ruangan'] = $key;
            $result[$key] = $value;
        }

        return $result;
    }

    public function getJadwalByHariAndPekan($hari = null, $pekan = null)
    {
        $jadwal = $this->findAll();
        $ruangan = $this->getAllRuangan();

        foreach ($jadwal as &$item) {
            $item['nama_ruangan'] = $ruangan[$item['id_ruangan']]['nama_ruangan'] ?? 'N/A';
        }

        return array_filter($jadwal, function ($item) use ($hari, $pekan) {
            $matchHari = !$hari || $item['hari'] === $hari;
            $matchPekan = !$pekan || $item['pekan'] === $pekan;
            return $matchHari && $matchPekan;
        });
    }

    public function getJadwalByDosen($nama_dosen)
    {
        $jadwal = $this->findAll();

        // Get pengguna data to find dosen's fingerprint_id
        $penggunaReference = $this->database->getReference('pengguna');
        $penggunaData = $penggunaReference->getValue() ?: [];

        // Find dosen's fingerprint_id
        $dosenId = null;
        foreach ($penggunaData as $pengguna) {
            if ($pengguna['nama'] === $nama_dosen) {
                $dosenId = $pengguna['fingerprint_id'];
                break;
            }
        }

        $filteredJadwal = [];
        foreach ($jadwal as $item) {
            if (
                isset($item['nama_dosen']) &&
                $item['nama_dosen'] === $nama_dosen &&
                $item['status'] === 'Dipesan'
            ) {
                // We don't need to add absen data from dosen anymore
                // since we're using waktu_absen from jadwal
                $filteredJadwal[] = $item;
            }
        }

        return $filteredJadwal;
    }

    public function getStatusKehadiranById($id_dosen = null)
    {
        if ($id_dosen === null) {
            return null;
        }

        $reference = $this->database->getReference('dosen/' . $id_dosen);
        $dosen = $reference->getValue();

        if ($dosen === null) {
            return null;
        }

        return 'Konfirmasi Kehadiran';
    }

    public function getAllDosenIds()
    {
        $reference = $this->database->getReference('dosen');
        $dosenData = $reference->getValue() ?: [];

        return array_keys($dosenData);
    }

    public function konfirmasiKehadiran($id_jadwal, $id_dosen)
    {
        // Ambil data dosen
        $referenceDosen = $this->database->getReference('dosen/' . $id_dosen);
        $dosen = $referenceDosen->getValue();

        // Ambil data jadwal
        $jadwalReference = $this->database->getReference('jadwal/' . $id_jadwal);
        $jadwal = $jadwalReference->getValue();

        // Pastikan data dosen dan jadwal ditemukan
        if ($dosen === null || $jadwal === null) {
            return false;
        }

        // Cek apakah kolom absen tidak ada atau bernilai null
        if (!isset($dosen['absen']) || $dosen['absen'] === null) {
            return false;
        }

        // Cek status absen dosen (sesuai struktur baru)
        if (!isset($dosen['absen']['status']) || $dosen['absen']['status'] === 0) {
            return false;
        }

        // Update jadwal dengan absen dan waktu
        $updates = [
            'absen' => 1,
            'waktu_absen' => $dosen['absen']['waktu'] // Tambahkan waktu absen dari data dosen
        ];

        $jadwalReference->update($updates);

        return true;
    }

    public function absenKeluar($id_jadwal, $nama_dosen)
    {
        // Ambil data jadwal
        $jadwalReference = $this->database->getReference('jadwal/' . $id_jadwal);
        $jadwal = $jadwalReference->getValue();

        // Ambil data dosen berdasarkan nama
        $penggunaReference = $this->database->getReference('pengguna');
        $penggunaData = $penggunaReference->getValue();

        // Cari dosen yang sesuai dengan nama
        $dosen = null;
        $dosenId = null;
        foreach ($penggunaData as $key => $pengguna) {
            if ($pengguna['nama'] === $nama_dosen) {
                $dosenId = $pengguna['fingerprint_id'];
                $dosenReference = $this->database->getReference('dosen/' . $dosenId);
                $dosen = $dosenReference->getValue();
                break;
            }
        }

        // Pastikan jadwal ditemukan dan sesuai dengan nama dosen
        if ($jadwal === null || !isset($jadwal['nama_dosen']) || $jadwal['nama_dosen'] !== $nama_dosen) {
            return false;
        }

        // Cek apakah jadwal sudah dikonfirmasi (absen = 1)
        if (!isset($jadwal['absen']) || $jadwal['absen'] !== 1) {
            return false;
        }

        // Cek status absen dosen (sesuai struktur baru)
        if ($dosen && isset($dosen['absen']['status']) && $dosen['absen']['status'] === 1) {
            return false;
        }

        // Update jadwal dengan menghapus data pesanan dan mengatur status menjadi Tersedia
        $updates = [
            'status' => 'Tersedia',
            'mata_kuliah' => null,
            'kelas' => null,
            'nama_dosen' => null,
            'absen' => 0,
            'waktu_absen' => null  // Hapus waktu absen saat absen keluar
        ];

        $jadwalReference->update($updates);

        return true;
    }
}
