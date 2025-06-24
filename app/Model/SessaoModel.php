<?php

namespace App\Model;

use Core\Library\ModelMain;

class SessaoModel extends ModelMain
{
    protected $table    = 'sessoes';
    protected $pk_table = 'id';

    /**
     * Campos permitidos para insert/update
     */
    protected $fillable = [
        'paciente_id',
        'fisioterapeuta_id',
        'data_hora_agendamento',
        'tipo_tratamento',
        'status_sessao',
        'recorrencia_id'
    ];

    /**
     * Regras de validação para os campos de sessão
     */
    public $validationRules = [
        'paciente_id'             => ['label' => 'Paciente',                'rules' => 'required|int'],
        'fisioterapeuta_id'       => ['label' => 'Fisioterapeuta',          'rules' => 'required|int'],
        'data_hora_agendamento'   => ['label' => 'Data e Hora',             'rules' => 'required|datetime'],
        'tipo_tratamento'         => ['label' => 'Tipo de Tratamento',      'rules' => 'required|int'],
        'status_sessao'           => ['label' => 'Status da Sessão',        'rules' => 'required'],
        // 'recorrencia_id' é gerado internamente e não precisa de validação
    ];

    /**
     * Retorna uma lista detalhada das sessões, com nomes do paciente e fisioterapeuta.
     */
    public function listaSessoes(string $orderBy = 'sessoes.data_hora_agendamento', string $direction = 'DESC'): ?array
    {
        return $this->db
            ->select("
                sessoes.*, 
                pacientes.nome AS nome_paciente, 
                fisioterapeutas.nome AS nome_fisioterapeuta
            ")
            ->join('pacientes', 'pacientes.id = sessoes.paciente_id', 'LEFT')
            ->join('fisioterapeutas', 'fisioterapeutas.id = sessoes.fisioterapeuta_id', 'LEFT')
            ->orderBy($orderBy, $direction)
            ->findAll();
    }
}
