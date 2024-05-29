<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SppModel;

class SppController extends BaseController
{
    protected $spp;
    public function __construct()
	{
		helper(['form']);
		$this->spp = new SppModel();
	}

    public function index(): string
    {
		$spp['spp'] = $this->spp->findAll();
		return view('spp/index', $spp);
    }

	public function create(): string
	{
		$sppModel = new SppModel();
        $data['statusPembayaranEnum'] = $sppModel->getStatusPembayaranEnum();
		$data['metodePembayaranEnum'] = $sppModel->getMetodePembayaranEnum();
		return view('spp/create', $data);
	}

    public function store()
	{
		// Ambil file yang diupload
		$dataBuktiPembayaran = $this->request->getFile('bukti_pembayaran');

		// Periksa apakah file ditemukan
		if (!$dataBuktiPembayaran) {
			// Tangani error jika file tidak ditemukan
			session()->setFlashdata('error', 'File upload not found');
			return redirect()->back()->withInput();
		}

		// Periksa apakah file valid dan belum dipindahkan
		if ($dataBuktiPembayaran->isValid() && !$dataBuktiPembayaran->hasMoved()) {
			// Dapatkan nama file
			$fileBuktiPembayaran = $dataBuktiPembayaran->getName();
			// Pindahkan file ke direktori tujuan
			$dataBuktiPembayaran->move('uploads/bukti_pembayaran/', $fileBuktiPembayaran);
		} else {
			// Tangani error jika file upload gagal
			session()->setFlashdata('error', 'File upload failed');
			return redirect()->back()->withInput();
		}

		$validation =  \Config\Services::validation();
		$data = array(
			'tahun_ajaran'              => $this->request->getPost('tahun_ajaran'),
            'bulan_pembayaran'          => $this->request->getPost('bulan_pembayaran'),
			'nominal_pembayaran'        => $this->request->getPost('nominal_pembayaran'),
			'tanggal_pembayaran'        => $this->request->getPost('tanggal_pembayaran'),
			'status_pembayaran'         => $this->request->getPost('status_pembayaran'),
			'metode_pembayaran'         => $this->request->getPost('metode_pembayaran'),
            'catatan'                   => $this->request->getPost('catatan'),
			'nis'                   	=> $this->request->getPost('nis'),
            'siswa'                  	=> $this->request->getPost('siswa'),
            'kelas'                  	=> $this->request->getPost('kelas'),
            'bukti_pembayaran'   		=> $fileBuktiPembayaran,
		);
		if ($validation->run($data, 'spp') == FALSE) {
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


	public function getByNIS()
    {
        // Ambil NIS dari permintaan GET
        $nis = $this->request->getGet('nis');

        // Validasi NIS
        if (!$nis) {
            // Jika NIS tidak tersedia, kembalikan respon JSON dengan pesan kesalahan
            return $this->response->setJSON([
                'status' => false,
                'message' => 'NIS harus disediakan dalam permintaan GET.'
            ])->setStatusCode(400);
        }

        // Dapatkan data siswa berdasarkan NIS
        $siswa = $this->spp->getDataByNIS($nis);

        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            // Jika tidak ditemukan, kembalikan respon JSON dengan pesan
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Siswa dengan NIS tersebut tidak ditemukan.'
            ])->setStatusCode(404);
        }

        // Jika ditemukan, kembalikan data siswa dalam respon JSON
        return $this->response->setJSON([
            'status' => true,
            'data' => $siswa
        ])->setStatusCode(200);
    }


	public function edit($id)
    {
        // Membuat instance dari model SppModel
        $sppModel = new SppModel();

        // Mendapatkan data spp berdasarkan ID
        $data['spp'] = $sppModel->getData($id);

        // Mendapatkan enum dari kolom status_pembayaran
        $data['statusPembayaranEnum'] = $sppModel->getStatusPembayaranEnum();
		$data['metodePembayaranEnum'] = $sppModel->getMetodePembayaranEnum();

        // Mengirimkan data ke view 'spp/edit'
        return view('spp/edit', $data);
    }

	public function update()
	{
		$id = $this->request->getPost('id');
		// Ambil file yang diupload
		$dataBuktiPembayaran = $this->request->getFile('bukti_pembayaran');

		// Periksa apakah file ditemukan
		if (!$dataBuktiPembayaran) {
			// Tangani error jika file tidak ditemukan
			session()->setFlashdata('error', 'File upload not found');
			return redirect()->back()->withInput();
		}

		// Periksa apakah file valid dan belum dipindahkan
		if ($dataBuktiPembayaran->isValid() && !$dataBuktiPembayaran->hasMoved()) {
			// Dapatkan nama file
			$fileBuktiPembayaran = $dataBuktiPembayaran->getName();
			// Pindahkan file ke direktori tujuan
			$dataBuktiPembayaran->move('uploads/bukti_pembayaran/', $fileBuktiPembayaran);
		} else {
			// Tangani error jika file upload gagal
			session()->setFlashdata('error', 'File upload failed');
			return redirect()->back()->withInput();
		}
		$validation =  \Config\Services::validation();

		$data = array(
            'tahun_ajaran'              => $this->request->getPost('tahun_ajaran'),
            'bulan_pembayaran'          => $this->request->getPost('bulan_pembayaran'),
			'nominal_pembayaran'        => $this->request->getPost('nominal_pembayaran'),
			'tanggal_pembayaran'        => $this->request->getPost('tanggal_pembayaran'),
			'status_pembayaran'         => $this->request->getPost('status_pembayaran'),
			'metode_pembayaran'         => $this->request->getPost('metode_pembayaran'),
            'catatan'                   => $this->request->getPost('catatan'),
            'nis'                   	=> $this->request->getPost('nis'),
            'siswa'                  	=> $this->request->getPost('siswa'),
            'kelas'                  	=> $this->request->getPost('kelas'),
		);
			if ($validation->run($data, 'spp') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('spp/edit/' . $id));
		} else {
			$ubah = $this->spp->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('spp'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('spp/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->spp->deleteData($id);
		if ($hapus) {
			session()->setFlashdata('success', 'Delete Data Berhasil');
			// Sweet Alert success
			session()->setFlashdata('alert', 'success');
			session()->setFlashdata('delete_alert', 'success');
		} else {
			session()->setFlashdata('error', 'Gagal menghapus data');
			// Sweet Alert error
			session()->setFlashdata('alert', 'error');
			session()->setFlashdata('delete_alert', 'error');
		}
		return redirect()->to(base_url('spp'));
	}
}
