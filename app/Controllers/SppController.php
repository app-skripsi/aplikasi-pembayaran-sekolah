<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\SppModel;

class SppController extends BaseController
{
    protected $spp, $kelas, $siswa;

    public function __construct()
	{
		helper(['form']);
		$this->spp 		= new SppModel();
		$this->kelas 	= new KelasModel();
		$this->siswa 	= new SiswaModel();
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
			session()->setFlashdata('error', 'File upload not found');
			return redirect()->back()->withInput();
		}
		if ($dataBuktiPembayaran->isValid() && !$dataBuktiPembayaran->hasMoved()) {
			$fileBuktiPembayaran = $dataBuktiPembayaran->getName();
			$dataBuktiPembayaran->move('uploads/bukti_pembayaran/', $fileBuktiPembayaran);
		} else {
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
            'siswa_id'                  => $this->request->getPost('siswa_id'),
            'kelas_id'                  => $this->request->getPost('kelas_id'),
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
        $nis = $this->request->getGet('nis');
        if (!$nis) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'NIS harus disediakan dalam permintaan GET.'
            ])->setStatusCode(400);
        }
        $siswa = $this->spp->getDataByNIS($nis);
        if (!$siswa) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Siswa dengan NIS tersebut tidak ditemukan.'
            ])->setStatusCode(404);
        }
        return $this->response->setJSON([
            'status' => true,
            'data' => $siswa
        ])->setStatusCode(200);
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
            'siswa_id'                  => $this->request->getPost('siswa_id'),
            'kelas_id'                  => $this->request->getPost('kelas_id'),
		);
			if ($validation->run($data, 'spp') == FALSE) {
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
            session()->setFlashdata('warning', 'Delete Data  Berhasil');
			return redirect()->to(base_url('spp'));
		}	
	}
}
