<?php

namespace App\Model;

use Core\Library\ModelMain;

class PlanoSaudeModel extends ModelMain
{

    protected $table = 'planos_saude';
    protected $pk_table = 'id';

    protected $fillable = ['nome_plano', 'status'];

    public function findAllAtivos(string $orderBy = 'nome_plano', string $direction = 'ASC'): ?array
    {
        return $this->db->table($this->table)
            ->where('status', 1)
            ->orderBy($orderBy, $direction)
            ->findAll();
    }

    public function findAll(string $orderBy = 'nome_plano', string $direction = 'ASC'): ?array
    {
        return $this->db->table($this->table)
            ->orderBy($orderBy, $direction)
            ->findAll();
    }
}
