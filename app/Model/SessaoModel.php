<?php

namespace App\Model;

use Core\Library\ModelMain;

class SessaoModel extends ModelMain
{
    protected $table = 'sessoes';

    public $validationRules = [
        "paciente_id" => [ "label" => "Paciente", "rules" => "obrigatorio|int" ],
        "fisioterapeuta_id" => [ "label" => "Fisioterapeuta", "rules" => "obrigatorio|int" ],
        "data_hora_agendamento" => [ "label" => "Data e Hora", "rules" => "obrigatorio" ],
        "status_sessao" => [ "label" => "Status", "rules" => "obrigatorio" ],
    ];

    /**
     * Retorna uma lista detalhada das sessões, com nomes do paciente e fisioterapeuta.
     * (Versão corrigida sem o método from() e sem apelidos de tabela)
     */
    public function listaSessoes(string $orderBy = 'sessoes.data_hora_agendamento', string $direction = 'DESC'): ?array
    {
        // O construtor do ModelMain já define a tabela principal como 'sessoes' com $this->db->table($this->table).
        // Agora construímos a query a partir daí.
        return $this->db->select(
                            "sessoes.*, 
                             pacientes.nome as nome_paciente, 
                             fisioterapeutas.nome as nome_fisioterapeuta"
                        )
                       ->join("pacientes", "pacientes.id = sessoes.paciente_id", "LEFT")
                       ->join("fisioterapeutas", "fisioterapeutas.id = sessoes.fisioterapeuta_id", "LEFT")
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}