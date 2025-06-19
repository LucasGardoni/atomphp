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

    /**
     * Busca um registro de evolução pelo ID da sessão.
     * Como só existe uma evolução por sessão, este método é mais útil que getById().
     *
     * @param int $sessao_id
     * @return array|null
     */
    public function getBySessaoId(int $sessao_id): ?array
    {
        return $this->db->where("sessao_id", $sessao_id)->first();
    }
}