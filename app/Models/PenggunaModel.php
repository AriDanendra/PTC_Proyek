<?php

namespace App\Models;

use Config\Firebase;

class PenggunaModel
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function findAll()
    {
        // Mendapatkan data semua pengguna dari Firebase
        $reference = $this->database->getReference('pengguna');
        $firebaseData = $reference->getValue() ?: []; // Jika kosong, kembalikan array kosong

        // Tambahkan kunci sebagai bagian dari data
        $result = [];
        foreach ($firebaseData as $key => $value) {
            $value['id_pengguna'] = $key; // Tambahkan ID Firebase ke data
            $result[] = $value;
        }

        return $result;
    }


    public function find($id)
    {
        // Mendapatkan data pengguna berdasarkan ID
        $reference = $this->database->getReference('pengguna/' . $id);
        return $reference->getValue();
    }

    public function insert($data)
    {
        // Membuat ID unik menggunakan Firebase
        $newKey = $this->database->getReference('pengguna')->push()->getKey();
        $this->database->getReference('pengguna/' . $newKey)->set($data);
        return $newKey;
    }

    public function update($id, $data)
    {
        // Mengupdate data pengguna
        $this->database->getReference('pengguna/' . $id)->update($data);
    }

    public function delete($id)
    {
        // Menghapus data pengguna
        $this->database->getReference('pengguna/' . $id)->remove();
    }

    public function getFingerprints()
    {
        // Mendapatkan data semua fingerprints dari Firebase
        $reference = $this->database->getReference('dosen');
        $firebaseData = $reference->getValue() ?: []; // Jika kosong, kembalikan array kosong

        $result = [];
        foreach ($firebaseData as $key => $value) {
            if ($value) { // Pastikan data valid
                $result[] = [
                    'id' => $value['id'],
                    'nama' => $value['nama']
                ];
            }
        }

        return $result;
    }
    public function getDosenIdByName($nama_dosen)
    {
        $reference = $this->database->getReference('dosen');
        $dosenData = $reference->getValue() ?: [];

        foreach ($dosenData as $id => $dosen) {
            if (isset($dosen['nama']) && $dosen['nama'] === $nama_dosen) {
                return $id;
            }
        }

        return null;
    }
    public function getPenggunaByName($nama)
    {
        $reference = $this->database->getReference('pengguna');
        $penggunaData = $reference->getValue() ?: [];

        foreach ($penggunaData as $key => $pengguna) {
            if ($pengguna['nama'] === $nama) {
                $pengguna['id_pengguna'] = $key; // Tambahkan kunci Firebase sebagai ID
                return $pengguna;
            }
        }

        return null;
    }
}
