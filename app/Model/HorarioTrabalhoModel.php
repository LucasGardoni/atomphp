<?php

namespace App\Model;

use Core\Library\ModelMain;

class HorarioTrabalhoModel extends ModelMain
{
    protected $table = 'horarios_trabalho';

    public $validationRules = [
        "fisioterapeuta_id" => ["label" => "Fisioterapeuta", "rules" => "obrigatorio|int"],
        "dia_semana" => ["label" => "Dia da Semana", "rules" => "obrigatorio|int"],
        "hora_inicio" => ["label" => "Hora de Início", "rules" => "obrigatorio"],
        "hora_fim" => ["label" => "Hora de Fim", "rules" => "obrigatorio"],
    ];

    /**
     * Lista todos os horários de um fisioterapeuta específico, ordenados.
     */
    public function listaPorFisioterapeuta(int $fisioterapeuta_id)
    {
        return $this->db->where('fisioterapeuta_id', $fisioterapeuta_id)
                       ->orderBy('dia_semana, hora_inicio')
                       ->findAll();
    }
}