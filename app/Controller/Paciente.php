<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\EnderecoModel;
use App\Model\PacienteModel;
use Core\Library\Validator;
use App\Model\PlanoSaudeModel;

class Paciente extends ControllerMain
{
    private $pacienteModel;

    public function __construct()
    {
        $this->pacienteModel = new PacienteModel();
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['paciente'] = null;
        $aDados['endereco'] = null;

        if ($action !== 'insert' && $id > 0) {
            $pacienteData = $this->pacienteModel->getById($id);
            if (!$pacienteData) {
                Session::set('msgError', 'Paciente não encontrado.');
                Redirect::page('Paciente');
                return;
            }
            $aDados['paciente'] = $pacienteData;

            if (!empty($pacienteData['endereco_id'])) {
                $enderecoModel = new EnderecoModel();
                $aDados['endereco'] = $enderecoModel->getById($pacienteData['endereco_id']);
            }
        }

        $planoSaudeModel = new PlanoSaudeModel();
        $aDados['planos_saude'] = $planoSaudeModel->findAllAtivos();

        $this->loadView("sistema/formPaciente", $aDados);
    }

    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::page('Paciente/form/insert', ['msgError' => 'Método inválido']);
            return;
        }

        $post          = $this->request->getPost();
        $enderecoData  = $post['endereco'] ?? [];
        $pacienteData  = $post['paciente'] ?? [];

        unset($pacienteData['id'], $enderecoData['id']);

        $pacienteData['plano_saude_id'] = $pacienteData['plano_saude_id'] ?: null;
        $pacienteData['status']         = 1;

        $endModel   = new EnderecoModel();
        $enderecoId = $endModel->insert($enderecoData, true);

        if (!$enderecoId) {
            $err = $endModel->db->error();
            die('Erro ao inserir endereço: ' . ($err['message'] ?? 'Desconhecido'));
        }

        $pacienteData['endereco_id'] = $enderecoId;
        $ok = $this->pacienteModel->insert($pacienteData, true);

        if (!$ok) {
            $err = $this->pacienteModel->db->error();
            die('Erro ao inserir paciente: ' . ($err['message'] ?? 'Desconhecido'));
        }

        Redirect::page('Paciente', ['msgSucesso' => 'Paciente salvo com sucesso.']);
    }
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Redirect::page('Paciente');
            return;
        }
        $post          = $this->request->getPost();
        $enderecoData  = $post['endereco'] ?? [];
        $pacienteData  = $post['paciente'] ?? [];

        if (empty($pacienteData['id'])) {
            Redirect::page('Paciente', ['msgError' => 'ID do paciente ausente.']);
            return;
        }
        $endModel = new EnderecoModel();

        if (!empty($enderecoData['id'])) {
            $okEnd = $endModel->update($enderecoData, true);
            if (!$okEnd) {
                die('Erro ao atualizar endereço');
            }
            $enderecoId = $enderecoData['id'];
        } else {
            unset($enderecoData['id']);
            $enderecoId = $endModel->insert($enderecoData, true);
            if (!$enderecoId) {
                die('Erro ao inserir endereço');
            }
        }
        $pacienteData['endereco_id']    = $enderecoId;
        $pacienteData['plano_saude_id']  = $pacienteData['plano_saude_id'] ?: null;
        $pacienteData['status']          = $pacienteData['status'] ?? 1;

        $okPac = $this->pacienteModel->update($pacienteData, true);
        if (!$okPac) {
            die('Erro ao atualizar paciente');
        }
        Redirect::page('Paciente', ['msgSucesso' => 'Paciente atualizado com sucesso.']);
    }


    public function index(): void
    {
        $filtro = $_GET['filtro_status'] ?? 'ativos';
        $aDados['titulo'] = 'Lista de Pacientes';
        $aDados['filtro_atual'] = $filtro;

        switch ($filtro) {
            case 'inativos':
                $aDados['pacientes'] = $this->pacienteModel->listaPacientesInativos('nome');
                break;
            case 'todos':
                $aDados['pacientes'] = $this->pacienteModel->listaPacientes('nome');
                break;
            case 'ativos':
            default:
                $aDados['pacientes'] = $this->pacienteModel->listaPacientesAtivos('nome');
                break;
        }

        $this->loadView("sistema/listaPaciente", $aDados);
    }


    public function delete(string $action = '0', int $id = 0): void
    {
        if ($id <= 0) {
            Redirect::page('Paciente', ["msgError" => "ID do paciente não fornecido para exclusão."]);
            return;
        }

        $paciente = $this->pacienteModel->getById($id);
        if (! $paciente) {
            Redirect::page('Paciente', ["msgError" => "Paciente não encontrado."]);
            return;
        }

        if ($this->pacienteModel->verificarVinculoSessaoAgendada($id)) {
            $mensagem = "Não é possível excluir: este paciente possui sessões agendadas. Por favor, altere ou cancele os agendamentos primeiro.";
            Redirect::page('Paciente', ["msgError" => $mensagem]);
            return;
        }


        if ($this->pacienteModel->delete($id)) {
            if (! empty($paciente['endereco_id'])) {
                $enderecoModel = new EnderecoModel();
                $enderecoModel->delete((int) $paciente['endereco_id']);
            }
            Redirect::page('Paciente', ["msgSucesso" => "Paciente e endereço associado excluídos com sucesso."]);
        } else {
            Redirect::page('Paciente', ["msgError" => "Erro ao excluir paciente."]);
        }
    }
}
