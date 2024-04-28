<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSuratKeteranganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 18,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jenis_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => 255,
                'null' => true,
            ],
            'nomor_surat' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'tanggal_pengajuan' => [
                'type' => 'DATE',
            ],
            'tanggal_terbit' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_surat_keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            // Berkas yang diupload
            // SK Bebas UKT
            'berkas_ba_sidang' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'berkas_khs' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'berkas_bukti_bayar_ukt' => [ // bukti bayar UKT dari AVITA
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            // Foreign Keys
            'mahasiswa_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'peninjau_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],

            // Timestamps
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('mahasiswa_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('peninjau_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('surat_keterangan');
    }

    public function down()
    {
        $this->forge->dropTable('surat_keterangan');
    }
}
