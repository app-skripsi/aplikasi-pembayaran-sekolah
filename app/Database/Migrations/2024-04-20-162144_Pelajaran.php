<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pelajaran extends Migration
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
            'nama_pelajaran' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('pelajaran');
    }

    public function down()
    {
        $this->forge->dropTable('pelajaran');
    }
}
