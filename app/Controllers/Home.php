<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\KelasModel;
use App\Models\PengajianModel;
use App\Models\SiswaModel;
use App\Models\SppModel;
use App\Models\UserModel;

class Home extends BaseController
{

    protected $login;
    public function __construct()
    {
        helper('form');
        $this->login = new UserModel();
    }


    public function error(): string {
		return view('error');
    }
    public function finish(): string {
        return view('success');
    }
    public function unfinish(): string {
        return view('unfinish');
    }

    public function fe(): string
    {
        return view('fe');
    }

    public function paymentSpp(): string
    {
        return view('bayar-spp');
    }

    public function pembayaran(): string
    {
        return view('informasi-data-pembayaran');
    }

    public function viewDashboard(): string
    {
        $pengajianModel = new PengajianModel();
        $sppModel       = new SppModel();
        $guruModel      = new GuruModel();
        $kelasModel     = new KelasModel();
        $siswaModel     = new SiswaModel();
        $counts         = [
        'penggajian'    => $pengajianModel->countAllPenggajian(),
        'spp'           => $sppModel->countAllSpp(),
        'guru'          => $guruModel->countAllGuru(),
        'kelas'         => $kelasModel->countAllKelas(),
        'siswa'         => $siswaModel->countAllSiswa(),
        ];
        return view('index', $counts);
    }

    public function login(): string
    {
        return view('login');
    }


    public function cek_login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $cek = $this->login->cek_login($username, $password);


        if ($cek !== null && ($cek['username'] == $username) && ($cek['password'] == $password)) {
            // pengecekan jika username dan password benar
            session()->set('nama_user', $cek['nama_user']);
            session()->set('username', $cek['username']);
            session()->set('level', $cek['level']);
            return redirect()->to(base_url('/dashboard'));
        } else {
            // jika pengecekan salah
            session()->setFlashData('gagal', 'Username atau password tidak benar');
            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        session()->remove('nama_user');
        session()->remove('username');
        session()->remove('level');
        session()->setFlashData('sukses', 'Anda Berhasil Logout');
        return redirect()->to(base_url('/'));
    }
}
