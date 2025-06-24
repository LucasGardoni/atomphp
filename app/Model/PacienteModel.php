<?php

namespace App\Model;

use Core\Library\ModelMain;

class PacienteModel extends ModelMain
{
    // O nome da sua tabela, como você definiu.
    protected $table = 'pacientes'; 
    protected $pk_table = 'id';

    /**
     * @var array Define os campos que podem ser preenchidos em massa.
     * Isso é essencial para que o controller consiga salvar os dados.
     * Adicionei todos os campos do seu formulário + a chave estrangeira.
     */
    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'telefone',
        'plano_saude',
        'historico_clinico',
        'status',
        'endereco_id' // O campo mais importante para a correção.
    ];
    
    // Suas regras de validação originais. Estão corretas.
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
