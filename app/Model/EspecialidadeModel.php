<?php

namespace App\Model;

use Core\Library\ModelMain;

class EspecialidadeModel extends ModelMain
{
    protected $table = 'especialidades'; // Verifique se o nome da tabela está correto
    protected $pk_table = 'id';

    /**
     * @var array Define os campos que podem ser preenchidos.
     */
    protected $fillable = [
        'nome', // Supondo que a tabela tenha uma coluna 'nome' ou 'descricao'
        'descricao',
        'status'
    ];

    /**
     * @var array Regras de validação para o formulário de especialidade.
     */
    public $validationRules = [
        "nome"  => [
            "label" => 'Nome da Especialidade',
            "rules" => 'obrigatorio|minimo:3|maximo:255'
        ]
    ];

    /**
     * Busca todos os registros da tabela de especialidades.
     * Este é o método que estava faltando e que corrige o erro fatal.
     *
     * @param string $orderBy Coluna para ordenação.
     * @param string $direction Direção da ordenação (ASC ou DESC).
     * @return array|null
     */
    public function findAll(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        // CORRIGIDO: Usa o método table() em vez do método inexistente from()
        return $this->db->table($this->table)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}
