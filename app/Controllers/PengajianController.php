<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\GuruModel;
use App\Models\PengajianModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

	public function index()
	{
		if (session()->get('username') == '') {
			session()->setFlashdata('harus login', 'Silahkan Login Terlebih Dahulu');
			return redirect()->to(base_url('login'));
		}
		$data['pengajian'] = $this->pengajian->select('penggajian.*, guru.nama')
			->join('guru', 'guru.id = penggajian.guru_id')
			->findAll();
		return view('pengajian/index', $data);
	}
	public function create()
	{
		if (session()->get('username') == '') {
			session()->setFlashdata('harus login', 'Silahkan Login Terlebih Dahulu');
			return redirect()->to(base_url('login'));
		}
		$guru = $this->guru->findAll();
		$data = [
			'guru' => $guru,
			'statusPembayaranEnum' => $this->pengajian->getStatusPembayaranEnum(),
		];
		return view('pengajian/create', $data);
	}
	public function store()
	{
		$validation = \Config\Services::validation();
		$validation->setRules([], []);
		$validation->setRules([
			'guru_id' => 'required',
			'bulan' => 'required',
			'tahun' => 'required',
			'tanggal' => 'required',
			'npk'	=> 'required',
			'gaji' => 'required',
			'status' => 'required',
			'keterangan' => 'required',
		]);
		$data = array(
			'guru_id' => $this->request->getPost('guru_id'),
			'bulan' => $this->request->getPost('bulan'),
			'tahun' => $this->request->getPost('tahun'),
			'tanggal' => $this->request->getPost('tanggal'),
			'gaji' => $this->request->getPost('gaji'),
			'status' => $this->request->getPost('status'),
			'npk'		=> $this->request->getPost('npk'),
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
		if (session()->get('username') == '') {
			session()->setFlashdata('harus login', 'Silahkan Login Terlebih Dahulu');
			return redirect()->to(base_url('login'));
		}
		$guru = $this->guru->findAll();
		$data['guru'] = ['' => 'Pilih Guru'] + array_column($guru, 'nama', 'id');
		$data['pengajian'] = $this->pengajian->find($id);
		$data['statusPembayaranEnum'] = $this->pengajian->getStatusPembayaranEnum();
		return view('pengajian/edit', $data);
	}
	public function update()
	{
		if (session()->get('username') == '') {
			session()->setFlashdata('harus login', 'Silahkan Login Terlebih Dahulu');
			return redirect()->to(base_url('login'));
		}
		$id = $this->request->getPost('id');

		$validation = \Config\Services::validation();

		$data = array(
			'guru_id' => $this->request->getPost('guru_id'),
			'bulan' => $this->request->getPost('bulan'),
			'tahun' => $this->request->getPost('tahun'),
			'tanggal' => $this->request->getPost('tanggal'),
			'gaji' => $this->request->getPost('gaji'),
			'status' => $this->request->getPost('status'),
			'npk'		=> $this->request->getPost('npk'),
			'keterangan' => $this->request->getPost('keterangan'),
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
		if (session()->get('username') == '') {
			session()->setFlashdata('harus login', 'Silahkan Login Terlebih Dahulu');
			return redirect()->to(base_url('login'));
		}

		if (!is_numeric($id) || $id <= 0) {
			log_message('error', 'Nomor urutan tidak valid');
			return redirect()->to(base_url('pengajian'));
		}

		$hapus = $this->pengajian->deleteData($id);
		if ($hapus) {
			log_message('info', 'Data berhasil dihapus');
			session()->setFlashdata('success', 'Data berhasil dihapus');
		} else {
			// Penghapusan gagal, catat pesan kesalahan ke log console
			log_message('error', 'Gagal menghapus data');
			session()->setFlashdata('error', 'Gagal menghapus data');
		}

		return redirect()->to(base_url('pengajian'));
	}
	public function pdf($id)
	{
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
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'MI AL Mamuriyah - JAKARTA', ' JL Raden Saleh Raya, No. 30, Cikini, Menteng, Jakarta Pusat, DKI Jakarta, 10330, Indonesia', PDF_HEADER_STRING);
		$pdf->SetY(50); // Ubah angka ini sesuai dengan posisi yang diinginkan
		$pdf->Line(10, $pdf->GetY(), $pdf->getPageWidth() - 10, $pdf->GetY());

		// Set header and footer fonts
		$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

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
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Guru:</strong> ' . $pengajian['nama'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>NIP:</strong>' . $pengajian['npk'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Gaji Bulan:</strong> ' . $pengajian['bulan'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Tahun:</strong> ' . $pengajian['tahun'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Tanggal:</strong> ' . $pengajian['tanggal'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Status:</strong> ' . $pengajian['status'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p><strong>Tanggal:</strong> ' . $pengajian['tanggal'] . '</p>';
		$html .= '<p><hr></p>';
		$html .= '<p>Take Home Pay: <strong> Rp. ' . $pengajian['gaji'] . ',000</strong></p>';
		$html .= '<p><hr></p>';

		// Write HTML content to PDF
		$pdf->writeHTML($html, true, false, true, false, '');

		// Output PDF
		$this->response->setContentType('application/pdf');
		$pdf->Output('Slip Pengajian.pdf', 'I');
	}

	public function excel()
	{
		$exportXls = $this->pengajian->select('penggajian.*, guru.nama')
			->join('guru', 'guru.id = penggajian.guru_id')
			->findAll();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Laporan Data Penggajian Guru')
			->setCellValue('A2', 'Tanggal: ' . date('Y-m-d'))
			->setCellValue('B3', 'Nama ')
			->setCellValue('C3', 'Npk ')
			->setCellValue('D3', 'Bulan')
			->setCellValue('E3', 'Tahun')
			->setCellValue('F3', 'Tanggal')
			->setCellValue('G3', 'Gaji')
			->setCellValue('H3', 'Status')
			->setCellValue('I3', 'Keterangan');

		// Merge cells for the title
		$spreadsheet->getActiveSheet()->mergeCells('A1:I1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:I2');
		// Center align the title
		$spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Add yellow background and border to the title row
		$spreadsheet->getActiveSheet()->getStyle('A1:I2')->applyFromArray([
			'fill' => [
				'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
				'startColor' => ['rgb' => 'FFFF00'], // Yellow background
			],
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		]);

		// Set column widths
		$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20); // Width for cell A2
		$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Center align column headers
		$spreadsheet->getActiveSheet()->getStyle('B3:I3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$column = 4;
		$rowNumber = 1;

		foreach ($exportXls as $dokumens) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B' . $column, $dokumens['nama'])
				->setCellValue('C' . $column, $dokumens['npk'])
				->setCellValue('D' . $column, $dokumens['bulan'])
				->setCellValue('E' . $column, $dokumens['tahun'])
				->setCellValue('F' . $column, $dokumens['tanggal'])
				->setCellValue('G' . $column, 'Rp ' . $dokumens['gaji'] . ',000')
				->setCellValue('H' . $column, $dokumens['status'])
				->setCellValue('I' . $column, $dokumens['keterangan']);

			// Set auto numbering on the left side of the data
			$spreadsheet->getActiveSheet()->setCellValue('A' . $column, $rowNumber++);
			$spreadsheet->getActiveSheet()->getStyle('A' . $column . ':I' . $column)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
			$column++;
		}

		// Set border for data cells
		$highestColumn = $spreadsheet->getActiveSheet()->getHighestColumn();
		$highestRow = $spreadsheet->getActiveSheet()->getHighestRow();
		$range = 'A3:' . $highestColumn . $highestRow;
		$spreadsheet->getActiveSheet()->getStyle($range)->applyFromArray([
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				],
			],
		]);
		$spreadsheet->getActiveSheet()->setCellValue('A3', 'No');
		$writer = new Xlsx($spreadsheet);
		$filename = date('Y-m-d-His') . '-Data-Penggajian';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}
}
