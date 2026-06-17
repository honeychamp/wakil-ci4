<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSpecializationToTeam extends Migration
{
    public function up()
    {
        // Add 'specialization' field to team_members table
        // This allows us to automatically match lawyers to the correct law area
        $this->forge->addColumn('team_members', [
            'specialization' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'position',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('team_members', 'specialization');
    }
}
