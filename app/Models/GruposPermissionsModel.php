<?php

namespace App\Models;

use CodeIgniter\Model;

class GruposPermissionsModel extends Model
{
    protected $table            = 'grupos_permissions';
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'grupo_id',
        'permission_id',
    ];

    public function getPermissionsOfGrupo(int $grupo_id, int $qtd_paginator)
    {
        $atributos = [
            'grupos_permissions.id AS grupo_permission_id',
            'grupos.id AS grupo_id',
            'permissions.id AS permission_id',
            'permissions.name'
        ];

        return $this->select($atributos)
                    ->join('grupos', 'grupos.id = grupos_permissions.grupo_id')
                    ->join('permissions', 'permissions.id = grupos_permissions.permission_id')
                    ->where('grupos_permissions.grupo_id', $grupo_id)
                    // ->groupBy('permissions.name')
                    ->paginate($qtd_paginator);
    }
  
}
