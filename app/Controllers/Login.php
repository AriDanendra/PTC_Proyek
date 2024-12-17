<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Firebase;

class Login extends BaseController
{
    public function index()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('login', $data);
    }

    public function login_action()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            $data['validation'] = $this->validator;
            return view('login', $data);
        } else {
            $session = session();
            $firebase = new \Config\Firebase(); // Panggil kelas konfigurasi Firebase
            $db = $firebase->getDatabase();

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            // Ambil data pengguna dari Firebase
            $usersRef = $db->getReference('pengguna');
            $users = $usersRef->getValue();

            $userFound = null;
            foreach ($users as $id => $user) {
                if ($user['username'] === $username) {
                    $userFound = $user;
                    break;
                }
            }

            if ($userFound) {
                $password_db = $userFound['password'];

                // Cek kecocokan password langsung
                if ($password === $password_db) {
                    $session_data = [
                        'username' => $userFound['username'],
                        'logged_in' => TRUE,
                        'role_id' => $userFound['role']
                    ];

                    // Simpan nama dosen ke session jika role adalah "Dosen"
                    if ($userFound['role'] === "Dosen") {
                        $session_data['nama_dosen'] = $userFound['nama'];
                    }

                    $session->set($session_data);

                    switch ($userFound['role']) {
                        case "Admin":
                            return redirect()->to('admin/home');
                        case "Dosen":
                            return redirect()->to('dosen/home');
                        default:
                            $session->setFlashdata('pesan', 'Akun Anda belum terdaftar');
                            return redirect()->to('/');
                    }
                } else {
                    $session->setFlashdata('pesan', 'Password salah, silakan coba lagi');
                    return redirect()->to('/');
                }
            } else {
                $session->setFlashdata('pesan', 'Username salah, silakan coba lagi');
                return redirect()->to('/');
            }
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
