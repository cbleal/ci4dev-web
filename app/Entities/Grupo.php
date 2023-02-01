<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Grupo extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function viewSituation()
    {
        # grupo excluido
        if ($this->deleted_at != null) {

            $icon = '<span class="text-white">Excluído</span>&nbsp;<i class="fa fa-undo"></i>&nbsp;Desfazer';

            $situation = anchor("grupo/restoreGrupo/$this->id", $icon, ['class' => 'btn btn-outline-success btn-sm'] );
            
            return $situation;
        }

        # exibir grupo
        if ($this->view == true) {
            return '<i class="fa fa-eye text-secondary"></i>&nbsp;Exibir grupo';
        }

        # não exibir grupo
        if ($this->view == false) {
            return '<i class="fa fa-eye-slash text-danger"></i>&nbsp;Não exibir grupo';
        }

    }
}
