<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $spp = [
		'tahun_ajaran'           => 'required',
        'bulan_pembayaran'       => 'required',
        'nominal_pembayaran'     => 'required',
        'tanggal_pembayaran'     => 'required',
        'status_pembayaran'      => 'required',
        'metode_pembayaran'      => 'required',
        'catatan'                => 'required',
        'siswa_id'               => 'required',
        'kelas_id'               => 'required',
        'nis'                    => 'required',
        'bukti_pembayaran'       => 'required',
	];

	public $spp_errors = [
		'tahun_ajaran'      	=> [
			'required'			=> 'Tahun Ajaran Tidak Boleh Kosong'
        ],
        'bulan_pembayaran'      => [
			'required'			=> 'Bulan Pembayaran Tidak Boleh Kosong'
        ],
        'nominal_pembayaran'    => [
			'required'			=> 'Nominal Pembayaran Tidak Boleh Kosong'
        ],
        'tanggal_pembayaran'    => [
			'required'			=> 'Tanggal Pembayaran Tidak Boleh Kosong'
        ],
        'status_pembayaran'     => [
			'required'			=> 'Status Pembayaran Tidak Boleh Kosong'
        ],
        'metode_pembayaran'     => [
			'required'			=> 'Metode Pembayaran Tidak Boleh Kosong'
        ],
        'catatan'      	        => [
			'required'			=> 'Catatan Tidak Boleh Kosong'
        ],
        'siswa_id'      	    => [
			'required'			=> 'Siswa Tidak Boleh Kosong'
        ],
        'kelas_id'      	    => [
			'required'			=> 'Kelas Tidak Boleh Kosong'
        ],
        'nis'      	            => [
			'required'			=> 'Nis Tidak Boleh Kosong'
        ],
        'bukti_pembayaran'      => [
			'required'			=> 'Bukti Pembayaran Tidak Boleh Kosong'
        ]
	];

    public $pengajian = [
		'guru_id'               => 'required',
        'npk'                   => 'required',
        'bulan'                 => 'required',
        'tahun'                 => 'required',
        'tanggal'               => 'required',
        'gaji'                  => 'required',
        'status'                => 'required',
        'keterangan'            => 'required',
	];

	public $pengajian_errors = [
		'guru_id'      	        => [
			'required'			=> 'Guru Tidak Boleh Kosong'
        ],
        'npk'                   => [
			'required'			=> 'Npk Tidak Boleh Kosong'
        ],
        'bulan'                 => [
			'required'			=> 'Bulan Tidak Boleh Kosong'
        ],
        'tahun'                 => [
			'required'			=> 'Tahun  Tidak Boleh Kosong'
        ],
        'tanggal'               => [
			'required'			=> 'Tanggal Tidak Boleh Kosong'
        ],
        'gaji'                  => [
			'required'			=> 'Gaji Tidak Boleh Kosong'
        ],
        'status'                => [
			'required'			=> 'Status Tidak Boleh Kosong'
        ],
        'keterangan'      	    => [
			'required'			=> 'Keterangan Tidak Boleh Kosong'
        ]
	];
    public $guru = [
		'nama'                  => 'required',
        'nip'                   => 'required',
        'nomor_telepon'         => 'required',
        'alamat'                => 'required',
        'email'                 => 'required',
	];

	public $guru_errors = [
		'nama'      	        => [
			'required'			=> 'Nama Tidak Boleh Kosong'
        ],
        'nip'      	            => [
			'required'			=> 'Nip Tidak Boleh Kosong'
        ],
        'alamat'      	        => [
			'required'			=> 'Alamat Tidak Boleh Kosong'
        ],
        'nomor_telepon'      	=> [
			'required'			=> 'Nomer Telephone Tidak Boleh Kosong'
        ],
        'email'      	        => [
			'required'			=> 'Email Tidak Boleh Kosong'
        ]
	];

    
    public $siswa = [
		'nama'                   => 'required',
        'nis'                    => 'required',
        'alamat'                 => 'required',
        'nomor_telepon'          => 'required',
        'jenis_kelamin'          => 'required',
        'tanggal_lahir'          => 'required',
        'kelas_id'               => 'required',
	];

	public $siswa_errors = [
		'nama'      	        => [
			'required'			=> 'Nama Tidak Boleh Kosong'
        ],
        'nis'      	            => [
			'required'			=> 'Nis Tidak Boleh Kosong'
        ],
        'Alamat'      	        => [
			'required'			=> 'Alamat Tidak Boleh Kosong'
        ],
        'nomor_telepon'      	=> [
			'required'			=> 'Nomor Telephon Tidak Boleh Kosong'
        ],
        'jenis_kelamin'      	=> [
			'required'			=> 'Jenis Kelamin Tidak Boleh Kosong'
        ],
        'tanggal_lahir'         => [
			'required'			=> 'Tanggal Lahir Tidak Boleh Kosong'
        ]
	];
    public $kelas = [
		'kelas'                     => 'required',
        'description'               => 'required',
	];

	public $kelas_errors = [
		'kelas'      	        => [
			'required'			=> 'Kelas Tidak Boleh Kosong'
        ],
        'description'      	    => [
			'required'			=> 'Description Tidak Boleh Kosong'
        ]
	];
}
