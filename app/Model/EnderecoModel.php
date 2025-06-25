<?php

namespace App\Model;

use Core\Library\ModelMain;

class EnderecoModel extends ModelMain
{
    protected $table = 'enderecos';

    /**
     * @var array 
     */
    public $validationRules = [
        "cep" => ["label" => "CEP", "rules" => "required"],
        "logradouro" => ["label" => "Logradouro", "rules" => "required"],
        "numero" => ["label" => "Número", "rules" => "required"],
        "bairro" => ["label" => "Bairro", "rules" => "required"],
        "cidade" => ["label" => "Cidade", "rules" => "required"],
        "uf" => ["label" => "UF", "rules" => "required|max:2"],
    ];
}
