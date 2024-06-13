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

class SppController extends BaseController
{
    protected $spp, $kelas, $siswa;

    public function __construct()
    {
        helper(['form']);
        $this->spp = new SppModel();
        $this->kelas = new KelasModel();
        $this->siswa = new SiswaModel();
		// Inisialisasi konfigurasi Midtrans
		$midtransConfig = new \Config\Midtrans();

		// Set konfigurasi Midtrans
		\Midtrans\Config::$serverKey = $midtransConfig::$serverKey;
		\Midtrans\Config::$isProduction = $midtransConfig::$isProduction;
		\Midtrans\Config::$isSanitized = $midtransConfig::$isSanitized;
		\Midtrans\Config::$is3ds = $midtransConfig::$is3ds;
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

	public function searchSppByNamaSiswa()
	{
		$namaSiswa = $this->request->getPost('nama');
	
		$spp = $this->spp->select('spp.*, siswa.nama AS nama, kelas.kelas')
			->join('siswa', 'spp.siswa_id = siswa.id')
			->join('kelas', 'siswa.kelas_id = kelas.id')
			->where('siswa.nama', $namaSiswa) // Menggunakan 'where' untuk pencarian yang tepat
			->findAll();
	
		if ($spp) {
			$data['spp'] = $spp;
			return view('spp/informasi-pembayaran', $data);
		} else {
			$data['error'] = 'Data pembayaran SPP untuk siswa dengan nama "' . $namaSiswa . '" tidak ditemukan.';
			return redirect()->to(base_url('/bayar-spp'))->with('error', $data['error']);
		}
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
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Guru:</strong> ' . $pengajian['nama'] . '</p>';
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>NPK:</strong>'. $pengajian['npk'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Gaji Bulan:</strong> '. $pengajian['bulan'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Tahun:</strong> '. $pengajian['tahun'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Tanggal:</strong> '. $pengajian['tanggal'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Status:</strong> '. $pengajian['status'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p><strong>Tanggal:</strong> '. $pengajian['tanggal'] .'</p>'; 
		$html .= '<p><hr></p>'; 
		$html .= '<p>Take Home Pay: <strong> Rp. ' . $pengajian['gaji'] . ',000</strong></p>';
		$html .= '<p><hr></p>'; 

		// Write HTML content to PDF
		$pdf->writeHTML($html, true, false, true, false, '');
	
		// Output PDF
		$this->response->setContentType('application/pdf');
		$pdf->Output('Slip Pengajian.pdf', 'I');
	}
	
	public function xls()
	{
		$exportXls = $this->spp->select('spp.*, guru.nama')
		->join('guru', 'guru.id = spp.guru_id')
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
		$filename = date('Y-m-d-His'). '-Data-Penggajian';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename=' . $filename . '.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function createMidtransTransaction($nis)
	{
		$spp = $this->spp
			->select('spp.*, siswa.nama') // Select SPP fields and student name
			->join('siswa', 'siswa.nis = spp.nis') // Join with siswa table on nis
			->where('spp.nis', $nis)
			->first();
	
		// Create transaction parameters
		$transactionDetails = [
			'order_id' => 'order-' . uniqid(),
			'gross_amount' => $spp['nominal_pembayaran'],
		];
	
		$itemDetails = [
			[
				'id' => 'spp-' . $spp['id'],
				'price' => $spp['nominal_pembayaran'],
				'quantity' => 1,
				'name' => 'Pembayaran SPP ' . $spp['nama'],
			],
		];
	
		$customerDetails = [
			'first_name' => $spp['nama'],
			'email' => 'email@example.com',
			'phone' => '081234567890',
		];
	
		$transaction = [
			'transaction_details' => $transactionDetails,
			'item_details' => $itemDetails,
			'customer_details' => $customerDetails,
		];
	
		try {
			$snapToken = Snap::getSnapToken($transaction);
			// Store snapToken in session
			session()->setFlashdata('snapToken', $snapToken);
			return redirect()->to(base_url('/halaman-pembayaran'));
		} catch (Exception $e) {
			return redirect()->back()->with('error', $e->getMessage());
		}
	}	
	
}
