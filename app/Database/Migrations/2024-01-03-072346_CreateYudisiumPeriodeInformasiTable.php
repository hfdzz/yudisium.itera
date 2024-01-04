<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYudisiumPeriodeInformasiTable extends Migration
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
            'link_grup_whatsapp' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'keterangan' => [
                'type'              => 'TEXT',
                'null'              => true,
            ],
            'yudisium_periode_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
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
        $this->forge->addForeignKey('yudisium_periode_id', 'yudisium_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('yudisium_periode_informasi');
    }

    public function down()
    {
        $this->forge->dropTable('yudisium_periode_informasi');
    }
}
