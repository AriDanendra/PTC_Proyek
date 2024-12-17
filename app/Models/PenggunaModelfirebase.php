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
}
