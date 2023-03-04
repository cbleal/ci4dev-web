<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewTableGroupsUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'grupo_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
                  
        ]);

        # add primary key
        $this->forge->addKey('id', true);

        # add foreign key
        $this->forge->addForeignKey('grupo_id', 'grupos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

        # create table
        $this->forge->createTable('grupos_users');
    }

    public function down()
    {
        # drop table
        $this->forge->dropTable('grupos_users');
    }
}
