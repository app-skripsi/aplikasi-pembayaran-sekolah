<?php

namespace App\Controllers;

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
        return view('index');
    }
}
