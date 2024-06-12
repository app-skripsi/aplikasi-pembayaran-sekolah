<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\PengajianModel;
use TCPDF;

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
		$data['pengajian'] = $this->pengajian->select('penggajian.*, guru.nama')
		->join('guru', 'guru.id = penggajian.guru_id')
		->findAll();
		return view('pengajian/index', $data);
	}


	public function create(): string
	{
		 $guru = $this->guru->findAll();
		$data = [
			'guru' => $guru,
			'statusPembayaranEnum' => $this->pengajian->getStatusPembayaranEnum(),
		];
				return view('pengajian/create', $data);
	}


	public function store()
	{
		$validation =  \Config\Services::validation();
		$validation->setRules([], []); 
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
		$validation->reset(); 
		$validation->setRules([
		]);
	}
	


	public function edit($id)
	{
		$guru = $this->guru->findAll();
		$data['guru'] = ['' => 'Pilih Guru'] + array_column($guru, 'nama', 'id');
		$data['pengajian'] = $this->pengajian->find($id);
		$data['statusPembayaranEnum'] = $this->pengajian->getStatusPembayaranEnum();
        return view('pengajian/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');

		$validation =  \Config\Services::validation();

		$data = array(
			'guru_id'               => $this->request->getPost('guru_id'),
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
	
	public function pdf($id){
		// Proteksi halaman
		$pengajian = $this->pengajian->getPengajianById($id); // Mengambil data pengajian berdasarkan ID
	
		// Pastikan data pengajian ditemukan
		if (!$pengajian) {
			// Tampilkan pesan error atau redirect ke halaman lain jika tidak ditemukan
			return redirect()->to(base_url('/pengajian'))->with('error', 'Data pengajian tidak ditemukan.');
		}
	
		// Mengambil data pengajian berdasarkan ID dengan join guru
		$pengajian = $this->pengajian
						->select('penggajian.*, guru.nama')
						->join('guru', 'guru.id = penggajian.guru_id')
						->where('penggajian.id', $id)
						->first(); // Fetching single record
	
		// Pastikan data pengajian ditemukan
		if (!$pengajian) {
			// Tampilkan pesan error atau redirect ke halaman lain jika tidak ditemukan
			return redirect()->to(base_url('/pengajian'))->with('error', 'Data pengajian tidak ditemukan.');
		}
	
		// Inisialisasi objek TCPDF
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);
	
		// Pengaturan properti PDF
		$pdf->SetCreator('Creator Name');
		$pdf->SetAuthor('Author Name');
		$pdf->SetTitle('Slip Pengajian');
		$pdf->SetSubject('Subject of PDF');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
	
		// Set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH,  'MI AL Mamuriyah - JAKARTA',' JL Raden Saleh Raya, No. 30, Cikini, Menteng, Jakarta Pusat, DKI Jakarta, 10330, Indonesia', PDF_HEADER_STRING);
		$pdf->SetY(50); // Ubah angka ini sesuai dengan posisi yang diinginkan
		$pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());

		// Set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
		// Set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
		// Set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	
		// Set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
		// Set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', 12));
   	 	$pdf->SetFont('dejavusans', '', 10);
		// Add a page
		$pdf->AddPage();
	
		// Generate HTML content for slip pengajian
		$html = '<h1 style="text-align:center">Slip Gaji  ' . $pengajian['nama'] . '</h1><hr><br><br>';
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Guru:</strong> ' . $pengajian['nama'] . '</p>';
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>NPK:</strong>'. $pengajian['npk'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Gaji Bulan:</strong> '. $pengajian['bulan'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Tahun:</strong> '. $pengajian['tahun'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Tanggal:</strong> '. $pengajian['tanggal'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Status:</strong> '. $pengajian['status'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><strong>Tanggal:</strong> '. $pengajian['tanggal'] .'</p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan
		$html .= '<p>Take Home Pay: <strong> Rp. ' . $pengajian['gaji'] . ',000</strong></p>';
		$html .= '<p><hr></p>'; // Ganti dengan data sesuai kebutuhan

		// Write HTML content to PDF
		$pdf->writeHTML($html, true, false, true, false, '');
	
		// Output PDF
		$this->response->setContentType('application/pdf');
		$pdf->Output('Slip Pengajian.pdf', 'I');
	}
	
}
