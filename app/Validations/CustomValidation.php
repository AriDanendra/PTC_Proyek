<?php

namespace App\Validations;

class CustomValidation
{
    public static function afterTime(string $value, string $field, array $data, string &$error = null): bool
    {
        // Pastikan field yang dibandingkan ada di $data
        if (!isset($data[$field])) {
            $error = "Field '{$field}' tidak ditemukan.";
            return false;
        }

        // Konversi waktu menjadi format detik untuk perbandingan
        $timeStart = strtotime($data[$field]);
        $timeEnd = strtotime($value);

        if ($timeStart === false || $timeEnd === false) {
            $error = "Format waktu tidak valid.";
            return false;
        }

        // Pastikan waktu selesai lebih besar dari waktu mulai
        if ($timeEnd <= $timeStart) {
            $error = "Waktu selesai harus setelah waktu mulai.";
            return false;
        }

        return true;
    }
}
