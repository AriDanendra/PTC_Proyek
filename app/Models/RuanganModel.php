<?php

namespace App\Models;

use Config\Firebase;

class RuanganModel
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function findAll()
    {
        // Mendapatkan data semua ruangan dari Firebase
        $reference = $this->database->getReference('ruangan');
        $firebaseData = $reference->getValue() ?: []; // Jika kosong, kembalikan array kosong

        // Tambahkan kunci sebagai bagian dari data
        $result = [];
        foreach ($firebaseData as $key => $value) {
            $value['id_ruangan'] = $key; // Tambahkan ID Firebase ke data
            $result[] = $value;
        }

        return $result;
    }

    public function find($id)
    {
        // Mendapatkan data ruangan berdasarkan ID
        $reference = $this->database->getReference('ruangan/' . $id);
        return $reference->getValue();
    }

    public function insert($data)
    {
        // Membuat ID unik menggunakan Firebase
        $newKey = $this->database->getReference('ruangan')->push()->getKey();
        $this->database->getReference('ruangan/' . $newKey)->set($data);
        return $newKey;
    }

    public function update($id, $data)
    {
        // Mengupdate data ruangan
        $this->database->getReference('ruangan/' . $id)->update($data);
    }

    public function delete($id)
    {
        // Menghapus data ruangan
        $this->database->getReference('ruangan/' . $id)->remove();
    }
}
