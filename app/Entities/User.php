<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function viewSituation()
    {
        # usuario excluido
        if ($this->deleted_at != null) {

            $icon = '<span class="text-white">Excluído</span>&nbsp;<i class="fa fa-undo"></i>&nbsp;Desfazer';

            $situation = anchor("users/restoreUser/$this->id", $icon, ['class' => 'btn btn-outline-success btn-sm'] );
            
            return $situation;
        }

        # usuario ativo
        if ($this->active == true) {
            return '<i class="fa fa-unlock text-success"></i>&nbsp;Ativo';
        }

        # usuario inativo
        if ($this->active == false) {
            return '<i class="fa fa-lock text-warning"></i>&nbsp;Inativo';
        }

    }
}
