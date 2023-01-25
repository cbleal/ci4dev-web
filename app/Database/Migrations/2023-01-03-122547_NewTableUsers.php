<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class NewTableUsers extends Migration
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
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '240',               
            ],
            'reset_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '240',
                'null' => true,
                'default' => null,
            ],
            'reset_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null,
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => '240',
                'null' => true,
                'default' => null,
            ],
            'active' => [
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
        $this->forge->addUniqueKey('email');

        # create table
        $this->forge->createTable('users');
    }

    public function down()
    {
        # drop table
        $this->forge->dropTable('users');
    }
}
