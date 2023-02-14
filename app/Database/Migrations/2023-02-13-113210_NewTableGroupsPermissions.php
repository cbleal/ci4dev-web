<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewTableGroupsPermissions extends Migration
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
            'permission_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
                  
        ]);

        # add primary key
        $this->forge->addKey('id', true);

        # add foreign key
        $this->forge->addForeignKey('grupo_id', 'grupos', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('permission_id', 'permissions', 'id', 'CASCADE', 'CASCADE');

        # create table
        $this->forge->createTable('grupos_permissions');
    }

    public function down()
    {
        # drop table
        $this->forge->dropTable('grupos_permissions');
    }
}
