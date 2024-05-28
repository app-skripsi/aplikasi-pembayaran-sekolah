<?php

namespace App\Controllers;

use App\Models\PengajianModel;
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
        $pengajianModel = new PengajianModel();
        $sppModel = new SppModel();
        $counts = [
            'penggajian' => $pengajianModel->countAllPenggajian(),
            'spp' => $sppModel->countAllSpp(),
        ];

        return view('index', $counts);
    }

    public function login(): string {
        return view ('login');
    }
}
