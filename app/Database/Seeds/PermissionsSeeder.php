<?php

namespace App\Database\Seeds;

use App\Models\PermissionsModel;
use CodeIgniter\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissionsModel = new PermissionsModel();

        $permissions = [
            [
                'name' => 'list-users',
            ],
            [
                'name' => 'create-users',
            ],
            [
                'name' => 'edit-users',
            ],
            [
                'name' => 'delete-users',
            ],
        ];

        foreach($permissions as $permission) {
            $permissionsModel->protect(false)->insert($permission);
        }

        echo 'Permissões salvas com sucesso.';
    }
}
