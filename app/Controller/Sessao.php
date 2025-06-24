<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\PacienteModel;
use App\Model\FisioterapeutaModel;
use App\Model\EspecialidadeModel;
use Core\Library\Validator;

class Sessao extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    public function index(): void
    {
        $aDados['titulo'] = 'Agenda de Sessões';
        $aDados['sessoes'] = $this->model->listaSessoes();
        $this->loadView("sistema/listaSessao", $aDados);
    }

    /**
     * Decide qual formulário carregar: 'novo' ou 'editar'.
     */
    public function form(string $action = 'insert', int $id = 0): void
    {
        $pacienteModel = new PacienteModel();
        $fisioterapeutaModel = new FisioterapeutaModel();
        
        $aDados['lista_pacientes'] = $pacienteModel->listaPacientesAtivos();
        $aDados['lista_fisioterapeutas'] = $fisioterapeutaModel->listaFisioterapeutasAtivos();
        $aDados['action'] = $action;

        if ($action === 'insert') {
            // Se for um novo agendamento, carrega a view com a busca de horários
            $aDados['titulo'] = 'Novo Agendamento';
            $this->loadView("sistema/formSessaoNovo", $aDados);

        } else { // Cobre 'update' e 'view'
            $sessao = $this->model->getById($id);
            if (!$sessao) {
                Session::set('msgError', 'Sessão não encontrada.');
                Redirect::page($this->controller);
                return;
            }
            $aDados['sessao'] = $sessao;
            $aDados['titulo'] = ($action === 'update') ? 'Editar Agendamento' : 'Visualizar Agendamento';
            
            // Se for uma edição/visualização, carrega a view mais simples
            $this->loadView("sistema/formSessaoEditar", $aDados);
        }
    }


 /**
 * GET /Sessao/getTratamentosPorFisioterapeuta?fisioterapeuta_id=X
 */

