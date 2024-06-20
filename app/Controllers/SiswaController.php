<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;

class SiswaController extends BaseController
{
	protected $siswa;
	protected $kelas;

	public function __construct()
	{
		helper(['form']);
		$this->siswa = new SiswaModel();
		$this->kelas = new KelasModel();
	}

	public function index(): string
	{
		$siswa['siswa'] = $this->siswa->select('siswa.*, kelas.kelas')
			->join('kelas', 'kelas.id = siswa.kelas_id')
			->findAll();
		return view('siswa/index', $siswa);
	}

	public function create()
	{
		$kelas = $this->kelas->findAll();
		$data = ['kelas' => $kelas];
		return view('siswa/create', $data);
	}

	public function store()
	{
		$validation = \Config\Services::validation();
		$data = array(
			'nama' 			=> $this->request->getPost('nama'),
			'nis' 			=> $this->request->getPost('nis'),
			'alamat' 		=> $this->request->getPost('alamat'),
			'nomor_telepon' => $this->request->getPost('nomor_telepon'),
			'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
			'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
			'kelas_id' 		=> $this->request->getPost('kelas_id'),
		);

		if ($validation->run($data, 'siswa') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('siswa/create'));
		} else {
			$simpan = $this->siswa->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('siswa'));
			}
		}
	}

	public function edit($id)
	{
		$kelas = $this->kelas->findAll();
		$data['kelas'] = ['' => 'Pilih Kelas'] + array_column($kelas, 'kelas', 'id');
		$data['siswa'] = $this->siswa->find($id);
		return view('siswa/edit', $data);
	}



	public function update()
	{
		$id = $this->request->getPost('id');

		$validation = \Config\Services::validation();

		$data = array(
			'nama' 			=> $this->request->getPost('nama'),
			'nis' 			=> $this->request->getPost('nis'),
			'alamat' 		=> $this->request->getPost('alamat'),
			'nomor_telepon' => $this->request->getPost('nomor_telepon'),
			'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
			'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
			'kelas_id' 		=> $this->request->getPost('kelas_id'),

		);

		if ($validation->run($data, 'siswa') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('siswa/edit/' . $id));
		} else {
			$ubah = $this->siswa->updateData($data, $id);
			if ($ubah) {
				return redirect()->to(base_url('siswa'));
			} else {
				return redirect()->to(base_url('siswa/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->siswa->deleteData($id);
		if ($hapus) {
			session()->setFlashdata('warning', 'Delete Data  Berhasil');
			return redirect()->to(base_url('siswa'));
		}
	}
}
