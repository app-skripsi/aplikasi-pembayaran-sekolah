<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Spp extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'siswa_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'kelas_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'tahun_ajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'bulan_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nominal_pembayaran' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'tanggal_pembayaran' => [
                'type' => 'DATE',
            ],
            'status_pembayaran' => [
                'type' => 'ENUM',
                'constraint' => ['Lunas', 'Belum Lunas'],
                'default' => 'Belum Lunas',
            ],
            'metode_pembayaran' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('siswa_id','siswa','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('kelas_id','kelas','id','CASCADE','CASCADE');
        $this->forge->createTable('spp');
    }

    public function down()
    {
        $this->forge->dropTable('spp');
    }
}