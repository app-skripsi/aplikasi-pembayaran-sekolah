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
        return view('spp/index');
    }

	public function create(): string
	{
		return view('spp/create');
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'tahun_ajaran'              => $this->request->getPost('tahun_ajaran'),
            'bulan_pembayaran'          => $this->request->getPost('bulan_pembayaran'),
			'nominal_pembayaran'        => $this->request->getPost('nominal_pembayaran'),
			'tanggal_pembayaran'        => $this->request->getPost('tanggal_pembayaran'),
			'status_pembayaran'         => $this->request->getPost('status_pembayaran'),
			'metode_pembayaran'         => $this->request->getPost('metode_pembayaran'),
            'catatan'                   => $this->request->getPost('catatan'),
            'siswa_id'                  => $this->request->getPost('siswa_id'),
            'kelas_id'                  => $this->request->getPost('kelas_id'),

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


	public function edit($id)
	{
        $data['spp'] = $this->spp->getData($id);
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
