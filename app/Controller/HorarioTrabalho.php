<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use App\Model\FisioterapeutaModel;

class HorarioTrabalho extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }
    public function index(string $action = '0', int $fisioterapeuta_id = 0): void
    {
        $fisioterapeutaModel = new FisioterapeutaModel();
        $fisioterapeuta = $fisioterapeutaModel->getById($fisioterapeuta_id);

        if (!$fisioterapeuta) {
            Redirect::page('Fisioterapeuta', ["msgError" => "Fisioterapeuta não encontrado."]);
            return;
        }

        $aDados['titulo'] = 'Gestão de Horários';
        $aDados['subtitulo'] = 'Fisioterapeuta: ' . $fisioterapeuta['nome'];
        $aDados['horarios'] = $this->model->listaPorFisioterapeuta($fisioterapeuta_id);
        $aDados['fisioterapeuta_id'] = $fisioterapeuta_id;

        $this->loadView("sistema/listaHorarioTrabalho", $aDados);
    }

    public function form(string $action = 'insert', int $fisioterapeuta_id = 0, int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['horario'] = $this->model->getById($id);
        $aDados['fisioterapeuta_id'] = $fisioterapeuta_id;
        $aDados['titulo'] = ($action == 'update') ? 'Editar Horário' : 'Novo Horário';

        $this->loadView("sistema/formHorarioTrabalho", $aDados);
    }
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            if (empty($post['id'])) {
                unset($post['id']);
            }


            if ($this->model->insert($post)) {
                Redirect::page(
                    $this->controller . '/index/index/' . $post['fisioterapeuta_id'],
                    ["msgSucesso" => "Horário salvo com sucesso."]
                );
            } else {
                Redirect::page(
                    $this->controller . '/form/insert/' . $post['fisioterapeuta_id'],
                    ["msgError" => "Falha ao salvar."]
                );
            }
        }
    }


    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            $fisioId = $post['fisioterapeuta_id'] ?? 0;

            if ($this->model->update($post)) {
                Redirect::page(
                    $this->controller . '/index/index/' . $fisioId,
                    ["msgSucesso" => "Horário atualizado com sucesso."]
                );
            } else {
                $id = $post['id'] ?? 0;
                Redirect::page(
                    $this->controller . '/form/update/' . $fisioId . '/' . $id,
                    ["msgError" => "Falha ao atualizar o horário."]
                );
            }
        }
    }
    public function delete(string $action = '0', int $id = 0): void
    {
        if ($id <= 0) {
            Redirect::page($this->controller, ["msgError" => "ID inválido para exclusão."]);
            return;
        }

        $horario = $this->model->getById($id);
        if (! $horario) {
            Redirect::page($this->controller, ["msgError" => "Horário não encontrado."]);
            return;
        }

        $fisioId = (int) $horario['fisioterapeuta_id'];

        if ($this->model->delete($id)) {
            Redirect::page(
                $this->controller . '/index/index/' . $fisioId,
                ["msgSucesso" => "Horário excluído com sucesso."]
            );
        } else {
            Redirect::page(
                $this->controller . '/index/index/' . $fisioId,
                ["msgError" => "Erro ao excluir o horário."]
            );
        }
    }
}
