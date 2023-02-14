<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewTablePermissions extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '150',
            ],           
        ]);

        # add primary key
        $this->forge->addKey('id', true);

        # add unique key
        $this->forge->addUniqueKey('name');

        # create table
        $this->forge->createTable('permissions');
    }

    public function down()
    {
        # drop table
        $this->forge->dropTable('permissions');
    }
}
