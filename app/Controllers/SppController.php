<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\SiswaModel;
use App\Models\SppModel;
use Midtrans\Snap;
use Config\Midtrans;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use TCPDF;

class SppController extends BaseController
{
	protected $spp, $kelas, $siswa;

	public function __construct()
	{
		helper(['form']);
		$this->spp = new SppModel();
		$this->kelas = new KelasModel();
		$this->siswa = new SiswaModel();
	}

	public function index(): string
	{
		$data['spp'] = $this->spp->select('spp.*, kelas.kelas, siswa.nama')
			->join('kelas', 'kelas.id = spp.kelas_id')
			->join('siswa', 'siswa.id = spp.siswa_id')
			->findAll();
		return view('spp/index', $data);
	}

	public function create(): string
	{
		$kelas = $this->kelas->findAll();
		$siswa = $this->siswa->findAll();
		$data = [
			'kelas' => $kelas,
			'siswa' => $siswa,
			'statusPembayaranEnum' => $this->spp->getStatusPembayaranEnum(),
			'metodePembayaranEnum' => $this->spp->getMetodePembayaranEnum()
		];
		return view('spp/create', $data);
	}

	public function store()
	{
		$dataBuktiPembayaran = $this->request->getFile('bukti_pembayaran');
		if (!$dataBuktiPembayaran) {
			session()->setFlashdata('error', 'File upload tidak ditemukan');
			return redirect()->back()->withInput();
		}
		if ($dataBuktiPembayaran->isValid() && !$dataBuktiPembayaran->hasMoved()) {
			$fileBuktiPembayaran = $dataBuktiPembayaran->getName();
			$dataBuktiPembayaran->move('uploads/bukti_pembayaran/', $fileBuktiPembayaran);
		} else {
			session()->setFlashdata('error', 'File upload gagal');
			return redirect()->back()->withInput();
		}

		$validation = \Config\Services::validation();
		$data = [
			'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
			'bulan_pembayaran' => $this->request->getPost('bulan_pembayaran'),
			'nominal_pembayaran' => $this->request->getPost('nominal_pembayaran'),
			'tanggal_pembayaran' => $this->request->getPost('tanggal_pembayaran'),
			'status_pembayaran' => $this->request->getPost('status_pembayaran'),
			'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
			'catatan' => $this->request->getPost('catatan'),
			'nis' => $this->request->getPost('nis'),
			'siswa_id' => $this->request->getPost('siswa_id'),
			'kelas_id' => $this->request->getPost('kelas_id'),
			'bukti_pembayaran' => $fileBuktiPembayaran,
		];
		if ($validation->run($data, 'spp') == false) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('spp/create'));
		} else {
			$simpan = $this->spp->insertData($data);
			if ($simpan) {
				session()->setFlashdata('success', 'Tambah Data Berhasil');
				return redirect()->to(base_url('spp'));
			}
		}
	}

	// public function searchSppByNamaSiswa()
	// {
	// 	// Set your Merchant Server Key
	// 	\Midtrans\Config::$serverKey = 'SB-Mid-server-30dKRBZjEbfnaSnrQ7vD8xaY';
	// 	// Set to Development/Sandbox Environment (default). Set to false for Production Environment.
	// 	\Midtrans\Config::$isProduction = false;
	// 	// Set sanitization on (default)
	// 	\Midtrans\Config::$isSanitized = true;
	// 	// Set 3DS transaction for credit card to true
	// 	\Midtrans\Config::$is3ds = true;

	// 	$namaSiswa = $this->request->getPost('nama');

	// 	// Fetch the SPP data by student's name
	// 	$spp = $this->spp
	// 		->select('spp.*, siswa.nama, kelas.kelas')
	// 		->join('siswa', 'spp.siswa_id = siswa.id')
	// 		->join('kelas', 'siswa.kelas_id = kelas.id')
	// 		->where('siswa.nama', $namaSiswa) // Use 'where' for exact search
	// 		->findAll();

	// 	if (!$spp) {
	// 		// Handle case when SPP data is not found
	// 		$data['error'] = 'Data pembayaran SPP untuk siswa dengan nama "' . $namaSiswa . '" tidak ditemukan.';
	// 		return redirect()->to(base_url('/bayar-spp'))->with('error', $data['error']);
	// 	}

	// 	// Assuming there's only one SPP record per student for simplicity
	// 	$sppRecord = $spp[0];

	// 	// Create transaction parameters
	// 	$transaction = array(
	// 		'transaction_details' => array(
	// 			'order_id' => rand(),
	// 			'gross_amount' => $sppRecord['nominal_pembayaran'],
	// 		),
	// 		'customer_details' => array(
	// 			'first_name' => $sppRecord['nama'],
	// 			'last_name' => '',
	// 			'email' => 'customer@example.com', // You might want to fetch this from your database
	// 			'phone' => '08123456789' // You might want to fetch this from your database
	// 		)
	// 	);

	// 	$data = [
	// 		'snapToken' => \Midtrans\Snap::getSnapToken($transaction),
	// 		'spp' => $spp
	// 	];

	// 	return view('spp/halaman-pembayaran', $data);
	// }

	public function searchSppByNamaSiswa()
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = 'Mid-server-2Qn12txPd1Br6TPV15nXH30_';
		// Set to Development/Sandbox Environment (default). Set to false for Production Environment.
		\Midtrans\Config::$isProduction = true;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;

		$namaSiswa = $this->request->getPost('nama');

		// Fetch the SPP data by student's name
		$spp = $this->spp
			->select('spp.*, siswa.nama, kelas.kelas')
			->join('siswa', 'spp.siswa_id = siswa.id')
			->join('kelas', 'siswa.kelas_id = kelas.id')
			->where('siswa.nama', $namaSiswa) // Use 'where' for exact search
			->findAll();

		if (!$spp) {
			// Handle case when SPP data is not found
			$data['error'] = 'Data pembayaran SPP untuk siswa dengan nama "' . $namaSiswa . '" tidak ditemukan.';
			return redirect()->to(base_url('/bayar-spp'))->with('error', $data['error']);
		}

		// Assuming there's only one SPP record per student for simplicity
		$sppRecord = $spp[0];

		// Check if nominal_pembayaran is set and valid
		if (isset($sppRecord['nominal_pembayaran']) && !empty($sppRecord['nominal_pembayaran'])) {
			// Create transaction parameters
			$transaction = array(
				'transaction_details' => array(
					'order_id' => rand(),
					'gross_amount' => (int) $sppRecord['nominal_pembayaran'] * 1000, // Ensure gross_amount is an integer
				),
				'customer_details' => array(
					'first_name' => $sppRecord['nama'],
					'last_name' => '',
					'email' => 'customer@example.com', // You might want to fetch this from your database
					'phone' => '08123456789' // You might want to fetch this from your database
				)
			);

			$snapToken = \Midtrans\Snap::getSnapToken($transaction);
		} else {
			// Handle case when nominal_pembayaran is not set
			$snapToken = null;
		}

		$data = [
			'snapToken' => $snapToken,
			'spp' => $spp
		];

		return view('spp/halaman-pembayaran', $data);
	}

	public function excel()
	{
		$exportXls = $this->spp->select('spp.*, siswa.nama, kelas.kelas')
			->join('siswa', 'spp.siswa_id = siswa.id')
			->join('kelas', 'siswa.kelas_id = kelas.id')
			->findAll();
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'Laporan Data SPP')
			->setCellValue('A2', 'Tanggal: ' . date('Y-m-d'))
			->setCellValue('B3', 'Nama ')
			->setCellValue('C3', 'Kelas ')
			->setCellValue('D3', 'NIS')
			->setCellValue('E3', 'Tahun Ajaran')
			->setCellValue('F3', 'Bulan Iuran')
			->setCellValue('G3', 'Tanggal Pembayaran')
			->setCellValue('H3', 'Metode Pembayaran')
			->setCellValue('I3', 'Status Pembayaran')
			->setCellValue('J3', 'Nominal Pembayaran');

		// Merge cells for the title
		$spreadsheet->getActiveSheet()->mergeCells('A1:J1');
		$spreadsheet->getActiveSheet()->mergeCells('A2:J2');
		// Center align the title
		$spreadsheet->getActiveSheet()->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
		$spreadsheet->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Add yellow background and border to the title row
		$spreadsheet->getActiveSheet()->getStyle('A1:J2')->applyFromArray([
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
		$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$spreadsheet->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		// Center align column headers
		$spreadsheet->getActiveSheet()->getStyle('B3:J3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$column = 4;
		$rowNumber = 1;

		foreach ($exportXls as $dokumens) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('B' . $column, $dokumens['nama'])
				->setCellValue('C' . $column, $dokumens['kelas'])
				->setCellValue('D' . $column, $dokumens['nis'])
				->setCellValue('E' . $column, $dokumens['tahun_ajaran'])
				->setCellValue('F' . $column, $dokumens['bulan_pembayaran'])
				->setCellValue('G' . $column, $dokumens['tanggal_pembayaran'])
				->setCellValue('H' . $column, $dokumens['status_pembayaran'])
				->setCellValue('I' . $column, $dokumens['metode_pembayaran'])
				->setCellValue('J' . $column, 'Rp ' . $dokumens['nominal_pembayaran']);

			// Set auto numbering on the left side of the data
			$spreadsheet->getActiveSheet()->setCellValue('A' . $column, $rowNumber++);
			$spreadsheet->getActiveSheet()->getStyle('A' . $column . ':J' . $column)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
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
		$filename = date('Y-m-d-His') . '-Data-SPP';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function edit($id)
	{
		$kelas = $this->kelas->findAll();
		$siswa = $this->siswa->findAll();
		$data['kelas'] = ['' => 'Pilih Kelas'] + array_column($kelas, 'kelas', 'id');
		$data['siswa'] = ['' => 'Pilih Siswa'] + array_column($siswa, 'nama', 'id');
		$data['spp'] = $this->spp->find($id);
		$data['statusPembayaranEnum'] = $this->spp->getStatusPembayaranEnum();
		$data['metodePembayaranEnum'] = $this->spp->getMetodePembayaranEnum();
		return view('spp/edit', $data);
	}

	public function update()
	{
		$id = $this->request->getPost('id');
		$validation = \Config\Services::validation();

		$data = [
			'tahun_ajaran' => $this->request->getPost('tahun_ajaran'),
			'bulan_pembayaran' => $this->request->getPost('bulan_pembayaran'),
			'nominal_pembayaran' => $this->request->getPost('nominal_pembayaran'),
			'tanggal_pembayaran' => $this->request->getPost('tanggal_pembayaran'),
			'status_pembayaran' => $this->request->getPost('status_pembayaran'),
			'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
			'catatan' => $this->request->getPost('catatan'),
			'nis' => $this->request->getPost('nis'),
			'siswa_id' => $this->request->getPost('siswa_id'),
			'kelas_id' => $this->request->getPost('kelas_id'),
		];
		if ($validation->run($data, 'spp') == false) {
			session()->setFlashdata('inputs', $this->request->getPost());
			session()->setFlashdata('errors', $validation->getErrors());
			return redirect()->to(base_url('spp/edit/' . $id));
		} else {
			$ubah = $this->spp->updateData($data, $id);
			if ($ubah) {
				session()->setFlashdata('success', 'Update Data Berhasil');
				session()->setFlashdata('alert', 'success');
				return redirect()->to(base_url('spp'));
			}
		}
	}

	public function delete($id)
	{
		$hapus = $this->spp->deleteData($id);
		if ($hapus) {
			session()->setFlashdata('warning', 'Delete Data Berhasil');
			return redirect()->to(base_url('spp'));
		}
	}

	public function halamanPembayaran($nis)
	{
		// Set your Merchant Server Key
		\Midtrans\Config::$serverKey = 'SB-Mid-server-30dKRBZjEbfnaSnrQ7vD8xaY';
		// Set to Development/Sandbox Environment (default). Set to false for Production Environment.
		\Midtrans\Config::$isProduction = false;
		// Set sanitization on (default)
		\Midtrans\Config::$isSanitized = true;
		// Set 3DS transaction for credit card to true
		\Midtrans\Config::$is3ds = true;

		// Fetch the SPP data
		$spp = $this->spp
			->select('spp.*, siswa.nama') // Select SPP fields and student name
			->join('siswa', 'siswa.nis = spp.nis') // Join with siswa table on nis
			->where('spp.nis', $nis)
			->first();

		if (!$spp) {
			// Handle case when SPP data is not found
			return redirect()->back()->with('error', 'Data SPP tidak ditemukan');
		}

		// Create transaction parameters
		$transaction = array(
			'transaction_details' => array(
				'order_id' => rand(),
				'gross_amount' => $spp['nominal_pembayaran'],
			),
			'customer_details' => array(
				'first_name' => $spp['nama'],
				'last_name' => '',
				'email' => 'customer@example.com',
				'phone' => '08123456789'
			)
		);
		$data = [
			'snapToken' => \Midtrans\Snap::getSnapToken($transaction)
		];
		return view('spp/halaman-pembayaran', $data);
	}
}
