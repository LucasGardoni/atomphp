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

    /**
     * Lista os horários de um fisioterapeuta específico.
     */
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

    /**
     * Exibe o formulário para adicionar/editar um horário.
     */
    public function form(string $action = 'insert', int $fisioterapeuta_id = 0, int $id = 0): void
    {
        $aDados['action'] = $action;
        $aDados['horario'] = $this->model->getById($id);
        $aDados['fisioterapeuta_id'] = $fisioterapeuta_id;
        $aDados['titulo'] = ($action == 'update') ? 'Editar Horário' : 'Novo Horário';

        $this->loadView("sistema/formHorarioTrabalho", $aDados);
    }

    /**
     * Salva um novo horário de trabalho.
     */
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            
            // ---- CORREÇÃO ADICIONADA AQUI ----
            // Se o ID estiver vazio (novo cadastro), removemos ele do array
            // para que o banco de dados possa usar o AUTO_INCREMENT.
            if (empty($post['id'])) {
                unset($post['id']);
            }
            // ---- FIM DA CORREÇÃO ----

            if ($this->model->insert($post)) {
                Redirect::page($this->controller . '/index/index/' . $post['fisioterapeuta_id'], ["msgSucesso" => "Horário salvo com sucesso."]);
            } else {
                Redirect::page($this->controller . '/form/insert/' . $post['fisioterapeuta_id'], ["msgError" => "Falha ao salvar."]);
            }
        }
    }
}