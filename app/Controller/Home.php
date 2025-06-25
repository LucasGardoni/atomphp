<?php
// app\controller\Home.php

namespace App\Controller;

use Core\Library\Redirect;
use Core\Library\Email;
use Core\Library\ControllerMain;

class Home extends ControllerMain
{
    public function index()
    {
        $this->loadView("home");
    }

    public function sobre($action = null)
    {
        echo "Página sobre nós. AÇÃO: {$action}";
    }

    public function detalhes($action = null, $id = null, ...$params)
    {
        echo "Detalhes: <br />";
        echo "<br />Ação: " . $action;
        echo "<br />ID: " . $id;
        echo "<br />PARÂMETROS: " . implode(", ", $params);
    }
    public function contatoEnviaEmail()
    {
        $this->loadHelper("emailHelper");

        $post = $this->request->getPost();

        $emailTexto = emailContatoRecebido(
            $post['nome'],
            $post['celular'],
            $post['email'],
            $post['assunto'],
            $post['mensagem']
        );

        $lRetMail = Email::enviaEmail(
            $_ENV['MAIL.USER'],
            $_ENV['MAIL.NOME'],
            $emailTexto['assunto'],
            $emailTexto['corpo'],
            "atomfisioterapia@gmail.com"
        );

        if ($lRetMail) {
            return Redirect::page("Home/contato", [
                "msgSucesso" => "E-mail enviado com sucesso, em breve entraremos em contato!"
            ]);
        } else {
            return Redirect::page("Home/contato", [
                "msgError" => "Ocorreu um erro ao enviar o e-mail. Tente novamente."
            ]);
        }
    }
}
