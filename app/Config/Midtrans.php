<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Midtrans extends BaseConfig
{
    public static  $serverKey = 'SB-Mid-server-30dKRBZjEbfnaSnrQ7vD8xaY'; // Ganti dengan server key Anda
    public static  $isProduction = false; // Ubah ke true jika ingin menggunakan lingkungan produksi
    public static  $isSanitized = true; // Tetap true untuk menyanitasi parameter permintaan
    public static  $is3ds = true; // Tetap true untuk mengaktifkan 3DS

    public function __construct()
    {
        parent::__construct();

  // Set your Midtrans configuration here
  \Midtrans\Config::$serverKey = self::$serverKey;
  \Midtrans\Config::$isProduction = self::$isProduction;
  \Midtrans\Config::$isSanitized = self::$isSanitized;
  \Midtrans\Config::$is3ds = self::$is3ds;
    }
}
