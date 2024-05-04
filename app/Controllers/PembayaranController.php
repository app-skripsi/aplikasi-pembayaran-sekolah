<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembayaranModel;

class PembayaranController extends BaseController
{
    protected $pembayaran;
    public function __construct()
	{
		helper(['form']);
		$this->pembayaran = new PembayaranModel();
	}

    public function index(): string
    {
        $pembayaran['pembayaran'] = $this->pembayaran->findAll();
		return view('pembayaran/index', $pembayaran);
    }
	public function create(): string
	{
		return view('pembayaran/create');
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'pembayaran'        			=> $this->request->getPost('pembayaran'),
			'description'         	=> $this->request->getPost('description'),
		);

		if ($validation->run($data, 'pembayaran') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pembayaran/create'));
		} else {
			$simpan = $this->pembayaran->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('pembayaran'));
			}
		}
	}


	public function edit($id)
	{
        $data['pembayaran'] = $this->pembayaran->getData($id);
		return view('pembayaran/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
			'pembayaran'        			=> $this->request->getPost('pembayaran'),
			'description'         	=> $this->request->getPost('description'),
		);

		if ($validation->run($data, 'pembayaran') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pembayaran/edit/' . $id));
		} else {
			$ubah = $this->pembayaran->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('pembayaran'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('pembayaran/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->pembayaran->deleteData($id);
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
		return redirect()->to(base_url('pembayaran'));
	}
}
