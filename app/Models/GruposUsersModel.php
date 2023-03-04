<?php

namespace App\Models;
use CodeIgniter\Model;

class GruposUsersModel extends Model
{
    protected $table            = 'grupos_users';  
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'grupo_id',
        'user_id',
    ];

    public function getGruposOfUser(int $user_id, int $qtd_paginator)
    {
        $atributos = [
            'grupos_users.id AS principal_id',
            'grupos.id AS grupo_id',
            'grupos.name',
            'grupos.description',
        ];

        return $this->select($atributos)
                    ->join('grupos', 'grupos.id = grupos_users.grupo_id')
                    ->join('users', 'users.id = grupos_users.user_id')
                    ->where('grupos_users.user_id', $user_id)
                    //->groupBy('grupos.name')
                    ->paginate($qtd_paginator);
    }
}
