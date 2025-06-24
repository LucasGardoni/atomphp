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
        $aDados['especialidades_selecionadas'] = []; // Array para guardar as especialidades marcadas

        if ($action !== 'insert' && $id > 0) {
            $aDados['fisioterapeuta'] = $this->fisioterapeutaModel->getById($id);
            // Busca os IDs das especialidades que já estão salvas para este fisio
            $aDados['especialidades_selecionadas'] = $this->fisioterapeutaModel->getEspecialidadesIds($id);
        }
        
        // Busca todas as especialidades disponíveis para montar os checkboxes
        $especialidadeModel = new EspecialidadeModel();
        $aDados['todas_especialidades'] = $especialidadeModel->findAll();
        
        $this->loadView('sistema/formFisioterapeuta', $aDados);
    }
    
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            $especialidadesIds = $post['especialidades'] ?? [];
            
            // Remove as especialidades do array principal para não dar erro ao inserir o fisioterapeuta
            unset($post['especialidades']);

            // 1. Insere os dados principais do fisioterapeuta e pega o ID
            $fisioterapeutaId = $this->fisioterapeutaModel->insert($post, false);

            if ($fisioterapeutaId) {
                // 2. Se o fisioterapeuta foi salvo, salva as especialidades associadas
                $this->fisioterapeutaModel->salvarEspecialidades($fisioterapeutaId, $especialidadesIds);
                Redirect::page('Fisioterapeuta', ["msgSucesso" => "Fisioterapeuta salvo com sucesso."]);
            } else {
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

            // 1. Atualiza os dados principais do fisioterapeuta
            if ($this->fisioterapeutaModel->update($post) !== false) {
                // 2. Atualiza as especialidades associadas
                $this->fisioterapeutaModel->salvarEspecialidades($fisioterapeutaId, $especialidadesIds);
                Redirect::page('Fisioterapeuta', ["msgSucesso" => "Fisioterapeuta atualizado com sucesso."]);
            } else {
                Redirect::page('Fisioterapeuta/form/update/' . $fisioterapeutaId, ["msgError" => "Falha ao atualizar os dados do fisioterapeuta."]);
            }
        }
    }
}
