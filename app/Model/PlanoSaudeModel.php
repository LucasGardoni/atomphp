<?php
namespace App\Model;

use Core\Library\ModelMain;

class PlanoSaudeModel extends ModelMain
{
    // CORRIGIDO: O nome da tabela é no plural, conforme seu banco de dados.
    protected $table = 'planos_saude'; 
    protected $pk_table = 'id';

    /**
     * @var array CORRIGIDO: Usa 'nome_plano' em vez de 'nome'.
     */
    protected $fillable = ['nome_plano', 'status'];

    /**
     * Busca todos os planos de saúde que estão ATIVOS.
     *
     * @param string $orderBy
     * @param string $direction
     * @return array|null
     */
    public function findAllAtivos(string $orderBy = 'nome_plano', string $direction = 'ASC'): ?array
    {
        // CORRIGIDO: Ordena por 'nome_plano'.
        return $this->db->table($this->table)
                       ->where('status', 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Método genérico para buscar todos os registros.
     */
    public function findAll(string $orderBy = 'nome_plano', string $direction = 'ASC'): ?array
    {
        // CORRIGIDO: Ordena por 'nome_plano'.
        return $this->db->table($this->table)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}
