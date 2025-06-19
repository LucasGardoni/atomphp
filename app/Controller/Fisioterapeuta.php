<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Fisioterapeuta extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    /**
     * Lista os fisioterapeutas com base no filtro de status.
     */
    public function index(): void
    {
        $filtro = $_GET['filtro_status'] ?? 'ativos';

        $aDados['titulo'] = 'Lista de Fisioterapeutas';
        $aDados['filtro_atual'] = $filtro;

        switch ($filtro) {
            case 'inativos':
                $aDados['fisioterapeutas'] = $this->model->listaFisioterapeutasInativos('nome');
                break;
            case 'todos':
                $aDados['fisioterapeutas'] = $this->model->listaFisioterapeutas('nome');
                break;
            case 'ativos':
            default:
                $aDados['fisioterapeutas'] = $this->model->listaFisioterapeutasAtivos('nome');
                break;
        }
        
        $this->loadView("sistema/listaFisioterapeuta", $aDados);
    }

    /**
     * Exibe o formulário para inserir, editar ou visualizar um fisioterapeuta.
     */
    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['fisioterapeuta'] = null;

        if ($action !== 'insert' && $id > 0) {
            $fisioterapeutaData = $this->model->getById($id);
            if (!$fisioterapeutaData) {
                Session::set('msgError', 'Fisioterapeuta não encontrado.');
                Redirect::page($this->controller);
                return;
            }
            $aDados['fisioterapeuta'] = $fisioterapeutaData;
        }
        
        switch ($action) {
            case 'update':
                $aDados['titulo'] = 'Editar Fisioterapeuta';
                break;
            case 'view':
                $aDados['titulo'] = 'Visualizar Fisioterapeuta';
                break;
            case 'insert':
            default:
                $aDados['titulo'] = 'Novo Fisioterapeuta';
                break;
        }

        $this->loadView("sistema/formFisioterapeuta", $aDados);
    }

    /**
     * Processa a inserção de um novo fisioterapeuta.
     */
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            if (empty($post['id'])) {
                unset($post['id']);
            }
            if ($this->model->insert($post)) {
                Redirect::page($this->controller, ["msgSucesso" => "Fisioterapeuta cadastrado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao cadastrar. Verifique os dados."]);
            }
        } else {
            Redirect::page($this->controller);
        }
    }

    /**
     * Processa a atualização de um fisioterapeuta existente.
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
                Redirect::page($this->controller, ["msgSucesso" => "Fisioterapeuta atualizado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $post['id'], ["msgError" => "Falha ao atualizar. Verifique os dados."]);
            }
        } else {
            Redirect::page($this->controller);
        }
    }
}