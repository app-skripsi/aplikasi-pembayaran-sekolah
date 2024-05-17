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

    public function index(): string {
		$siswa['siswa'] = $this->siswa->join('kelas', 'kelas.id = siswa.kelas_id', 'INNER JOIN')->findAll();
		return view('siswa/index', $siswa);
    }

	public function create()
	{
		// Mendapatkan daftar kelas dari model kelas
		$kelas = $this->kelas->findAll();
	
		// Data yang akan dikirim ke view
		$data = [
			'kelas' => $kelas
		];
	
		// Mengirimkan data ke view dan me-render view
		return view('siswa/create', $data);
	}

    public function store()
	{
		$validation =  \Config\Services::validation();
		$data = array(
			'nama'              => $this->request->getPost('nama'),
            'nis'               => $this->request->getPost('nis'),
			'alamat'            => $this->request->getPost('alamat'),
			'nomor_telepon'     => $this->request->getPost('nomor_telepon'),
			'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
			'tanggal_lahir'     => $this->request->getPost('tanggal_lahir'),
            'kelas_id'          => $this->request->getPost('kelas_id'),
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
		// Mendapatkan detail kelas berdasarkan ID
		$kelas = $this->kelas->find($id);
	
		// Memastikan bahwa kelas tidak null sebelum mengambil siswa terkait
		if ($kelas === null) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException("Kelas with ID $id not found");
		}
	
		// Mendapatkan data siswa berdasarkan ID kelas
		$siswa = $this->siswa->where('kelas_id', $id)->findAll();
	
		// Data yang akan dikirim ke view
		$data = [
			'kelas' => $kelas,
			'siswa' => $siswa
		];
	
		// Mengirimkan data ke view dan me-render view
		return view('siswa/edit', $data);
	}
	

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
			'nama'              => $this->request->getPost('nama'),
            'nis'               => $this->request->getPost('nis'),
			'alamat'            => $this->request->getPost('alamat'),
			'nomor_telepon'     => $this->request->getPost('nomor_telepon'),
			'jenis_kelamin'     => $this->request->getPost('jenis_kelamin'),
			'tanggal_lahir'     => $this->request->getPost('tanggal_lahir'),
            'kelas_id'          => $this->request->getPost('kelas_id'),

		);

		if ($validation->run($data, 'siswa') == FALSE) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('siswa/edit/' . $id));
		} else {
			$ubah = $this->siswa->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				// Sweet Alert success
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('siswa'));
			} else {
				session()->setFlashdata('error', 'Gagal mengupdate data');
				// Sweet Alert error
				session()->setFlashdata('alert', 'error');
				return redirect()->to(base_url('siswa/edit/' . $id));
			}
		}
	}
	public function delete($id)
	{
		$hapus = $this->siswa->deleteData($id);
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
		return redirect()->to(base_url('siswa'));
	}
}
