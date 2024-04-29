<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
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
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nomor_telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
                'default' => 'L',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'kelas_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
