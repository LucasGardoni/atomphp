<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\SessaoModel;

class FichaEvolucao extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarconstruct();
        $this->loadHelper('formHelper');
    }

    public function form(string $action = 'edit', int $sessao_id = 0): void
    {
        if ($sessao_id === 0) {
            Session::set('msgError', 'ID da sessão não fornecido.');
            Redirect::page('Sessao');
            return;
        }

        $fichaEvolucao = $this->model->getBySessaoId($sessao_id);

        $sessaoModel = new SessaoModel();

        $sessaoModel->db->table('sessoes');

        $sessaoInfo = $sessaoModel->db->select("sessoes.*, pacientes.nome as nome_paciente")
            ->join("pacientes", "pacientes.id = sessoes.paciente_id", "LEFT")
            ->where("sessoes.id", $sessao_id)
            ->first();


        if (!$sessaoInfo) {
            Session::set('msgError', 'Sessão não encontrada para criar a ficha de evolução.');
            Redirect::page('Sessao');
            return;
        }

        $aDados['action'] = ($fichaEvolucao) ? 'update' : 'insert';
        $aDados['ficha_evolucao'] = $fichaEvolucao;
        $aDados['sessao_info'] = $sessaoInfo;
        $aDados['titulo'] = 'Ficha de Evolução';

        $this->loadView("sistema/formFichaEvolucao", $aDados);
    }

    public function save(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();

            if (empty($post['id'])) {
                unset($post['id']);
                if ($this->model->insert($post)) {
                    Redirect::page("Sessao", ["msgSucesso" => "Ficha de Evolução salva com sucesso."]);
                } else {
                    Redirect::page($this->controller . "/form/edit/" . $post['sessao_id'], ["msgError" => "Falha ao salvar. Verifique os dados."]);
                }
            } else {
                if ($this->model->update($post)) {
                    Redirect::page("Sessao", ["msgSucesso" => "Ficha de Evolução atualizada com sucesso."]);
                } else {
                    Redirect::page($this->controller . "/form/edit/" . $post['sessao_id'], ["msgError" => "Falha ao atualizar. Verifique os dados."]);
                }
            }
        }
    }
}
