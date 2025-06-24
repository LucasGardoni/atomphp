<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\EnderecoModel;
use App\Model\PacienteModel;
use Core\Library\Validator;

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
        
        switch ($action) {
            case 'update':
                $aDados['titulo'] = 'Editar Paciente';
                break;
            case 'view':
                $aDados['titulo'] = 'Visualizar Paciente';
                break;
            case 'insert':
            default:
                $aDados['titulo'] = 'Novo Paciente';
                break;
        }

        $this->loadView("sistema/formPaciente", $aDados);
    }

    /**
     * Processa a inserção de um novo paciente.
     * Esta é a lógica CRÍTICA que precisava ser alterada.
     */
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            $enderecoData = $post['endereco'] ?? [];
            $pacienteData = $post['paciente'] ?? [];
            
            // Remove IDs para garantir que seja uma inserção
            unset($pacienteData['id']);
            unset($enderecoData['id']);
            
            $enderecoModel = new EnderecoModel();
            
            // Valida os dados antes de qualquer operação no banco
            // Nota: O Validator do framework parece retornar 'true' em caso de erro. Ajustando a lógica.
            if (Validator::make($enderecoData, $enderecoModel->validationRules) || Validator::make($pacienteData, $this->pacienteModel->validationRules)) {
                 Redirect::page("Paciente/form/insert", ["msgError" => "Falha na validação. Verifique todos os campos obrigatórios."]);
                 return;
            }
            
            // 1. Salva o endereço primeiro e retorna o novo ID
            $enderecoId = $enderecoModel->insert($enderecoData, false); 

            if ($enderecoId > 0) {
                // 2. Adiciona o ID do endereço ao paciente
                $pacienteData['endereco_id'] = $enderecoId; 

                // 3. Salva o paciente
                if ($this->pacienteModel->insert($pacienteData, false)) {
                    Redirect::page('Paciente', ["msgSucesso" => "Paciente salvo com sucesso."]);
                } else {
                    // Se falhar, apaga o endereço órfão para não sujar o banco
                    $enderecoModel->delete(['id' => $enderecoId]);
                    Redirect::page("Paciente/form/insert", ["msgError" => "Falha ao salvar os dados do paciente."]);
                }
            } else {
                Redirect::page("Paciente/form/insert", ["msgError" => "Falha ao salvar o endereço."]);
            }
        }
    }

    /**
     * Processa a atualização de um paciente e seu endereço.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            
            $enderecoData = $post['endereco'] ?? [];
            $pacienteData = $post['paciente'] ?? [];
            
            $enderecoModel = new EnderecoModel();

            if (Validator::make($enderecoData, $enderecoModel->validationRules) || Validator::make($pacienteData, $this->pacienteModel->validationRules)) {
                Redirect::page("Paciente/form/update/" . $pacienteData['id'], ["msgError" => "Dados inválidos. Verifique os campos."]);
                return;
            }
            
            $enderecoId = $enderecoData['id'] ?? null;
            
            // Se já tem um ID, atualiza. Senão, insere um novo endereço.
            if ($enderecoId) {
                $enderecoModel->update($enderecoData);
            } else {
                unset($enderecoData['id']);
                $enderecoId = $enderecoModel->insert($enderecoData, false);
            }

            if ($enderecoId) {
                $pacienteData['endereco_id'] = $enderecoId;

                if ($this->pacienteModel->update($pacienteData) !== false) {
                    Redirect::page('Paciente', ["msgSucesso" => "Paciente atualizado com sucesso."]);
                } else {
                    Redirect::page("Paciente/form/update/" . $pacienteData['id'], ["msgError" => "Falha ao atualizar dados do paciente."]);
                }
            } else {
                Redirect::page("Paciente/form/update/" . $pacienteData['id'], ["msgError" => "Ocorreu um erro ao salvar o endereço."]);
            }
        }
    }
    
    // As funções index() e delete() que você já tem podem permanecer as mesmas.
    // Colei as que você enviou para garantir.
    
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            if (empty($post['id'])) {
                 Redirect::page('Paciente', ["msgError" => "ID do paciente não fornecido para exclusão."]);
                 return;
            }
            
            $paciente = $this->pacienteModel->getById($post['id']);
            
            if ($this->pacienteModel->delete($post)) {
                if ($paciente && !empty($paciente['endereco_id'])) {
                    $enderecoModel = new EnderecoModel();
                    $enderecoModel->delete(['id' => $paciente['endereco_id']]);
                }
                Redirect::page('Paciente', ["msgSucesso" => "Paciente e endereço associado excluídos com sucesso."]);
            } else {
                Redirect::page('Paciente', ["msgError" => "Erro ao excluir paciente."]);
            }
        } else {
            Redirect::page('Paciente');
        }
    }
}
