<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WaliMurid extends Migration
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
            'email' => [
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
            'siswa_id' => [
                'type' => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'null'              => true,
            ],
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('siswa_id', 'siswa', 'id', 'cascade', 'cascade');
        $this->forge->createTable('wali_murid', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('wali_murid');
    }
}
