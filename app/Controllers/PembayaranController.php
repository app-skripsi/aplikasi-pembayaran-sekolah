<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PembayaranController extends BaseController
{
    public function index()
    {
        return view('pembayaran/index');
    }
}
