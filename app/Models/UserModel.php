<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users'; 
    protected $returnType       = 'App\Entities\User';  // object, array
    protected $useSoftDeletes   = true;  
    protected $allowedFields    = [
        'name',
        'email',
        'password_hash',
        'reset_hash',
        'reset_expires_at',
        'image',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'                  => 'required|min_length[3]|max_length[150]',
        'email'                 => 'required|valid_email|min_length[3]|max_length[100]|is_unique[users.email,id,{id}]',
        'password'              => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Campo Nome é de preenchimento obrigatório.',
            'min_length' => 'Campo Nome deve conter no mínimo 3 caracteres',
            'max_length' => 'Campo Nome deve conter no máximo 128 caracteres',
        ],
        'email' => [
            'required'   => 'Campo Email é de preenchimento obrigatório.',
            'min_length' => 'Campo Email deve conter no mínimo 3 caracteres',
            'max_length' => 'Campo Email deve conter no máximo 128 caracteres',
            'is_unique'  => 'Desculpe. Este email já existe. Por favor escolha outro.',
        ],
        'password' => [
            'required'   => 'Campo Senha é de preenchimento obrigatório.',
            'min_length' => 'Campo Senha deve conter no mínimo 6 caracteres',
        ],
        'password_confirmation' => [
            'required_with' => 'Por favor confirme a senha.',
            'matches'       => 'As senhas precisam combinar.',
        ],
    ];

    // Callbacks
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            
            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);

        }

        return $data;
    }
    
}
