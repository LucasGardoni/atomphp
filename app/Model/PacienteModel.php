<?php

namespace App\Model;

use Core\Library\ModelMain;

class PacienteModel extends ModelMain
{
    protected $table = 'pacientes';
    protected $pk_table = 'id';

    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'telefone',
        'historico_clinico',
        'status',
        'endereco_id',
        'plano_saude_id'
    ];
    
    /**
     * @var array REGRAS DE VALIDAÇÃO CORRIGIDAS PARA O INGLÊS
     */
    public $validationRules = [
        "nome"              => ["label" => 'Nome Completo',     "rules" => 'required|min:3|max:255'],
        "cpf"               => ["label" => 'CPF',               "rules" => 'required|max:14'],
        "data_nascimento"   => ["label" => 'Data de Nascimento', "rules" => 'permit_empty|date'],
        "telefone"          => ["label" => 'Telefone',          "rules" => 'required|max:20'],
        "status"            => ["label" => 'Status',            "rules" => 'required|integer'],
        "plano_saude_id"    => ["label" => 'Plano de Saúde',     "rules" => 'permit_empty|integer'],
        "historico_clinico" => ["label" => 'Histórico Clínico',  "rules" => 'permit_empty|max:1000'],
    ];

    /**
     * Retorna todos os pacientes ativos, incluindo dados do endereço.
     * Ajustei a query para buscar o endereço junto (JOIN).
     */
    public function listaPacientesAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        // A query agora usa JOIN para trazer informações do endereço para a lista.
        return $this->db->select("pacientes.*, enderecos.logradouro, enderecos.cidade, enderecos.uf")
                       ->join('enderecos', 'enderecos.id = pacientes.endereco_id', 'left')
                       ->where("pacientes.status", 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Retorna todos os pacientes, incluindo dados do endereço.
     */
    public function listaPacientes(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("pacientes.*, enderecos.logradouro, enderecos.cidade, enderecos.uf")
                       ->join('enderecos', 'enderecos.id = pacientes.endereco_id', 'left')
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
    
    /**
     * Retorna todos os pacientes inativos, incluindo dados do endereço.
     */
    public function listaPacientesInativos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("pacientes.*, enderecos.logradouro, enderecos.cidade, enderecos.uf")
                       ->join('enderecos', 'enderecos.id = pacientes.endereco_id', 'left')
                       ->where("pacientes.status", 0)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}
