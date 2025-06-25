<?php

namespace App\Model;

use Core\Library\ModelMain;

class FichaEvolucaoModel extends ModelMain
{
    protected $table = 'fichas_evolucao';
    protected $pk_table = 'id';

    public $validationRules = [
        "sessao_id" => [
            "label" => "ID da Sessão",
            "rules" => "obrigatorio|int"
        ],
        "descricao_evolucao" => [
            "label" => "Descrição da Evolução",
            "rules" => "obrigatorio"
        ],
    ];
    public function getBySessaoId(int $sessao_id): ?array
    {
        return $this->db->where("sessao_id", $sessao_id)->first();
    }
}
