<?php

namespace App\Models;

use CodeIgniter\Model;

class Jadwal2Model extends Model
{
    protected $table = 'jadwal'; // Nama tabel
    protected $primaryKey = 'id_jadwal';
    protected $allowedFields = ['id_ruangan', 'id_pengguna', 'pekan', 'hari', 'waktu_mulai', 'waktu_selesai', 'status', 'mata_kuliah', 'kelas']; // Field yang diizinkan

    
    public function getScheduleByUserId($userId)
    {
        return $this->where('id_pengguna', $userId)
            ->orderBy('hari', 'ASC')
            ->orderBy('waktu_mulai', 'ASC')
            ->findAll();
    }

    public function getJadwalByHariAndPekan($hari = null, $pekan = null)
    {
        $this->select('jadwal.*, ruangan.nama_ruangan, pengguna.nama as nama_dosen')
            ->join('ruangan', 'jadwal.id_ruangan = ruangan.id_ruangan')
            ->join('pengguna', 'jadwal.id_pengguna = pengguna.id_pengguna', 'left'); // Menambahkan join dengan tabel pengguna

        if ($hari) {
            $this->where('jadwal.hari', $hari);
        }

        if ($pekan) {
            $this->where('jadwal.pekan', $pekan);
        }

        return $this->findAll();
    }
}
