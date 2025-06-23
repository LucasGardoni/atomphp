<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\EspecialidadeModel;

class Fisioterapeuta extends ControllerMain
{
    public function __construct()
    {
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
        $aDados['fisioterapeuta'] = $this->model->getById($id);
        
        $especialidadeModel = new EspecialidadeModel();
        $aDados['lista_especialidades'] = $especialidadeModel->lista('nome');

        $aDados['especialidades_atuais'] = [];
        if ($id > 0) {
            $aDados['especialidades_atuais'] = $this->model->getEspecialidades($id);
        }
        
        $aDados['titulo'] = ($action === 'update') ? 'Editar Fisioterapeuta' : 'Novo Fisioterapeuta';
        $this->loadView("sistema/formFisioterapeuta", $aDados);
    }

    /**
     * Processa a inserção de um novo fisioterapeuta e suas especialidades.
     */
    public function insert(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            
            $especialidadesSelecionadas = $post['especialidades'] ?? [];
            unset($post['especialidades']);
            if (empty($post['id'])) { unset($post['id']); }

            try {
                // Tenta inserir o fisioterapeuta
                $fisioterapeutaSalvo = $this->model->insert($post);

                if ($fisioterapeutaSalvo) {
                    // Se o insert principal funcionou, busca o novo ID pelo CREFITO
                    $novoFisio = $this->model->getByCrefito($post['crefito']);
                    if ($novoFisio) {
                        // Com o ID, salva as especialidades
                        $this->model->salvarEspecialidades($novoFisio['id'], $especialidadesSelecionadas);
                        Redirect::page($this->controller, ["msgSucesso" => "Fisioterapeuta salvo com sucesso."]);
                    } else {
                        Redirect::page($this->controller, ["msgError" => "Fisioterapeuta salvo, mas houve um erro ao associar especialidades."]);
                    }
                } else {
                    // Falha na validação ou na inserção principal (sem erro de exceção)
                    Redirect::page($this->controller . "/form/insert/0", ["msgError" => "Falha ao salvar. Verifique os dados. (Causa: Validação)"]);
                }
            } catch (\PDOException $e) {
                // ---- CAPTURA DO ERRO DO BANCO DE DADOS ----
                // Se a query INSERT falhar, uma exceção PDO será capturada aqui.
                echo "<h1>Erro do Banco de Dados</h1>";
                echo "<p>A gravação falhou por um erro de SQL. Verifique se os dados violam alguma regra do banco (como CPF ou CREFITO duplicado).</p>";
                echo "<hr>";
                echo "<p><strong>Mensagem do Erro:</strong></p>";
                echo "<pre>";
                var_dump($e->getMessage());
                echo "</pre>";
                exit; // Para a execução para podermos ver o erro.
            }
        }
    }

    /**
     * Processa a atualização de um fisioterapeuta e suas especialidades.
     */
    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $post = $this->request->getPost();
            $fisioterapeutaId = $post['id'];
            
            // Separa os IDs das especialidades
            $especialidadesSelecionadas = $post['especialidades'] ?? [];
            unset($post['especialidades']);

            // 1. Atualiza os dados principais
            // Usamos '!== false' para o caso de a atualização não alterar nenhuma linha (0 rows affected)
            if ($this->model->update($post) !== false) {
                // 2. Atualiza as associações de especialidades
                $this->model->salvarEspecialidades($fisioterapeutaId, $especialidadesSelecionadas);
                Redirect::page($this->controller, ["msgSucesso" => "Fisioterapeuta atualizado com sucesso."]);
            } else {
                Redirect::page($this->controller . "/form/update/" . $fisioterapeutaId, ["msgError" => "Falha ao atualizar."]);
            }
        }
    }
}