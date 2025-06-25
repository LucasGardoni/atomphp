<?php

namespace App\Model;

use Core\Library\ModelMain;

class EspecialidadeModel extends ModelMain
{
    protected $table    = 'especialidades';
    protected $pk_table = 'id';
    protected $fillable = ['nome', 'descricao'];

    public function getByIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        return $this->db
            ->whereIn('id', $ids)
            ->orderBy('nome', 'ASC')
            ->findAll() ?: [];
    }
}
