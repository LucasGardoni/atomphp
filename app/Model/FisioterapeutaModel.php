<?php

namespace App\Model;

use Core\Library\ModelMain;


class FisioterapeutaModel extends ModelMain
{
    protected $table = 'fisioterapeutas';
    protected $pk_table = 'id';

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome Completo',
            "rules" => 'obrigatorio|minimo:3|maximo:255'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'obrigatorio|maximo:14'
        ],
        "crefito" => [
            "label" => 'CREFITO',
            "rules" => 'obrigatorio|maximo:20'
        ],
       
        "telefone" => [
            "label" => 'Telefone',
            "rules" => 'maximo:20'
        ],
        "email" => [
            "label" => 'E-mail',
            "rules" => 'email|maximo:150'
        ],
        "status" => [
            "label" => "Status",
            "rules" => "obrigatorio|int"
        ]
    ];

    // ===================================================================
    // ==== NOVOS MÉTODOS ADICIONADOS PARA GERENCIAR ESPECIALIDADES ====
    // ===================================================================

    /**
     * Busca os IDs de todas as especialidades de um fisioterapeuta.
     *
     * @param int $fisioterapeuta_id O ID do fisioterapeuta.
     * @return array Um array simples com os IDs das especialidades, ex: [1, 5, 8].
     */
    public function getEspecialidades(int $fisioterapeuta_id): array
    {
        $resultados = $this->db->table('fisioterapeuta_especialidades')
                               ->where('fisioterapeuta_id', $fisioterapeuta_id)
                               ->findAll();
        
        // Retorna apenas a coluna 'especialidade_id' dos resultados
        return array_column($resultados, 'especialidade_id');
    }

    /**
     * Salva as especialidades para um fisioterapeuta na tabela de ligação.
     * A lógica é: apagar todas as associações antigas e inserir as novas.
     *
     * @param int $fisioterapeuta_id O ID do fisioterapeuta.
     * @param array $especialidades_ids Um array com os IDs das especialidades selecionadas.
     * @return bool Retorna true em caso de sucesso.
     */
    public function salvarEspecialidades(int $fisioterapeuta_id, array $especialidades_ids = []): bool
    {
        // 1. Apaga as associações antigas com uma query pura.
        // Assumindo que seu Database.php tem um método 'query' para SQL puro.
        $sql = "DELETE FROM fisioterapeuta_especialidades WHERE fisioterapeuta_id = ?";
        $this->db->query($sql, [$fisioterapeuta_id]);

        // 2. Se nenhuma nova especialidade foi enviada, terminamos.
        if (empty($especialidades_ids)) {
            return true;
        }

        // 3. Loop para inserir as novas associações com o objeto $this->db "limpo".
        foreach ($especialidades_ids as $especialidade_id) {
            $dadosParaInserir = [
                'fisioterapeuta_id' => $fisioterapeuta_id,
                'especialidade_id' => (int) $especialidade_id
            ];
            
            if (!$this->db->table('fisioterapeuta_especialidades')->insert($dadosParaInserir, false)) {
                return false;
            }
        }

        return true;
    }
    

    public function getByCrefito(string $crefito): ?array
    {
        return $this->db->where('crefito', $crefito)->first();
    }
    
    public function listaFisioterapeutas(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Retorna todos os fisioterapeutas ATIVOS.
     */
    public function listaFisioterapeutasAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->where("fisioterapeutas.status", 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    /**
     * Retorna todos os fisioterapeutas INATIVOS.
     */
    public function listaFisioterapeutasInativos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->select("fisioterapeutas.*")
                       ->where("fisioterapeutas.status", 0)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }


}