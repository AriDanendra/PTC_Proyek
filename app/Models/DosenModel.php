<?php

namespace App\Models;

use Config\Firebase;

class DosenModel
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function findAll()
    {
        $reference = $this->database->getReference('dosen');
        $firebaseData = $reference->getValue() ?: [];

        $result = [];
        foreach ($firebaseData as $key => $value) {
            $value['id_dosen'] = $key;
            $result[] = $value;
        }

        return $result;
    }

    public function find($id)
    {
        $reference = $this->database->getReference('dosen/' . $id);
        return $reference->getValue();
    }

    public function insert($data)
    {
        $newKey = $this->database->getReference('dosen')->push()->getKey();
        $this->database->getReference('dosen/' . $newKey)->set($data);
        return $newKey;
    }

    public function update($id, $data)
    {
        $this->database->getReference('dosen/' . $id)->update($data);

        // Tambahkan logika sinkronisasi jadwal
        if (isset($data['absen'])) {
            $this->syncStatusKehadiran($id, $data['absen']);
        }
    }

    public function delete($id)
    {
        $this->database->getReference('dosen/' . $id)->remove();
    }

    private function syncStatusKehadiran($idDosen, $absen)
    {
        $jadwalModel = new JadwalModel();
        $dosen = $this->find($idDosen);

        if ($dosen && isset($dosen['nama'])) {
            $namaDosen = $dosen['nama'];
            $jadwalDipesan = $jadwalModel->getJadwalByDosen($namaDosen);

            foreach ($jadwalDipesan as $idJadwal => $jadwal) {
                $statusKehadiran = $absen === 1 ? 'Hadir' : 'Konfirmasi Kehadiran';
                $jadwalModel->update($idJadwal, ['status_kehadiran' => $statusKehadiran]);
            }
        }
    }

    public function getFingerprints()
    {
        $reference = $this->database->getReference('dosen');
        $firebaseData = $reference->getValue() ?: [];

        $result = [];
        foreach ($firebaseData as $key => $value) {
            if ($value) {
                $result[] = [
                    'id' => $key,
                    'nama' => $value['nama']
                ];
            }
        }

        return $result;
    }
}
