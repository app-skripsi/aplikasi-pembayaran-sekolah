<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penggajian extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'guru_id'               => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
            ],
            'npk'                   => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'bulan'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'tahun'                 => [
                'type'              => 'INT',
                'constraint'        => 4,
            ],
            'tanggal'               => [
                'type'              => 'INT',
                'constraint'        => 4,
            ],
            'gaji'                  => [
                'type'              => 'DECIMAL',
                'constraint'        => '10,3',
            ],
            'status'                => [
                'type'              => 'ENUM',
                'constraint'        => ['Sudah Dibayar', 'Belum Dibayar', 'Lunas'],
                'default'           => 'Belum dibayar',
            ],
            'keterangan'            => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('guru_id','guru','id','cascade','cascade');
        $this->forge->createTable('penggajian', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('penggajian');
    }
}