<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

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
            if (empty($post['id'])) {
                unset($post['id']);
            }
            if ($this->model->insert($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Paciente cadastrado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao cadastrar. Verifique os dados."]);
            }
        } else {
            Redirect::page($this->controller);
        }
    }

    /**
     * Processa a atualização de um paciente existente.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if (empty($post['id'])) {
                 Redirect::page($this->controller, ["msgError" => "ID não fornecido para atualização."]);
                 return;
            }
            if ($this->model->update($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Paciente atualizado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $post['id'], ["msgError" => "Falha ao atualizar. Verifique os dados."]);
            }
        } else {
            Redirect::page($this->controller);
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