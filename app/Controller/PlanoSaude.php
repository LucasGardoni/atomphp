<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class PlanoSaude extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    public function index(): void
    {
        $aDados['titulo'] = 'Planos de Saúde';
        $aDados['planos_saude'] = $this->model->lista('nome_plano');
        $this->loadView("sistema/listaPlanoSaude", $aDados);
    }

    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['plano_saude'] = $this->model->getById($id);

        $aDados['titulo'] = ($action === 'update') ? 'Editar Plano de Saúde' : 'Novo Plano de Saúde';
        $this->loadView("sistema/formPlanoSaude", $aDados);
    }

    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if (empty($post['id'])) {
                unset($post['id']);
            }
            if ($this->model->insert($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Plano de Saúde salvo com sucesso."]);
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
                Redirect::page($this->controller, ["msgSucesso" => "Plano de Saúde atualizado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $post['id'], ["msgError" => "Falha ao atualizar."]);
            }
        }
    }

    public function delete(string $action = '0', int $id = 0): void
    {
        if ($id > 0) {
            if ($this->model->delete($id)) {
                Redirect::page($this->controller, ["msgSucesso" => "Plano de Saúde excluído com sucesso."]);
            } else {
                Redirect::page($this->controller, ["msgError" => "Falha ao excluir. O plano pode estar em uso."]);
            }
        } else {
            Redirect::page($this->controller, ["msgError" => "ID inválido para exclusão."]);
        }
    }
}
