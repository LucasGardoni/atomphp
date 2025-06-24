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
     * Salva as especialidades para um fisioterapeuta na tabela de ligação.
     * CORRIGIDO: Isola a operação de DELETE para não interferir com os INSERTs.
     *
     * @param int $fisioterapeuta_id O ID do fisioterapeuta.
     * @param array $especialidades_ids Um array com os IDs das especialidades selecionadas.
     * @return void
     */
    public function salvarEspecialidades(int $fisioterapeuta_id, array $especialidades_ids = []): void
    {

        $dbDelete = new \Core\Library\Database(
            $_ENV['DB_CONNECTION'], $_ENV['DB_HOST'], $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']
        );
        $dbDelete->table('fisioterapeuta_especialidades')
                 ->where('fisioterapeuta_id', $fisioterapeuta_id)
                 ->delete();

        // 2. Se não houver novas especialidades para adicionar, a tarefa está concluída.
        if (empty($especialidades_ids)) {
            return;
        }

        // 3. Usa o objeto $this->db (que está "limpo") para fazer os INSERTS em um loop.
        foreach ($especialidades_ids as $especialidade_id) {
            $dadosParaInserir = [
                'fisioterapeuta_id' => $fisioterapeuta_id,
                'especialidade_id' => (int) $especialidade_id
            ];
            
            // Re-encadeamos a partir de ->table() para garantir que cada insert seja independente.
            // O segundo parâmetro 'false' pula a validação, que não é necessária para esta tabela.
            $this->db->table('fisioterapeuta_especialidades')->insert($dadosParaInserir, false);
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


     public function getEspecialidadesCompletas(int $fisioterapeuta_id): ?array
    {
        return $this->db->select('e.id, e.descricao')
                       ->from('fisioterapeuta_especialidades AS fe')
                       ->join('especialidades AS e', 'fe.especialidade_id = e.id', 'LEFT')
                       ->where('fe.fisioterapeuta_id', $fisioterapeuta_id)
                       ->findAll();
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


     public function getEspecialidadeIds(int $fisioId): array
    {
        // Ajuste o nome da tabela se for diferente
        $rows = $this->db
                     ->table('fisioterapeuta_especialidades')
                     ->select('especialidade_id')
                     ->where('fisioterapeuta_id', $fisioId)
                     ->findAll() ?: [];

        return array_column($rows, 'especialidade_id');
    }


    public function verificarVinculoSessaoAgendada(int $fisioterapeuta_id): bool
    {
        $sessaoModel = new \App\Model\SessaoModel();
        $resultado = $sessaoModel->db
            ->table('sessoes') // Define a tabela explicitamente
            ->select('COUNT(*) as total')
            ->where('fisioterapeuta_id', $fisioterapeuta_id)
            ->where('status_sessao', 'Agendada')
            ->first();
        return ($resultado && $resultado['total'] > 0);
    }

    public function possuiSessoesVinculadas(int $fisioterapeuta_id): bool
    {
        // Instancia o model de Sessões para fazer a consulta na tabela correta
        $sessaoModel = new \App\Model\SessaoModel();
        
        // Conta quantas sessões existem para este fisioterapeuta
        $resultado = $sessaoModel->db
            ->table('sessoes') // Garante que estamos olhando para a tabela 'sessoes'
            ->select('COUNT(*) as total')
            ->where('fisioterapeuta_id', $fisioterapeuta_id)
            ->first();

        // Se o total for maior que 0, significa que há um vínculo
        return ($resultado && $resultado['total'] > 0);
    }
}
