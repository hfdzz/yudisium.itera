<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TanggalYudisiumDanSidang extends Migration
{
    public function up()
    {
        // add column "tanggal_yudisium" to yudisium_periode

        $this->forge->addColumn('yudisium_periode', [
            'tanggal_yudisium' => [
                'type' => 'DATE',
                'after' => 'periode'
            ]
        ]);

        // add column "tanggal_sidang" to surat_keterangan

        $this->forge->addColumn('surat_keterangan', [
            'tanggal_sidang' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'file_surat_keterangan'
            ]
        ]);
        
    }

    public function down()
    {
        // drop column "tanggal_yudisium" from yudisium_periode

        $this->forge->dropColumn('yudisium_periode', 'tanggal_yudisium');

        // drop column "tanggal_sidang" from surat_keterangan

        $this->forge->dropColumn('surat_keterangan', 'tanggal_sidang');

    }
}
