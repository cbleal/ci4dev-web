<?php

namespace App\Database\Seeds;

use App\Models\ColorModel;
use CodeIgniter\Database\Seeder;

class ColorSeeder extends Seeder
{
    public function run()
    {
        // cria objeto
        $colorModel = new ColorModel();

        // cria um array
        $colors = [
            [
                'name' => 'Verde',
                'description' => 'Descrição da Cor'
            ],
            [
                'name' => 'Amarelo',
                'description' => 'Descrição da Cor'
            ],
            [
                'name' => 'Azul',
                'description' => 'Descrição da Cor'
            ],
            [
                'name' => 'Branco',
                'description' => 'Descrição da Cor'
            ],
            [
                'name' => 'Preto',
                'description' => 'Descrição da Cor'
            ],
            [
                'name' => 'Marrom',
                'description' => 'Descrição da Cor'
            ],
        ];

        // percorrer o array e inserir na tabela
        foreach ($colors as $color) {
            $colorModel->insert($color);
        }

        echo 'Cores inseridas com sucesso!';

    }
}
