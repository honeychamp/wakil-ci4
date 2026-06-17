<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTeamAndCasesTables extends Migration
{
    public function up()
    {
        // 1. Add password to team_members
        $this->forge->addColumn('team_members', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'email'
            ]
        ]);

        // 2. Add lawyer_id to cases referencing team_members.id
        $this->forge->addColumn('cases', [
            'lawyer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'client_id'
            ]
        ]);

        $this->db->query('ALTER TABLE `cases` ADD CONSTRAINT `fk_cases_lawyer_id` FOREIGN KEY (`lawyer_id`) REFERENCES `team_members` (`id`) ON DELETE SET NULL ON UPDATE CASCADE');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `cases` DROP FOREIGN KEY `fk_cases_lawyer_id`');
        $this->forge->dropColumn('cases', 'lawyer_id');
        $this->forge->dropColumn('team_members', 'password');
    }
}
