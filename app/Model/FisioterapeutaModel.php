<?php

namespace App\Model;

use Core\Library\ModelMain;

class FisioterapeutaModel extends ModelMain
{
    protected $table = 'fisioterapeutas';
    protected $pk_table = 'id';

    /**
     * @var array Define os campos que podem ser preenchidos em massa.
     */
    protected $fillable = [
        'nome',
        'cpf',
        'crefito',
        'telefone',
        'email',
        'status'
    ];

    /**
     * @var array Regras de validação.
     */
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

    /**
     * Salva as especialidades para um fisioterapeuta.
     */
    public function salvarEspecialidades(int $fisioterapeuta_id, array $especialidades_ids = []): void
    {
        $this->db->table('fisioterapeuta_especialidades')->where('fisioterapeuta_id', $fisioterapeuta_id)->delete();

        if (!empty($especialidades_ids)) {
            foreach ($especialidades_ids as $especialidade_id) {
                $dadosParaInserir = [
                    'fisioterapeuta_id' => $fisioterapeuta_id,
                    'especialidade_id' => (int) $especialidade_id
                ];
                
                // CORRIGIDO: Primeiro define a tabela com table() e depois insere os dados.
                $this->db->table('fisioterapeuta_especialidades')->insert($dadosParaInserir);
            }
        }
    }

    /**
     * Busca os IDs de todas as especialidades de um fisioterapeuta.
     */
    public function getEspecialidadesIds(int $fisioterapeuta_id): array
    {
        $resultados = $this->db->select('especialidade_id')
                               ->table('fisioterapeuta_especialidades')
                               ->where('fisioterapeuta_id', $fisioterapeuta_id)
                               ->findAll();
        
        if (!$resultados) {
            return [];
        }
        
        return array_column($resultados, 'especialidade_id');
    }

    public function getByCrefito(string $crefito): ?array
    {
        return $this->db->table($this->table)->where('crefito', $crefito)->find();
    }
    
    public function listaFisioterapeutas(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->table($this->table)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    public function listaFisioterapeutasAtivos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->table($this->table)
                       ->where("status", 1)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }

    public function listaFisioterapeutasInativos(string $orderBy = 'nome', string $direction = 'ASC'): ?array
    {
        return $this->db->table($this->table)
                       ->where("status", 0)
                       ->orderBy($orderBy, $direction)
                       ->findAll();
    }
}
