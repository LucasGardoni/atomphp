<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\EnderecoModel;
use Core\Library\Validator;

class Paciente extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * Lista os pacientes com base no filtro de status.
     */
    public function index(): void
    {
        // Pega o valor do filtro da URL (via GET). Se não existir, usa 'ativos' como padrão.
        $filtro = $_GET['filtro_status'] ?? 'ativos';

        $aDados['titulo'] = 'Lista de Pacientes';
        $aDados['filtro_atual'] = $filtro; // Passa o filtro atual para a view

        // Decide qual método do model chamar com base na escolha do filtro
        switch ($filtro) {
            case 'inativos':
                $aDados['pacientes'] = $this->model->listaPacientesInativos('nome');
                break;
            case 'todos':
                $aDados['pacientes'] = $this->model->listaPacientes('nome');
                break;
            case 'ativos':
            default:
                $aDados['pacientes'] = $this->model->listaPacientesAtivos('nome');
                break;
        }
        
        $this->loadView("sistema/listaPaciente", $aDados);
    }

    /**
     * Exibe o formulário para inserir, editar ou visualizar um paciente.
     */
    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['paciente'] = null;

        if ($action !== 'insert' && $id > 0) {
            $pacienteData = $this->model->getById($id);
            if (!$pacienteData) {
                Session::set('msgError', 'Paciente não encontrado.');
                Redirect::page($this->controller);
                return;
            }
            // Apenas passa os dados para a view. A linha com 'setFormulario' foi removida.
            $aDados['paciente'] = $pacienteData;
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
     */
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            $enderecoData = $post['endereco'] ?? [];
            $pacienteData = $post['paciente'] ?? [];
            unset($pacienteData['id']);
            
            $enderecoModel = new EnderecoModel();
            $pacienteModel = $this->model;

            // Valida os dois conjuntos de dados antes de qualquer operação no banco
            if (Validator::make($enderecoData, $enderecoModel->validationRules) || Validator::make($pacienteData, $pacienteModel->validationRules)) {
                 Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha na validação. Verifique todos os campos obrigatórios."]);
                 return;
            }
            
            // Salva o endereço e retorna o novo ID
            $enderecoId = $enderecoModel->insert($enderecoData, false); 

            if ($enderecoId > 0) {
                // Adiciona o ID do endereço e salva o paciente
                $pacienteData['endereco_id'] = $enderecoId;
                if ($pacienteModel->insert($pacienteData, false)) {
                    Redirect::page($this->controller, ["msgSucesso" => "Paciente salvo com sucesso."]);
                } else {
                    // Caso falhe, apaga o endereço que ficou órfão para não sujar o banco
                    $enderecoModel->delete($enderecoId);
                    Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao salvar os dados do paciente."]);
                }
            } else {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao salvar o endereço."]);
            }
        }
    }

    /**
     * Processa a atualização com lógica para criar ou atualizar o endereço.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            
            $enderecoData = $post['endereco'] ?? [];
            $pacienteData = $post['paciente'] ?? [];
            
            $enderecoModel = new EnderecoModel();

            // Valida os dados do endereço
            if (Validator::make($enderecoData, $enderecoModel->validationRules)) {
                Redirect::page($this->controller . "/form/update/" . $pacienteData['id'], ["msgError" => "Endereço inválido. Verifique os campos."]);
                return;
            }

            // ---- LÓGICA CORRIGIDA ----
            // Verifica se o endereço já existe (pelo ID do endereço)
            if (!empty($enderecoData['id'])) {
                // Se já existe, apenas atualiza
                $enderecoModel->update($enderecoData);
                $enderecoId = $enderecoData['id'];
            } else {
                // Se não existe, cria um novo endereço e pega o novo ID
                $enderecoId = $enderecoModel->insert($enderecoData, true, true);
            }

            // Se a operação com o endereço funcionou...
            if ($enderecoId) {
                // ...vincula o ID do endereço ao paciente e atualiza o paciente.
                $pacienteData['endereco_id'] = $enderecoId;
                if ($this->model->update($pacienteData) !== false) {
                    Redirect::page($this->controller, ["msgSucesso" => "Paciente atualizado com sucesso."]);
                } else {
                    Redirect::page($this->controller . "/form/update/" . $pacienteData['id'], ["msgError" => "Falha ao atualizar dados do paciente."]);
                }
            } else {
                Redirect::page($this->controller . "/form/update/" . $pacienteData['id'], ["msgError" => "Ocorreu um erro ao salvar o endereço."]);
            }
        }
    }
    /**
     * Processa a exclusão de um paciente.
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            if (empty($post['id'])) {
                 Redirect::page($this->controller, ["msgError" => "ID do paciente não fornecido para exclusão."]);
                 return;
            }
            
            if ($this->model->delete($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Paciente excluído com sucesso."]);
            } else {
                Redirect::page($this->controller, ["msgError" => "Erro ao excluir paciente."]);
            }
        } else {
            Redirect::page($this->controller);
        }
    }
}