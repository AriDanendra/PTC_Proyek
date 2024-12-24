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

        $ruangan = $this->getAllRuangan(); // Ambil semua data ruangan

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

            // Gabungkan dengan data ruangan
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
            $result[$key] = $value; // Simpan dalam format dengan kunci `id_ruangan`
        }

        return $result;
    }


    public function getJadwalByHariAndPekan($hari = null, $pekan = null)
    {
        $jadwal = $this->findAll();
        $ruangan = $this->getAllRuangan();

        // Gabungkan data `jadwal` dengan `ruangan`
        foreach ($jadwal as &$item) {
            $item['nama_ruangan'] = $ruangan[$item['id_ruangan']]['nama_ruangan'] ?? 'N/A';
        }

        // Filter berdasarkan hari dan pekan
        return array_filter($jadwal, function ($item) use ($hari, $pekan) {
            $matchHari = !$hari || $item['hari'] === $hari;
            $matchPekan = !$pekan || $item['pekan'] === $pekan;
            return $matchHari && $matchPekan;
        });
    }
    public function getJadwalByDosen($nama_dosen)
    {
        $jadwal = $this->findAll();

        // Filter jadwal berdasarkan nama_dosen dan tambahkan filter status 'Dipesan'
        return array_filter($jadwal, function ($item) use ($nama_dosen) {
            return isset($item['nama_dosen']) &&
                $item['nama_dosen'] === $nama_dosen &&
                $item['status'] === 'Dipesan';
        });
    }
    public function getStatusKehadiranById($id_dosen = null)
    {
        // If no ID is provided, return null or a default value
        if ($id_dosen === null) {
            return null;
        }

        // Attempt to fetch the dosen data
        $reference = $this->database->getReference('dosen/' . $id_dosen);
        $dosen = $reference->getValue();

        // Check if the dosen exists
        if ($dosen === null) {
            return null; // Return null if no dosen found with this ID
        }

        // Always return 'Konfirmasi Kehadiran' to allow confirmation
        return 'Konfirmasi Kehadiran';
    }
    // Optional: Method to get all dosen IDs
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
            return false; // Tidak dapat mengkonfirmasi kehadiran jika tidak ada nilai absen
        }

        // Cek apakah absen dosen adalah 0
        if ($dosen['absen'] === 0) {
            return false; // Tidak dapat mengubah absen jadwal jika absen dosen adalah 0
        }

        // Ubah absen di jadwal menjadi 1
        $jadwalReference->update(['absen' => 1]);

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

        // Cek status absen dosen
        if ($dosen && isset($dosen['absen']) && $dosen['absen'] === 1) {
            return false; // Tidak dapat absen keluar jika status absen dosen masih 1
        }

        // Update jadwal dengan menghapus data pesanan dan mengatur status menjadi Tersedia
        $updates = [
            'status' => 'Tersedia',
            'mata_kuliah' => null,
            'kelas' => null,
            'nama_dosen' => null,
            'absen' => 0
        ];

        $jadwalReference->update($updates);

        return true;
    }
}
