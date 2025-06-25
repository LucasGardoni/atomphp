<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Especialidade extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    public function index(): void
    {
        $aDados['titulo'] = 'Especialidades';
        $aDados['especialidades'] = $this->model->lista('nome');
        
        $this->loadView("sistema/listaEspecialidade", $aDados);
    }

    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['especialidade'] = null;

        if ($action !== 'insert' && $id > 0) {
            $aDados['especialidade'] = $this->model->getById($id);
            if (!$aDados['especialidade']) {
                Session::set('msgError', 'Especialidade não encontrada.');
                Redirect::page($this->controller);
                return;
            }
        }
        
        $aDados['titulo'] = ($action === 'update') ? 'Editar Especialidade' : 'Nova Especialidade';
        $this->loadView("sistema/formEspecialidade", $aDados);
    }

    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if (empty($post['id'])) {
                unset($post['id']);
            }
            if ($this->model->insert($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Especialidade salva com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao salvar. Verifique os dados."]);
            }
        }
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if ($this->model->update($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Especialidade atualizada com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $post['id'], ["msgError" => "Falha ao atualizar."]);
            }
        }
    }

    public function delete(string $action = '0', int $id = 0): void
    {
        if ($id > 0) {
            if ($this->model->delete($id)) {
                Redirect::page($this->controller, ["msgSucesso" => "Especialidade excluída com sucesso."]);
            } else {
                Redirect::page($this->controller, ["msgError" => "Falha ao excluir. A especialidade pode estar em uso."]);
            }
        } else {
             Redirect::page($this->controller, ["msgError" => "ID inválido para exclusão."]);
        }
    }
}