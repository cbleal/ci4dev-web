<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnActiveColors extends Migration
{
    public function up()
    {
        $this->forge->addColumn('colors', [
            'active' => [
                'type'    => 'BOOLEAN',
                'null'    => false,
                'default' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('colors', 'active');
    }
}
