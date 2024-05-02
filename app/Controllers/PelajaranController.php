<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PelajaranModel;

class PelajaranController extends BaseController
{
    protected $pelajaran;
    public function __construct()
	{
		helper(['form']);
		$this->pelajaran = new PelajaranModel();
	}

    public function index(): string
    {
        $pelajaran['pelajaran'] = $this->pelajaran->findAll();
		return view('pelajaran/index', $pelajaran);
    }

	public function create(): string
	{
		return view('pelajaran/create');
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'nama_pelajaran'       => $this->request->getPost('nama_pelajaran'),
		);

		if ($validation->run($data, 'pelajaran') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pelajaran/create'));
		} else {
			$simpan = $this->pelajaran->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('pelajaran'));
			}
		}
	}


	public function edit($id)
	{
        $data['pelajaran'] = $this->pelajaran->getData($id);
		return view('pelajaran/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
			'nama_pelajaran'       => $this->request->getPost('nama_pelajaran'),
		);

		if ($validation->run($data, 'pelajaran') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pelajaran/edit/' . $id));
		} else {
			$ubah = $this->pelajaran->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('pelajaran'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('pelajaran/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->pelajaran->deleteData($id);
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
		return redirect()->to(base_url('pelajaran'));
	}
}
