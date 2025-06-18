<?php

namespace App\Model;

use Core\Library\ModelMain;

class PacienteModel extends ModelMain
{
    protected $table = 'pacientes';
    protected $pk_table = 'id';

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome Completo',
            "rules" => 'obrigatorio|minimo:3|maximo:255'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'maximo:14'
        ],
        "data_nascimento"  => [
            "label" => 'Data de Nascimento',
            "rules" => 'data'
        ],
        "telefone" => [
            "label" => 'Telefone',
            "rules" => 'maximo:20'
        ],
        "plano_saude" => [
            "label" => 'Plano de Saúde',
            "rules" => 'maximo:100'
        ],
        "status" => [
            "label" => "Status",
            "rules" => "obrigatorio|int"
        ]
    ];

    /**
     * Retorna todos os pacientes ativos ordenados.
     */
    public function listaPacientesAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        // Corrigido para passar coluna e direção separadamente ao orderBy, evitando erro de sintaxe SQL
        return $this->db->select("pacientes.*")
                       ->where("pacientes.status", 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }


    public function listaPacientes(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("pacientes.*")
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    public function listaPacientesInativos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("pacientes.*")
                       ->where("pacientes.status", 0) // A única mudança é o valor do status para 0
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}