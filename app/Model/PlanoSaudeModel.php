<?php

namespace App\Model;

use Core\Library\ModelMain;

class PlanoSaudeModel extends ModelMain
{
    protected $table = 'planos_saude';

    public $validationRules = [
        "nome_plano" => [
            "label" => "Nome do Plano",
            "rules" => "obrigatorio|min:3"
        ],
    ];
}