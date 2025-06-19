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

    /**
     * Exibe o formulário para criar ou editar uma ficha de evolução.
     * O ID passado na URL é o ID da SESSÃO.
     */
    public function form(string $action = 'edit', int $sessao_id = 0): void
    {
        if ($sessao_id === 0) {
            Session::set('msgError', 'ID da sessão não fornecido.');
            Redirect::page('Sessao');
            return;
        }

        // Busca a ficha de evolução existente para esta sessão
        $fichaEvolucao = $this->model->getBySessaoId($sessao_id);
        
        // ---- INÍCIO DA CORREÇÃO ----
        // Busca dados da sessão (para mostrar nome do paciente e data) usando a forma correta
        $sessaoModel = new SessaoModel();
        
        // Define a tabela principal para a consulta no DB
        $sessaoModel->db->table('sessoes');

        $sessaoInfo = $sessaoModel->db->select("sessoes.*, pacientes.nome as nome_paciente")
                                     ->join("pacientes", "pacientes.id = sessoes.paciente_id", "LEFT")
                                     ->where("sessoes.id", $sessao_id)
                                     ->first();
        // ---- FIM DA CORREÇÃO ----

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

    /**
     * Salva (insere ou atualiza) uma ficha de evolução.
     */
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