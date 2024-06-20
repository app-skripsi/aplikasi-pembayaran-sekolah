<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;

class KelasController extends BaseController
{
	protected $kelas;
	public function __construct()
	{
		helper(['form']);
		$this->kelas = new KelasModel();
	}

	public function index(): string
	{
		$kelas['kelas'] = $this->kelas->findAll();
		return view('kelas/index', $kelas);
	}
	public function create(): string
	{
		return view('kelas/create');
	}

	public function store()
	{
		$validation = \Config\Services::validation();
		$data = array(
			'kelas' => $this->request->getPost('kelas'),
			'description' => $this->request->getPost('description'),
		);

		if ($validation->run($data, 'kelas') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('kelas/create'));
		} else {
			$simpan = $this->kelas->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('kelas'));
			}
		}
	}

	public function edit($id)
	{
		$data['kelas'] = $this->kelas->getData($id);
		return view('kelas/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');
		$validation = \Config\Services::validation();
		$data = array(
			'kelas' => $this->request->getPost('kelas'),
			'description' => $this->request->getPost('description'),
		);
		if ($validation->run($data, 'kelas') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('kelas/edit/' . $id));
		} else {
			$ubah = $this->kelas->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('kelas'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('kelas/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->kelas->deleteData($id);
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
		return redirect()->to(base_url('kelas'));
	}
}
