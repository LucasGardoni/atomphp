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
            "rules" => 'required|min:3|max:255'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'max:14'
        ],
        "data_nascimento"  => [
            "label" => 'Data de Nascimento',
            "rules" => 'date'
        ],
        "telefone" => [
            "label" => 'Telefone',
            "rules" => 'max:20'
        ],
        "plano_saude" => [
            "label" => 'Plano de Saúde',
            "rules" => 'max:100'
        ],
        "status" => [
            "label" => "Status",
            "rules" => "required|int"
        ]
    ];

    /**
     * Retorna todos os pacientes ativos ordenados.
     */
    public function listaPacientesAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
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