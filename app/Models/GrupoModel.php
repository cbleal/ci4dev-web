<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoModel extends Model
{
    protected $table            = 'grupos';   
    protected $returnType       = 'App\Entities\Grupo';  // object, array
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'name',
        'description',
        'view',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required|min_length[3]|max_length[140]|is_unique[users.name,id,{id}]',
        'description' => 'required|min_length[5]|max_length[240]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Campo Nome é de preenchimento obrigatório.',
            'min_length' => 'Campo Nome deve conter no mínimo 3 caracteres',
            'max_length' => 'Campo Nome deve conter no máximo 128 caracteres',
        ],       
    ];
  
}
