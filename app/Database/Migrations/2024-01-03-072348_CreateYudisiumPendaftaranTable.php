<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateYudisiumPendaftaranTable extends Migration
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
            'tanggal_penerimaan' => [
                'type'              => 'DATE',
                'null'              => true,
            ],
            'status' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'keterangan' => [
                'type'              => 'TEXT',
                'null'              => true,
            ],

            // Berkas yang diupload
            'berkas_transkrip' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'berkas_ijazah' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'berkas_pas_foto' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'berkas_sertifikat_bahasa_inggris' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'berkas_akta_kelahiran' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],
            'berkas_surat_keterangan_mahasiswa' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => true,
            ],

            'mahasiswa_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
            ],
            'peninjau_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
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
        $this->forge->addForeignKey('mahasiswa_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('peninjau_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('yudisium_periode_id', 'yudisium_periode', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('yudisium_pendaftaran');
    }

    public function down()
    {
        $this->forge->dropTable('yudisium_pendaftaran');
    }
}
