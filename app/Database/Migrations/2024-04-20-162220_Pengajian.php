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
            'guru_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'null'				=> TRUE
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
                'type' => 'DATE',
            ],
            'gaji' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
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
        $this->forge->addForeignKey('guru_id','guru','id','cascade','cascade');
        $this->forge->createTable('pengajian', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('pengajian');
    }
}