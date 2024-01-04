<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyUserAttributes extends Migration
{
    public function up()
    {
        // Add column 'nim'
        $this->forge->addColumn('users', [
            'nim' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'username',
                'null' => true,
                'unique' => true,
            ],
        ]);

        // Add column 'program_studi'
        $this->forge->addColumn('users', [
            'program_studi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'after' => 'nim',
                'null' => true,
            ],
        ]);

        // Add column 'nip'
        $this->forge->addColumn('users', [
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 18,
                'after' => 'program_studi',
                'null' => true,
                'unique' => true,
            ],
        ]);
    }

    public function down()
    {
        // Drop column 'program_studi'
        $this->forge->dropColumn('users', 'program_studi');

        // Drop column 'nip'
        $this->forge->dropColumn('users', 'nip');

        // Drop column 'nim'
        $this->forge->dropColumn('users', 'nim');
    }
}
