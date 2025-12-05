<?php

namespace App\Helpers;

class FormatHelper
{
    public static function normalizePhone($number)
    {
        // hilangkan semua non-digit
        $number = preg_replace('/\D/', '', $number);

        // jika mulai dari 0 → ubah ke 62
        if (strpos($number, '0') === 0) {
            $number = '62' . substr($number, 1);
        }

        return $number;
    }

    public static function displayPhone($number)
    {
        $n = preg_replace('/\D/', '', $number);

        if (strpos($n, '0') === 0) {
            $n = '62' . substr($n, 1);
        }

        return '+' . substr($n, 0, 2) . ' ' . substr($n, 2);
    }
}
