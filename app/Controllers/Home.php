<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\PelajaranModel;
use App\Models\PengajianModel;
use App\Models\SiswaModel;
use App\Models\SppModel;

class Home extends BaseController
{
    public function fe(): string
    {
        return view('fe');
    }

    public function paymentSpp(): string
    {
        return view('bayar-spp');
    }

    public function pembayaran(): string {
        return view('informasi-data-pembayaran');
    }

    public function viewDashboard(): string {
        $guruModel = new GuruModel();
        $kelasModel = new KelasModel();
        $pelajaranModel = new PelajaranModel();
        $siswaModel = new SiswaModel();
        $pengajianModel = new PengajianModel();
        $sppModel = new SppModel();
        // Menghitung jumlah baris (count) dari setiap tabel
        $counts = [
            'guru' => $guruModel->countAllGuru(),
            'kelas' => $kelasModel->countAllKelas(),
            'pelajaran' => $pelajaranModel->countAllPelajaran(),
            'siswa' => $siswaModel->countAllSiswa(),
            'pengajian' => $pengajianModel->countAllPengajian(),
            'spp' => $sppModel->countAllSpp(),
        ];

        return view('index', $counts);
    }

    public function login(): string {
        return view ('login');
    }
}
