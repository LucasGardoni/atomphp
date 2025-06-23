<?php

namespace App\Model;

use Core\Library\ModelMain;

class EnderecoModel extends ModelMain
{
    protected $table = 'enderecos';

    public $validationRules = [
        "cep" => ["label" => "CEP", "rules" => "obrigatorio"],
        "logradouro" => ["label" => "Logradouro", "rules" => "obrigatorio"],
        "numero" => ["label" => "Número", "rules" => "obrigatorio"],
        "bairro" => ["label" => "Bairro", "rules" => "obrigatorio"],
        "cidade" => ["label" => "Cidade", "rules" => "obrigatorio"],
        "uf" => ["label" => "UF", "rules" => "obrigatorio|max:2"],
    ];
}