public function getEspecialidadesPorFisioterapeuta(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        try {
            $fisioId = isset($_GET['fisioterapeuta_id']) ? (int) $_GET['fisioterapeuta_id'] : 0;
            if ($fisioId < 1) {
                http_response_code(400);
                echo json_encode(['erro' => 'Fisioterapeuta inválido']);
                exit;
            }

            // Pega os IDs de especialidade
            $ids = (new FisioterapeutaModel())->getEspecialidadeIds($fisioId);

            $options = [
                ['id' => '', 'nome' => 'Avaliação Fisioterapêutica Inicial']
            ];

            if (!empty($ids)) {
                $lista = (new EspecialidadeModel())->getByIds($ids);
                foreach ($lista as $e) {
                    $options[] = [
                        'id'   => $e['id'],
                        'nome' => $e['nome'],   // usa o campo "nome" da sua tabela
                    ];
                }
            }

            echo json_encode($options);
            exit;
        } catch (\Throwable $e) {
            http_response_code(500);
            // Para debug: retorna a mensagem de exceção em JSON
            echo json_encode([
                'erro'  => 'Exception: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            exit;
        }
    }


    
    // O método getHorariosDisponiveis() permanece o mesmo que te enviei anteriormente
    public function getHorariosDisponiveis(): void
    {
        header('Content-Type: application/json');
        $fisioterapeuta_id = (int) ($_GET['fisioterapeuta_id'] ?? 0);
        $data = $_GET['data'] ?? null;
        $ignorar_sessao_id = (int) ($_GET['ignorar_id'] ?? 0);
        $duracao_sessao = 60;

        if (empty($fisioterapeuta_id) || empty($data)) {
            echo json_encode(['erro' => 'Parâmetros ausentes.']);
            return;
        }

        try {
            $data_selecionada = new \DateTime($data);
            $dia_semana = $data_selecionada->format('N');

            $horarioTrabalhoModel = new \App\Model\HorarioTrabalhoModel();
            $blocos_trabalho = $horarioTrabalhoModel->db
                ->where('fisioterapeuta_id', $fisioterapeuta_id)
                ->where('dia_semana', $dia_semana)
                ->findAll();
            
            if (empty($blocos_trabalho)) {
                echo json_encode([]);
                return;
            }

            $querySessoes = $this->model->db
                ->where('fisioterapeuta_id', $fisioterapeuta_id)
                ->where("DATE(data_hora_agendamento) = '{$data}'");
            
            if ($ignorar_sessao_id > 0) {
                $querySessoes->where("id !=", $ignorar_sessao_id);
            }
            
            $sessoes_agendadas = $querySessoes->findAll();
            
            $horarios_ocupados = [];
            foreach ($sessoes_agendadas as $sessao) {
                $horarios_ocupados[] = date('H:i', strtotime($sessao['data_hora_agendamento']));
            }

            $slots_disponiveis = [];
            foreach ($blocos_trabalho as $bloco) {
                $inicio = new \DateTime($data . ' ' . $bloco['hora_inicio']);
                $fim = new \DateTime($data . ' ' . $bloco['hora_fim']);
                
                while ($inicio < $fim) {
                    $slot_atual = $inicio->format('H:i');
                    if (!in_array($slot_atual, $horarios_ocupados)) {
                        $slots_disponiveis[] = $slot_atual;
                    }
                    $inicio->modify("+{$duracao_sessao} minutes");
                }
            }
            
            echo json_encode($slots_disponiveis);

        } catch (\Exception $e) {
            echo json_encode(['erro' => 'Data inválida ou erro no servidor.']);
        }
    }


    // Os métodos insert() e update() permanecem os mesmos que te enviei anteriormente
   public function insert(): void
{



    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Redirect::page($this->controller);
        return;
    }

    // 1) Extrai apenas o array sessao[...] do POST
    $post         = $this->request->getPost();
    $sessaoData   = $post['sessao'] ?? [];

    // DEBUG: veja o array que vai pro insert
    echo "<h2>Dados que serão inseridos:</h2><pre>";
    print_r($sessaoData);
    echo "</pre>";


    // 2) Campos de controle (não pertencem à tabela)
    $isRecorrente = !empty($sessaoData['is_recorrente']);
    $tipoRec      = $sessaoData['tipo_recorrencia'] ?? null;
    $quantidade   = (int)($sessaoData['quantidade_repeticoes'] ?? 1);

    // 3) Validação geral
    if (Validator::make($sessaoData, $this->model->validationRules)) {
        Redirect::page($this->controller . "/form/insert/0", [
            "msgError" => "Falha ao agendar. Verifique os dados."
        ]);
        return;
    }

    // 4) Recorrência?
    if ($isRecorrente) {
        $recorrenciaId = uniqid('rec_');
        $dataInicial   = new \DateTime($sessaoData['data_hora_agendamento']);
        $intervalo     = match($tipoRec) {
            'diariamente'   => 'P1D',
            'quinzenalmente' => 'P15D',
            'mensalmente'   => 'P1M',
            default         => 'P1W',
        };

        $sucesso = true;
        $erros   = [];

        for ($i = 0; $i < $quantidade; $i++) {
            $dados = $sessaoData;
            // remove campos extras
            unset($dados['is_recorrente'], $dados['tipo_recorrencia'], $dados['quantidade_repeticoes']);

            if ($i > 0) {
                $dataInicial->add(new \DateInterval($intervalo));
            }

            $dados['data_hora_agendamento'] = $dataInicial->format('Y-m-d H:i:s');
            $dados['recorrencia_id']        = $recorrenciaId;

            if (!$this->model->insert($dados, false)) {
                $sucesso = false;
                $erros[] = "Erro em " . $dados['data_hora_agendamento'];
            }
        }

        if ($sucesso) {
            Redirect::page($this->controller, [
                "msgSucesso" => "$quantidade sessões recorrentes agendadas com sucesso."
            ]);
        } else {
            Redirect::page($this->controller, [
                "msgError" => "Falha ao agendar recorrência: " . implode('; ', $erros)
            ]);
        }

    } else {
        // 5) Sessão única
       // 5) Sessão única
        $dados = $sessaoData;
        // campos extras
        unset($dados['is_recorrente'], $dados['tipo_recorrencia'], $dados['quantidade_repeticoes']);
        // campo que não existe na tabela
        unset($dados['data_selecionada']);
        if (empty($dados['id'])) {
            unset($dados['id']);
        }

        // tenta inserir
        $ok = $this->model->insert($dados, false);
        if ($ok) {
                Redirect::page($this->controller, [
                    "msgSucesso" => "Sessão agendada com sucesso."
                ]);
            } else {
                // DEBUG: captura erro do driver e SQL gerado
                $dbError   = $this->model->db->error();
                $lastQuery = method_exists($this->model->db, 'getLastQuery')
                    ? $this->model->db->getLastQuery()
                    : '[getLastQuery() não disponível]';
                echo "<h2>Falha ao inserir sessão:</h2><pre>";
                echo "SQL: {$lastQuery}\n\n";
                print_r($dbError);
                echo "</pre>";
                die;
            }

    }
}


   public function update(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Redirect::page($this->controller);
        return;
    }

    // 1) Recebe o array sessao[...] do POST
    $post       = $this->request->getPost();
    $sessaoData = $post['sessao'] ?? [];

    // 2) Normaliza o datetime-local (YYYY-MM-DDTHH:MM → YYYY-MM-DD HH:MM:SS)
    if (!empty($sessaoData['data_hora_agendamento'])) {
        $raw  = $sessaoData['data_hora_agendamento'];      // ex: "2025-06-26T14:00"
        $norm = str_replace('T', ' ', $raw);               // "2025-06-26 14:00"
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}$/', $norm)) {
            $norm .= ':00';                                // "2025-06-26 14:00:00"
        }
        $sessaoData['data_hora_agendamento'] = $norm;
    }

    // 3) Validação
    if (Validator::make($sessaoData, $this->model->validationRules)) {
        Redirect::page($this->controller . "/form/update/" . ($sessaoData['id'] ?? ''), [
            "msgError" => "O campo Data e Hora está com o formato incorreto. Formato esperado: AAAA-MM-DD HH:MM:SS"
        ]);
        return;
    }

    // 4) Remove qualquer campo extra que não exista na tabela
    unset($sessaoData['data_selecionada']);

    // 5) Atualiza no banco
    if ($this->model->update($sessaoData)) {
        Redirect::page($this->controller, [
            "msgSucesso" => "Agendamento atualizado com sucesso."
        ]);
    } else {
        Redirect::page($this->controller . "/form/update/" . ($sessaoData['id'] ?? ''), [
            "msgError" => "Falha ao atualizar. Tente novamente."
        ]);
    }
}






}