<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class UserFakerSeeder extends Seeder
{
    public function run()
    {
        # obj model
        $userModel = new UserModel();

        # obj faker
        $faker = \Faker\Factory::create();

        # qtde registros a serem gerados
        $registers = 5000;

        # array que receberá os registros fakers
        $userPush = [];

        # laço para geração dos registros
        for ($i=0; $i < $registers; $i++) { 
            # add in array
            array_push($userPush, [
                'name'  => $faker->unique()->name,
                'email' => $faker->unique()->name,
                'password_hash' => '123456' . $i,
                'active' => $faker->numberBetween(0, 1),
            ]);
        }

        // print '<pre>';
        // print_r($userPush);
        // exit;

        # inserir na tabela (pula validação, tira a proteção, insere em lote)
        $userModel->skipValidation(true)
                  ->protect(false)
                  ->insertBatch($userPush);

        print "$registers usuários criados com sucesso.";
    }
}
