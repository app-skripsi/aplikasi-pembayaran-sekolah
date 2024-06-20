<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Guru extends Migration
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
            'nama'                  => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
            ],
            'nip'                   => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
            ],
            'alamat'                => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'nomor_telepon'         => [
                'type'              => 'VARCHAR',
                'constraint'        => 20,
                'null'              => true,
            ],
            'email'                 => [
                'type'              => 'VARCHAR',
                'constraint'        => 100,
                'null'              => true,
            ]
        ]);

        $this->forge->addKey('id', TRUE);
        $this->forge->createTable('guru', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
