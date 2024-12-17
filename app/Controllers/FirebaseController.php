<?php

namespace App\Controllers;

use Config\Firebase;

class FirebaseController extends BaseController
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function testConnection()
    {
        try {
            // Data untuk diuji
            $testData = [
                'test' => 'Firebase connection successful!',
                'timestamp' => date('Y-m-d H:i:s')
            ];

            // Menulis data ke Firebase
            $reference = $this->database->getReference('test_connection');
            $reference->set($testData);

            // Membaca data kembali
            $result = $reference->getValue();

            // Tampilkan hasil
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Connected to Firebase!',
                'data_written' => $testData,
                'data_read' => $result
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
