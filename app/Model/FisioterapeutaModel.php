<?php

namespace App\Model;

use Core\Library\ModelMain;

class FisioterapeutaModel extends ModelMain
{
    protected $table = 'fisioterapeutas';
    protected $pk_table = 'id';

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome Completo',
            "rules" => 'obrigatorio|minimo:3|maximo:255'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'obrigatorio|maximo:14'
        ],
        "crefito" => [
            "label" => 'CREFITO',
            "rules" => 'obrigatorio|maximo:20'
        ],
        "especialidade" => [
            "label" => 'Especialidade',
            "rules" => 'maximo:100'
        ],
        "telefone" => [
            "label" => 'Telefone',
            "rules" => 'maximo:20'
        ],
        "email" => [
            "label" => 'E-mail',
            "rules" => 'email|maximo:150'
        ],
        "status" => [
            "label" => "Status",
            "rules" => "obrigatorio|int"
        ]
    ];

    /**
     * Retorna TODOS os fisioterapeutas.
     */
    public function listaFisioterapeutas(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Retorna todos os fisioterapeutas ATIVOS.
     */
    public function listaFisioterapeutasAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->where("fisioterapeutas.status", 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Retorna todos os fisioterapeutas INATIVOS.
     */
    public function listaFisioterapeutasInativos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->where("fisioterapeutas.status", 0)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}