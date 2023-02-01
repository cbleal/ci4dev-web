<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewTableGroups extends Migration
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
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '240',
            ],           
            'view' => [
                'type' => 'BOOLEAN',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
        ]);

        # add primary key
        $this->forge->addKey('id', true);

        # add unique key
        $this->forge->addUniqueKey('name');

        # create table
        $this->forge->createTable('grupos');
    }

    public function down()
    {
        # drop table
        $this->forge->dropTable('grupos');
    }
}
