<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionsModel extends Model
{
    protected $table            = 'permissions';   
    protected $returnType       = 'object';    
    protected $allowedFields    = ['name'];  
}
