<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\Guru;
use App\Models\GuruModel;
use App\Models\PengajianModel;
use CodeIgniter\HTTP\ResponseInterface;

class PengajianController extends BaseController
{
    protected $pengajian;
	protected $guru;

    public function __construct()
	{
		helper(['form']);
		$this->pengajian = new PengajianModel();
		$this->guru = new GuruModel();
	}

    public function index(): string
    {
		$pengajian['pengajian'] = $this->pengajian
		->join('guru', 'guru.id = penggajian.guru_id', 'INNER')
		->findAll();
		return view('pengajian/index', $pengajian);
    }

	public function create(): string
	{
		$data['guru'] = $this->guru->findAll();
		return view('pengajian/create', $data);
	}

	public function store()
	{
		$validation =  \Config\Services::validation();
		
		// Menonaktifkan validasi sementara
		$validation->setRules([], []); // Menyimpan aturan validasi yang kosong untuk menonaktifkan validasi
	
		// Tetapkan aturan validasi sesuai kebutuhan
		$validation->setRules([
			'guru_id' => 'required',
			'npk' => 'required',
			'bulan' => 'required',
			'tahun' => 'required',
			'tanggal' => 'required',
			'gaji' => 'required',
			'status' => 'required',
			'keterangan' => 'required',
		]);
	
		$data = array(
			'guru_id' => $this->request->getPost('guru_id'),
			'npk' => $this->request->getPost('npk'),
			'bulan' => $this->request->getPost('bulan'),
			'tahun' => $this->request->getPost('tahun'),
			'tanggal' => $this->request->getPost('tanggal'),
			'gaji' => $this->request->getPost('gaji'),
			'status' => $this->request->getPost('status'),
			'keterangan' => $this->request->getPost('keterangan'),
		);
	
		if ($validation->run($data) == FALSE) {
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
	
		// Mengaktifkan kembali validasi
		$validation->reset(); // Mengatur ulang semua aturan validasi
	
		// Tetapkan kembali aturan validasi sesuai kebutuhan
		$validation->setRules([
			// Daftar aturan validasi
		]);
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
			'guru'               	=> $this->request->getPost('guru'),
			'npk'              		=> $this->request->getPost('npk'),
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
		// Verifikasi nomor urutan
		if (!is_numeric($id) || $id <= 0) {
			// Nomor urutan tidak valid, catat pesan kesalahan ke log console
			log_message('error', 'Nomor urutan tidak valid');
			return redirect()->to(base_url('pengajian'));
		}
	
		// Panggil fungsi deleteData() untuk menghapus data
		$hapus = $this->pengajian->deleteData($id);
	
		// Periksa apakah penghapusan berhasil
		if ($hapus) {
			// Penghapusan berhasil, catat pesan sukses ke log console
			log_message('info', 'Data berhasil dihapus');
			session()->setFlashdata('success', 'Data berhasil dihapus');
		} else {
			// Penghapusan gagal, catat pesan kesalahan ke log console
			log_message('error', 'Gagal menghapus data');
			session()->setFlashdata('error', 'Gagal menghapus data');
		}
	
		return redirect()->to(base_url('pengajian'));
	}
	
}
