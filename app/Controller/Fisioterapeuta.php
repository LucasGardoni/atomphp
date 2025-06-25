<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\FisioterapeutaModel;
use App\Model\EspecialidadeModel;

class Fisioterapeuta extends ControllerMain
{
    private $fisioterapeutaModel;

    public function __construct()
    {
        $this->fisioterapeutaModel = new FisioterapeutaModel();
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

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
            default:
                $aDados['fisioterapeutas'] = $this->model->listaFisioterapeutasAtivos('nome');
                break;
        }
        $this->loadView("sistema/listaFisioterapeuta", $aDados);
    }

    public function form(string $action = 'insert', int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['fisioterapeuta'] = null;
        $aDados['especialidades_selecionadas'] = [];

        if ($action !== 'insert' && $id > 0) {
            $aDados['fisioterapeuta'] = $this->fisioterapeutaModel->getById($id);
            $aDados['especialidades_selecionadas'] = $this->fisioterapeutaModel->getEspecialidadesIds($id);
        }

        $especialidadeModel = new EspecialidadeModel();
        $aDados['todas_especialidades'] = $especialidadeModel
            ->db
            ->orderBy('nome', 'ASC')
            ->findAll();

        $this->loadView('sistema/formFisioterapeuta', $aDados);
    }

    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            $especialidadesIds = $post['especialidades'] ?? [];
            $fisioterapeutaData = $post;

            unset($fisioterapeutaData['especialidades']);
            unset($fisioterapeutaData['id']);
            $fisioterapeutaId = $this->fisioterapeutaModel->insert($fisioterapeutaData, false);

            if ($fisioterapeutaId > 0) {
                $this->fisioterapeutaModel->salvarEspecialidades($fisioterapeutaId, $especialidadesIds);
                Redirect::page('Fisioterapeuta', ["msgSucesso" => "Fisioterapeuta salvo com sucesso."]);
            } else {
                Session::set('old_form_data', $post);
                Redirect::page('Fisioterapeuta/form/insert', ["msgError" => "Falha ao salvar os dados do fisioterapeuta."]);
            }
        }
    }


    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            $fisioterapeutaId = $post['id'];
            $especialidadesIds = $post['especialidades'] ?? [];

            unset($post['especialidades']);

            if ($this->fisioterapeutaModel->update($post) !== false) {
                $this->fisioterapeutaModel->salvarEspecialidades($fisioterapeutaId, $especialidadesIds);
                Redirect::page('Fisioterapeuta', ["msgSucesso" => "Fisioterapeuta atualizado com sucesso."]);
            } else {
                Redirect::page('Fisioterapeuta/form/update/' . $fisioterapeutaId, ["msgError" => "Falha ao atualizar os dados do fisioterapeuta."]);
            }
        }
    }


    public function delete(string $action = '0', int $id = 0): void
    {
        if ($id <= 0) {
            Redirect::page($this->controller, ["msgError" => "ID inválido."]);
            return;
        }


        if ($this->model->verificarVinculoSessaoAgendada($id)) {
            $mensagem = "Não é possível excluir: este profissional possui sessões agendadas. Por favor, altere ou cancele os agendamentos primeiro.";
            Redirect::page($this->controller, ["msgError" => $mensagem]);
            return;
        }

        try {
            $this->model->salvarEspecialidades($id, []);

            if ($this->model->delete($id)) {
                Redirect::page($this->controller, ["msgSucesso" => "Fisioterapeuta excluído com sucesso."]);
            } else {
                throw new \Exception("Falha na exclusão do registro principal.");
            }
        } catch (\Exception $e) {
            Redirect::page($this->controller, ["msgError" => "Erro ao excluir o fisioterapeuta."]);
        }
    }
}
