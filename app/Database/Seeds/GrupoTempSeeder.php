<?php

namespace App\Database\Seeds;

use App\Models\GrupoModel;
use CodeIgniter\Database\Seeder;

class GrupoTempSeeder extends Seeder
{
    public function run()
    {
        // cria objeto grupos
        $grupoModel = new GrupoModel();

        // cria um array de arrays com dados a serem inseridos na tabela de grupos
        $grupos = [
            [
                'name' => 'Administrador',
                'description' => 'Grupo com acesso total ao sistema',
                'view' => false,
            ],
            [
                'name' => 'Clientes',
                'description' => 'Grupo destinado para atribuição de clientes, onde os mesmos pderão logar no sistema e verificar suas ordens de serviço.',
                'view' => false,
            ],
            [
                'name' => 'Atendentes',
                'description' => 'Grupo que realiza o atendimento aos clientes',
                'view' => false,
            ],
        ];

        // percorrer o array para inserir os dados na tabela
        foreach ($grupos as $grupo) {

            $grupoModel->insert($grupo);
            
        }

        // mensagem de sucesso
        echo 'Grupos inseridos com sucesso';
    }
}
