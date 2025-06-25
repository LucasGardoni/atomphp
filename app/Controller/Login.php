<?php

namespace App\Controller;

use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use Core\Library\Email;
use Core\Library\Redirect;
use Core\Library\Session;
use Core\Library\Validator;

class Login extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->model = new UsuarioModel();
        $this->loadHelper("formHelper");
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("login/login", []);
    }

    /**
     * signIn
     *
     * @return void
     */
    public function signIn()
    {
        $post   = $this->request->getPost();
        $aUser  = $this->model->getUserEmail($post['email']);

        if (count($aUser) > 0) {
            if (!password_verify(trim($post["senha"]), trim($aUser['senha']))) {
                return Redirect::page("login", [
                    "msgError" => 'Login ou senha inválido.',
                    'inputs' => ["email" => $post['email']]
                ]);
            }

            if ($aUser['statusRegistro'] == 2) {
                return Redirect::page("login", [
                    "msgError" => 'Usuário Inativo, não será possível prosseguir !',
                    'inputs' => ["email" => $post['email']]
                ]);
            }


            Session::set("userId", $aUser['id']);
            Session::set("userNome", $aUser['nome']);
            Session::set("userEmail", $aUser['email']);
            Session::set("userNivel", $aUser['nivel']);
            Session::set("userSenha", $aUser['senha']);

            // Direcionar o usuário para página home
            return Redirect::page("sistema");
            //

        } else {
            return Redirect::page("login", [
                "msgError" => 'Login ou senha inválido.',
                'inputs' => ["email" => $post['email']]
            ]);
        }
    }

    /**
     * signOut
     *
     * @return void
     */
    public function signOut()
    {
        Session::destroy('userId');
        Session::destroy('userNome');
        Session::destroy('userEmail');
        Session::destroy('userNivel');
        Session::destroy('userSenha');

        return Redirect::Page("home");
    }

    /**
     * formEsqueciASenha
     *
     * @return void
     */
    public function esqueciASenha()
    {
        return $this->loadView("login/esqueciASenha");
    }

    /**
     * esqueciASenhaEnvio
     *
     * @return void
     */
    public function esqueciASenhaEnvio()
    {
        $this->loadHelper("emailHelper");

        $post       = $this->request->getPost();
        $user       = $this->model->getUserEmail($post['email']);

        if (!$user) {

            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "Não foi possivel localizar o e-mail na base de dados !"
            ]);
        } else {

            $created_at = date('Y-m-d H:i:s');
            $chave      = sha1($user['id'] . $user['senha'] . date('YmdHis', strtotime($created_at)));
            $cLink      = baseUrl() . "login/recuperarSenha/" . $chave;
            $emailTexto = emailRecuperacaoSenha($cLink);

            $lRetMail = Email::enviaEmail(
                $_ENV['MAIL.USER'],
                $_ENV['MAIL.NOME'],
                $emailTexto['assunto'],
                $emailTexto['corpo'],
                $user['email']
            );

            if ($lRetMail) {

                $usuarioRecuperaSenhaModel = $this->loadModel("UsuarioRecuperaSenha");

                $usuarioRecuperaSenhaModel->desativaChaveAntigas($user["id"]);

                $resIns = $usuarioRecuperaSenhaModel->db->table('usuariorecuperasenha')->insert([
                    "usuario_id" => $user["id"],
                    "chave" => $chave,
                    "created_at" => $created_at
                ]);

                if ($resIns) {
                    return Redirect::page("login", [
                        "msgSucesso" => "Link para recuperação da senha enviado com sucesso! Verifique seu e-mail."
                    ]);
                } else {
                    return Redirect::page("login/esqueciASenha");
                }
            } else {
                return Redirect::page("login/esqueciASenha", ["inputs" => $post]);
            }
        }
    }

    /**
     * recuperarSenha
     *
     * @param string $chave 
     * @return void
     */
    public function recuperarSenha($chave)
    {
        $usuarioRecuperaSenhaModel  = $this->loadModel('UsuarioRecuperaSenha');
        $userChave                  = $usuarioRecuperaSenhaModel->getRecuperaSenhaChave($chave);

        if ($userChave) {

            if (date("Y-m-d H:i:s") <= date("Y-m-d H:i:s", strtotime("+1 hours", strtotime($userChave['created_at'])))) {

                $usuarioModel = $this->loadModel('Usuario');
                $user           = $usuarioModel->getById($userChave['usuario_id']);

                if ($user) {

                    $chaveRecSenha = sha1($userChave['usuario_id'] . $user['senha'] . date("YmdHis", strtotime($userChave['created_at'])));

                    if ($chaveRecSenha == $userChave['chave']) {

                        $dbDados = [
                            "id"    => $user['id'],
                            'nome'  => $user['nome'],
                            'usuariorecuperasenha_id' => $userChave['id']
                        ];

                        Session::destroy("msgError");

                        return $this->loadView("login/recuperarSenha", $dbDados);
                    } else {
                        $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                        return Redirect::page("Login/esqueciASenha", [
                            "msgError" => "Link de recuperação da senha inválida."
                        ]);
                    }
                } else {

                    $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                    return Redirect::page("Login/esqueciASenha", [
                        "msgError" => "Usuário para o link de recuperação da senha não localizado."
                    ]);
                }
            } else {
                $upd = $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);

                return Redirect::page("Login/esqueciASenha", [
                    "msgError" => "Link de recuperação da senha expirada."
                ]);
            }
        } else {
            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "Link de recuperação da senha não localizada."
            ]);
        }
    }

    /**
     * atualizaRecuperaSenha
     *
     * @return void
     */
    public function atualizaRecuperaSenha()
    {
        $UsuarioModel = $this->loadModel("Usuario");

        $post       = $this->request->getPost();
        $userAtual  = $UsuarioModel->getById($post["id"]);

        if ($userAtual) {

            if (trim($post["NovaSenha"]) == trim($post["NovaSenha2"])) {

                if ($UsuarioModel->db
                    ->table("usuario")
                    ->where(['id' => $post['id']])
                    ->update([
                        'senha'      => password_hash(trim($post["NovaSenha"]), PASSWORD_DEFAULT)
                    ])
                ) {
                    $usuarioRecuperaSenhaModel = $this->loadModel('UsuarioRecuperaSenha');

                    $upd = $usuarioRecuperaSenhaModel->desativaChave($post['usuariorecuperasenha_id']);

                    Session::destroy("msgError");
                    return Redirect::page("Login", [
                        "msgSuccesso"    => "Senha atualizada com sucesso !"
                    ]);
                } else {
                    return $this->loadView("login/recuperarSenha", $post);
                }
            } else {
                Session::set("msgError", "Nova senha e conferência da senha estão divergentes !");
                return $this->loadView("login/recuperarSenha", $post);
            }
        } else {
            Session::set("msgError", "Usuário inválido !");
            return $this->loadView("login/recuperarSenha", $post);
        }
    }

    /**
     * criaSuperUser
     *
     * @return void
     */
    public function criaSuperUser()
    {
        $dados = [
            "nivel"             => 1,
            "nome"              => "Lucas Gardoni",
            "email"             => "Lucas",
            "senha"             => password_hash("teste123", PASSWORD_DEFAULT),
            "statusRegistro"    => 1
        ];

        $aSuperUser = $this->model->getUserEmail($dados['email']);

        if (count($aSuperUser) > 0) {
            return Redirect::Page("login", ["msgError" => "Login já existe."]);
        } else {
            if ($this->model->insert($dados)) {
                return Redirect::Page("login", ["msgSucesso" => "Login criado com sucesso."]);
            } else {
                return Redirect::Page("login");
            }
        }
    }

    public function cadastrarLogin(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->loadView('login/cadastrarLogin', [
                'msgError' => Session::get('msgError')
            ]);
            Session::destroy('msgError');
            return;
        }
        $post = $this->request->getPost();
        $rules = [
            'nome'           => ['label' => 'Nome',                'rules' => 'required|min:3|max:60'],
            'email'          => ['label' => 'Email',               'rules' => 'required|email|min:5|max:150'],
            'senha'          => ['label' => 'Senha',               'rules' => 'required|min:6'],
            'senha_confirma' => ['label' => 'Confirmação de Senha', 'rules' => 'required|min:6']
        ];

        $hasErrors = Validator::make($post, $rules);

        if (!$hasErrors && $post['senha'] !== $post['senha_confirma']) {
            $hasErrors = true;
            $errors = Session::get('errors') ?: [];
            $errors['senha_confirma'] = 'As senhas não conferem.';
            Session::set('errors', $errors);
            Session::set('inputs', $post);
        }

        if ($hasErrors) {
            Session::set('msgError', 'Corrija os erros abaixo.');
            Redirect::page('Login/cadastrarLogin');
            return;
        }

        $dados = [
            'nome'           => trim($post['nome']),
            'email'          => trim($post['email']),
            'senha'          => password_hash($post['senha'], PASSWORD_DEFAULT),
            'nivel'          => 2,
            'statusRegistro' => 1
        ];

        if ($this->model->insert($dados)) {
            Redirect::page('Login', ['msgSucesso' => 'Usuário cadastrado com sucesso!']);
            return;
        } else {
            Redirect::page('Login/cadastrarLogin', ['msgError' => 'Falha ao cadastrar. Tente novamente.']);
            return;
        }
    }
}
