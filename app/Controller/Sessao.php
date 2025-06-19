<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\PacienteModel;
use App\Model\FisioterapeutaModel;
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

        $post = $this->request->getPost();
        
        // Verifica se a opção de recorrência foi marcada
        if (isset($post['is_recorrente']) && $post['is_recorrente'] === 'on') {
            
            // --- LÓGICA DE RECORRÊNCIA ---

            if (Validator::make($post, $this->model->validationRules)) {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao agendar. Verifique os dados."]);
                return;
            }

            $recorrencia_id = uniqid('rec_');
            $data_inicial = new \DateTime($post['data_hora_agendamento']);
            $quantidade = (int) ($post['quantidade_repeticoes'] ?? 1);
            $tipo = $post['tipo_recorrencia'] ?? 'semanalmente';
            
            $intervalo = 'P1W';
            if ($tipo === 'diariamente') $intervalo = 'P1D';
            if ($tipo === 'quinzenalmente') $intervalo = 'P15D';
            if ($tipo === 'mensalmente') $intervalo = 'P1M';

            $sucesso = true;
            $erros = [];

            for ($i = 0; $i < $quantidade; $i++) {
                $dadosSessao = $post;
                // Limpa os campos que não são da tabela antes de cada inserção
                unset($dadosSessao['id'], $dadosSessao['is_recorrente'], $dadosSessao['tipo_recorrencia'], $dadosSessao['quantidade_repeticoes']);

                if ($i > 0) {
                    $data_inicial->add(new \DateInterval($intervalo));
                }
                
                $dadosSessao['data_hora_agendamento'] = $data_inicial->format('Y-m-d H:i:s');
                $dadosSessao['recorrencia_id'] = $recorrencia_id;
                
                if (!$this->model->insert($dadosSessao, false)) {
                    $sucesso = false;
                    $erros[] = "Falha ao criar sessão para a data " . $dadosSessao['data_hora_agendamento'];
                }
            }

            if ($sucesso) {
                Redirect::page($this->controller, ["msgSucesso" => "$quantidade sessões recorrentes foram agendadas com sucesso."]);
            } else {
                Redirect::page($this->controller, ["msgError" => "Ocorreu um erro. Erros: " . implode(', ', $erros)]);
            }

        } else {
            // --- LÓGICA PARA SESSÃO ÚNICA ---

            // ---- CORREÇÃO ADICIONADA AQUI ----
            // Limpa os campos que não pertencem à tabela `sessoes` antes de inserir.
            unset($post['is_recorrente'], $post['tipo_recorrencia'], $post['quantidade_repeticoes']);
            // ------------------------------------

            if (empty($post['id'])) {
                unset($post['id']);
            }

            if ($this->model->insert($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Sessão agendada com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao agendar. Verifique os dados."]);
            }
        }
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if ($this->model->update($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Agendamento atualizado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $post['id'], ["msgError" => "Falha ao atualizar. Verifique os dados."]);
            }
        }
    }
}