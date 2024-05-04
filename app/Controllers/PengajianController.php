<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengajianModel;
use CodeIgniter\HTTP\ResponseInterface;

class PengajianController extends BaseController
{
    protected $pengajian;
    public function __construct()
	{
		helper(['form']);
		$this->pengajian = new PengajianModel();
	}

    public function index(): string
    {
		$pengajian['pengajian'] = $this->pengajian->findAll();
		return view('pengajian/index', $pengajian);
    }

	public function create(): string
	{
		return view('pengajian/create');
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'guru_id'               => $this->request->getPost('guru_id'),
            'bulan'                 => $this->request->getPost('bulan'),
			'tahun'                 => $this->request->getPost('tahun'),
			'tanggal'               => $this->request->getPost('tanggal'),
			'gaji'                  => $this->request->getPost('gaji'),
			'status'                => $this->request->getPost('status'),
            'keterangan'            => $this->request->getPost('keterangan'),
		);

		if ($validation->run($data, 'pengajian') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pengajian/create'));
		} else {
			$simpan = $this->pengajian->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('pengajian'));
			}
		}
	}


	public function edit($id)
	{
        $data['pengajian'] = $this->pengajian->getData($id);
		return view('pengajian/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
            'guru_id'               => $this->request->getPost('guru_id'),
            'bulan'                 => $this->request->getPost('bulan'),
			'tahun'                 => $this->request->getPost('tahun'),
			'tanggal'               => $this->request->getPost('tanggal'),
			'gaji'                  => $this->request->getPost('gaji'),
			'status'                => $this->request->getPost('status'),
            'keterangan'            => $this->request->getPost('keterangan'),
		);

		if ($validation->run($data, 'pengajian') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('pengajian/edit/' . $id));
		} else {
			$ubah = $this->pengajian->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('pengajian'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('pengajian/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->pengajian->deleteData($id);
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
		return redirect()->to(base_url('pengajian'));
	}
}
