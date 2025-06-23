<?php

namespace App\Model;

use Core\Library\ModelMain;

class EspecialidadeModel extends ModelMain
{
    protected $table = 'especialidades';

    public $validationRules = [
        "nome" => [
            "label" => "Nome da Especialidade",
            "rules" => "obrigatorio|min:3"
        ],
    ];
}