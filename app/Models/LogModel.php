<?php

namespace App\Models;

use Config\Firebase;

class LogModel
{
    private $database;

    public function __construct()
    {
        $firebase = new Firebase();
        $this->database = $firebase->getDatabase();
    }

    public function getRecentActivities($limit = 5)
    {
        $reference = $this->database->getReference('logs/activities');
        $firebaseData = $reference->orderByChild('timestamp')->limitToLast($limit)->getValue();

        if (!$firebaseData) {
            // Jika tidak ada data
            return [];
        }

        // Urutkan dari terbaru ke terlama
        $result = [];
        foreach (array_reverse($firebaseData) as $key => $value) {
            $value['id_activity'] = $key;
            $result[] = $value;
        }

        return $result;
    }

    public function getNotifications($limit = 5)
    {
        $reference = $this->database->getReference('logs/notifications');
        $firebaseData = $reference->orderByChild('timestamp')->limitToLast($limit)->getValue();

        if (!$firebaseData) {
            // Jika tidak ada data
            return [];
        }

        // Urutkan dari terbaru ke terlama
        $result = [];
        foreach (array_reverse($firebaseData) as $key => $value) {
            $value['id_notification'] = $key;
            $result[] = $value;
        }

        return $result;
    }
}
