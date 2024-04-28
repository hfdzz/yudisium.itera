<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYudisiumPeriodeTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'periode' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'tanggal_awal' => [
                'type'              => 'DATE',
            ],
            'tanggal_akhir' => [
                'type'              => 'DATE',
            ],
            
            'created_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'updated_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'deleted_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('yudisium_periode');
    }

    public function down()
    {
        $this->forge->dropTable('yudisium_periode');
    }
}
