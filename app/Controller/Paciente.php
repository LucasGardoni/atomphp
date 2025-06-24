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
        // A linha abaixo provavelmente carrega o model para $this->model,
        // mas é mais seguro usar a propriedade que definimos ($this->pacienteModel).
        $this->auxiliarconstruct(); 
        $this->loadHelper('formHelper');
    }

    /**
     * Exibe o formulário para inserir, editar ou visualizar um paciente.
     */
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

    // 1) Remove IDs vazios
    unset($pacienteData['id'], $enderecoData['id']);

    // 2) Ajusta plano_saude_id e status
    $pacienteData['plano_saude_id'] = $pacienteData['plano_saude_id'] ?: null;
    $pacienteData['status']         = 1;

    // 3) Insere o endereço (skipValidation = true)
    $endModel   = new EnderecoModel();
    $enderecoId = $endModel->insert($enderecoData, true);

    if (!$enderecoId) {
        $err = $endModel->db->error(); 
        die('Erro ao inserir endereço: ' . ($err['message'] ?? 'Desconhecido'));
    }

    // 4) Insere o paciente (skipValidation = true)
    $pacienteData['endereco_id'] = $enderecoId;
    $ok = $this->pacienteModel->insert($pacienteData, true);

    if (!$ok) {
        $err = $this->pacienteModel->db->error();
        die('Erro ao inserir paciente: ' . ($err['message'] ?? 'Desconhecido'));
    }

    // 5) Redireciona em sucesso
    Redirect::page('Paciente', ['msgSucesso' => 'Paciente salvo com sucesso.']);
}
public function update(): void
{
    // 1) Só POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Redirect::page('Paciente');
        return;
    }

    // 2) Pega os dados
    $post          = $this->request->getPost();
    $enderecoData  = $post['endereco'] ?? [];
    $pacienteData  = $post['paciente'] ?? [];

    // 3) Confirma que veio o ID do paciente
    if (empty($pacienteData['id'])) {
        Redirect::page('Paciente', ['msgError' => 'ID do paciente ausente.']);
        return;
    }

    // 4) Inserir ou atualizar o endereço
    $endModel = new EnderecoModel();

    if (!empty($enderecoData['id'])) {
        // update endereço
        $okEnd = $endModel->update($enderecoData, true);
        if (!$okEnd) {
            die('Erro ao atualizar endereço');
        }
        $enderecoId = $enderecoData['id'];
    } else {
        // insert endereço
        unset($enderecoData['id']);
        $enderecoId = $endModel->insert($enderecoData, true);
        if (!$enderecoId) {
            die('Erro ao inserir endereço');
        }
    }

    // 5) Prepara os dados do paciente (inclui o ID dentro do array)
    $pacienteData['endereco_id']    = $enderecoId;
    $pacienteData['plano_saude_id']  = $pacienteData['plano_saude_id'] ?: null;
    $pacienteData['status']          = $pacienteData['status'] ?? 1;

    // 6) Atualiza o paciente (skipValidation = true)
    $okPac = $this->pacienteModel->update($pacienteData, true);
    if (!$okPac) {
        die('Erro ao atualizar paciente');
    }

    // 7) Sucesso
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


public function delete(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        Redirect::page('Paciente');
        return;
    }

    $post = $this->request->getPost();
    $id   = isset($post['id']) ? (int) $post['id'] : 0;

    if ($id < 1) {
        Redirect::page('Paciente', ["msgError" => "ID do paciente não fornecido para exclusão."]);
        return;
    }

    // busca antes de deletar para pegar o endereco_id
    $paciente = $this->pacienteModel->getById($id);
    if (! $paciente) {
        Redirect::page('Paciente', ["msgError" => "Paciente não encontrado."]);
        return;
    }

    // exclui pelo ID
    if ($this->pacienteModel->delete($id)) {
        // se havia endereço associado, exclui também
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
