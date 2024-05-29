<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Spp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'siswa' => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'kelas'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'nis' => [
                'type'              => 'INT',
                'constraint'        => 100,
            ],
            'tahun_ajaran'          => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
            ],
            'bulan_pembayaran'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
            ],
            'nominal_pembayaran'    => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,3',
            ],
            'tanggal_pembayaran'    => [
                'type'              => 'INT',
                'constraint'        => 4,
            ],
            'status_pembayaran'     => [
                'type'              => 'ENUM',
                'constraint'        => ['Lunas', 'Belum Lunas'],
                'default'           => 'Belum Lunas',
            ],
            'metode_pembayaran'     => [
                'type'              => 'ENUM',
                'constraint'        => ['Transfer', 'Cash'],
                'default'           => 'Cash',
            ],
            'bukti_pembayaran'      => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'catatan'               => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('spp', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('spp');
    }
}