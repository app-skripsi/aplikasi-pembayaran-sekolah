<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Spp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'kelas_id'              => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'siswa_id'              => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
            'nis'                   => [
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
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'cascade', 'cascade');
        $this->forge->addForeignKey('siswa_id', 'siswa', 'id', 'cascade', 'cascade');
        $this->forge->createTable('spp', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('spp');
    }
}