<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengajian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'guru' => [
				'type'           => 'VARCHAR',
				'constraint'     => '50',
            ],
            'npk' => [
                'type' => 'INT',
                'constraint' => 40,
            ],
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'tanggal' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'gaji' => [
                'type' => 'INT',
                'constraint' => 40,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['sudah_dibayar', 'belum_dibayar', 'lunas'],
                'default' => 'belum_dibayar',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('penggajian', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('penggajian');
    }
}