<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use CodeIgniter\HTTP\ResponseInterface;

class GuruController extends BaseController
{
    protected $guru;
    public function __construct()
	{
		helper(['form']);
		$this->guru = new GuruModel();
	}

    public function index(): string
    {
        $guru['guru'] = $this->guru->findAll();
		return view('guru/index', $guru);
    }

	public function create(): string
	{
		return view('guru/create');
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'nama'        			=> $this->request->getPost('nama'),
			'nip'         			=> $this->request->getPost('nip'),
			'nomor_telepon'         => $this->request->getPost('nomor_telepon'),
			'alamat'         		=> $this->request->getPost('alamat'),
			'email'         	    => $this->request->getPost('email'),
		);

		if ($validation->run($data, 'guru') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('guru/create'));
		} else {
			$simpan = $this->guru->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('guru'));
			}
		}
	}


	public function edit($id)
	{
        $data['guru'] = $this->guru->getData($id);
		return view('guru/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
			'nama'        			=> $this->request->getPost('nama'),
			'nip'         			=> $this->request->getPost('nip'),
			'nomor_telepon'         => $this->request->getPost('nomor_telepon'),
			'alamat'         		=> $this->request->getPost('alamat'),
			'email'         	    => $this->request->getPost('email'),
		);

		if ($validation->run($data, 'guru') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('guru/edit/' . $id));
		} else {
			$ubah = $this->guru->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('guru'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('guru/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->guru->deleteData($id);
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
		return redirect()->to(base_url('guru'));
	}

}
