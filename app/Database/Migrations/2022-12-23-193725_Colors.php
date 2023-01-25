<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Colors extends Migration
{
    public function up()
    {
        // cria os campos da tabela
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '50'
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => '150'
            ],
        ]);

        // atribui o auto incremento ao campo id da tabela
        $this->forge->addKey('id', true);
        // cria a tabela
        $this->forge->createTable('colors');
    }

    public function down()
    {
        // apaga a tabela no caso do rollback
        $this->forge->dropTable('colors');
    }
}
