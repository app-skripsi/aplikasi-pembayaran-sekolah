<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\SppModel;
use Midtrans\Snap;
use Config\Midtrans;

class SppController extends BaseController
{
    protected $spp, $kelas, $siswa;

    public function __construct()
    {
        helper(['form']);
        $this->spp = new SppModel();
        $this->kelas = new KelasModel();
        $this->siswa = new SiswaModel();
		// Inisialisasi konfigurasi Midtrans
		$midtransConfig = new \Config\Midtrans();

		// Set konfigurasi Midtrans
		\Midtrans\Config::$serverKey = $midtransConfig::$serverKey;
		\Midtrans\Config::$isProduction = $midtransConfig::$isProduction;
		\Midtrans\Config::$isSanitized = $midtransConfig::$isSanitized;
		\Midtrans\Config::$is3ds = $midtransConfig::$is3ds;
    }

    public function index(): string
    {
        $data['spp'] = $this->spp->select('spp.*, kelas.kelas, siswa.nama')
            ->join('kelas', 'kelas.id = spp.kelas_id')
            ->join('siswa', 'siswa.id = spp.siswa_id')
            ->findAll();
        return view('spp/index', $data);
    }

    public function create(): string
    {
        $kelas = $this->kelas->findAll();
        $siswa = $this->siswa->findAll();
        $data = [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'statusPembayaranEnum' => $this->spp->getStatusPembayaranEnum(),
            'metodePembayaranEnum' => $this->spp->getMetodePembayaranEnum()
        ];
        return view('spp/create', $data);
    }

    public function store()
    {
        $dataBuktiPembayaran = $this->request->getFile('bukti_pembayaran');
        if (!$dataBuktiPembayaran) {
            session()->setFlashdata('error', 'File upload tidak ditemukan');
            return redirect()->back()->withInput();
        }
        if ($dataBuktiPembayaran->isValid() && !$dataBuktiPembayaran->hasMoved()) {
            $fileBuktiPembayaran = $dataBuktiPembayaran->getName();
            $dataBuktiPembayaran->move('uploads/bukti_pembayaran/', $fileBuktiPembayaran);
        } else {
            session()->setFlashdata('error', 'File upload gagal');
            return redirect()->back()->withInput();
        }

        $validation = \Config\Services::validation();
        $data = [
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            'bulan_pembayaran' => $this->request->getPost('bulan_pembayaran'),
            'nominal_pembayaran' => $this->request->getPost('nominal_pembayaran'),
            'tanggal_pembayaran' => $this->request->getPost('tanggal_pembayaran'),
            'status_pembayaran' => $this->request->getPost('status_pembayaran'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'catatan' => $this->request->getPost('catatan'),
            'nis' => $this->request->getPost('nis'),
            'siswa_id' => $this->request->getPost('siswa_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
            'bukti_pembayaran' => $fileBuktiPembayaran,
        ];
        if ($validation->run($data, 'spp') == false) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('spp/create'));
        } else {
            $simpan = $this->spp->insertData($data);
            if ($simpan) {
                session()->setFlashdata('success', 'Tambah Data Berhasil');
                return redirect()->to(base_url('spp'));
            }
        }
    }

	public function searchSppByNamaSiswa()
	{
		$namaSiswa = $this->request->getPost('nama');
	
		$spp = $this->spp->select('spp.*, siswa.nama AS nama, kelas.kelas')
			->join('siswa', 'spp.siswa_id = siswa.id')
			->join('kelas', 'siswa.kelas_id = kelas.id')
			->where('siswa.nama', $namaSiswa) // Menggunakan 'where' untuk pencarian yang tepat
			->findAll();
	
		if ($spp) {
			$data['spp'] = $spp;
			return view('spp/informasi-pembayaran', $data);
		} else {
			$data['error'] = 'Data pembayaran SPP untuk siswa dengan nama "' . $namaSiswa . '" tidak ditemukan.';
			return redirect()->to(base_url('/bayar-spp'))->with('error', $data['error']);
		}
	}

    public function edit($id)
    {
        $kelas = $this->kelas->findAll();
        $siswa = $this->siswa->findAll();
        $data['kelas'] = ['' => 'Pilih Kelas'] + array_column($kelas, 'kelas', 'id');
        $data['siswa'] = ['' => 'Pilih Siswa'] + array_column($siswa, 'nama', 'id');
        $data['spp'] = $this->spp->find($id);
        $data['statusPembayaranEnum'] = $this->spp->getStatusPembayaranEnum();
        $data['metodePembayaranEnum'] = $this->spp->getMetodePembayaranEnum();
        return view('spp/edit', $data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $validation = \Config\Services::validation();

        $data = [
            'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
            'bulan_pembayaran' => $this->request->getPost('bulan_pembayaran'),
            'nominal_pembayaran' => $this->request->getPost('nominal_pembayaran'),
            'tanggal_pembayaran' => $this->request->getPost('tanggal_pembayaran'),
            'status_pembayaran' => $this->request->getPost('status_pembayaran'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'catatan' => $this->request->getPost('catatan'),
            'nis' => $this->request->getPost('nis'),
            'siswa_id' => $this->request->getPost('siswa_id'),
            'kelas_id' => $this->request->getPost('kelas_id'),
        ];
        if ($validation->run($data, 'spp') == false) {
            session()->setFlashdata('inputs', $this->request->getPost());
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to(base_url('spp/edit/' . $id));
        } else {
            $ubah = $this->spp->updateData($data, $id);
            if ($ubah) {
                session()->setFlashdata('success', 'Update Data Berhasil');
                session()->setFlashdata('alert', 'success');
                return redirect()->to(base_url('spp'));
            }
        }
    }

    public function delete($id)
    {
        $hapus = $this->spp->deleteData($id);
        if ($hapus) {
            session()->setFlashdata('warning', 'Delete Data Berhasil');
            return redirect()->to(base_url('spp'));
        }
    }

	public function createMidtransTransaction($nis)
	{
		$spp = $this->spp
			->select('spp.*, siswa.nama') // Select SPP fields and student name
			->join('siswa', 'siswa.nis = spp.nis') // Join with siswa table on nis
			->where('spp.nis', $nis)
			->first();
	
		// Create transaction parameters
		$transactionDetails = [
			'order_id' => 'order-' . uniqid(),
			'gross_amount' => $spp['nominal_pembayaran'],
		];
	
		$itemDetails = [
			[
				'id' => 'spp-' . $spp['id'],
				'price' => $spp['nominal_pembayaran'],
				'quantity' => 1,
				'name' => 'Pembayaran SPP ' . $spp['nama'],
			],
		];
	
		$customerDetails = [
			'first_name' => $spp['nama'],
			'email' => 'email@example.com',
			'phone' => '081234567890',
		];
	
		$transaction = [
			'transaction_details' => $transactionDetails,
			'item_details' => $itemDetails,
			'customer_details' => $customerDetails,
		];
	
		try {
			$snapToken = Snap::getSnapToken($transaction);
			// Store snapToken in session
			session()->setFlashdata('snapToken', $snapToken);
			return redirect()->to(base_url('/halaman-pembayaran'));
		} catch (Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}	
	
}
