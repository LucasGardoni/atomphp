<?php

use Core\Library\Session;

?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="AtomPHP, microframework">
        <meta name="autho" content="Aldecir fonseca">

        <title>AtomPHP | FASM 2025</title>

        <link href="<?= baseUrl() ?>assets/img/AtomPHP-icone.png" rel="icon" type="image/png">

        <link href="<?= baseUrl() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= baseUrl() ?>assets/bootstrap/font/bootstrap-icons.min.css" rel="stylesheet">

        <script src="<?= baseUrl() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <header class="container-fluid">

            <nav class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="<?= baseUrl() ?>"><img class="login-img" src="/assets/img/AtomPHP-logo.png" alt="" height="90" width="90"></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= baseUrl() ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Quem Somos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Produtos/Serviços</a>
                        </li>

                        <?php if (Session::get("userId")): // Verifica se o usuário está logado ?>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-circle"></i> Usuário
                                </a>
                                <ul class="dropdown-menu">
                                    <?php if ((int)Session::get("userNivel") <= 20): ?>
                                        <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario">Listar Usuários</a></li>
                                        <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/form/insert/0">Novo Usuário</a></li>
                                    <?php endif; ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/formTrocarSenha">Trocar a Senha</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Uf">UF's</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Cidade">Cidade</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>login/signOut">Sair</a></li>
                                </ul>
                            </li>

                            <?php if ((int)Session::get("userNivel") <= 20): ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi bi-people-fill"></i> Pacientes
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente">Listar Pacientes</a></li>
                                        <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente/form/insert/0">Novo Paciente</a></li>
                                    </ul>
                                </li>
                            <?php endif; ?>

                        <?php else: // Usuário NÃO está logado ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= baseUrl() ?>Login">Área restrita</a>
                            </li>
                        <?php endif; ?>

                    </ul>
                    </div>
                </div>
                </nav>
        </header>
        
        <main class="container">