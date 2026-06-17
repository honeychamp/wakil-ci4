<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPracticeAreaToCases extends Migration
{
    public function up()
    {
        // Add 'practice_area' field to cases table
        // This tracks which law category the case belongs to
        $this->forge->addColumn('cases', [
            'practice_area' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'description',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('cases', 'practice_area');
    }
}
