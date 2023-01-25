<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CentralSeeder extends Seeder
{
    public function run()
    {
        // rodar o seeder
        $this->call('ColorSeeder');
    }
}
