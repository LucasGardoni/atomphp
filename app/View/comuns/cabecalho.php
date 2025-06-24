<?php

use Core\Library\Session;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AtomFisioterapia | FASM 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= baseUrl() ?>assets/css/cabecalho.css">
    
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <header class="sticky-top z-3 header-custom">
        <div class="container mx-auto px-4 py-3 d-flex align-items-center justify-content-between">
            <a href="<?= baseUrl() ?>" class="d-flex align-items-center text-decoration-none">
                <div class="navbar-brand-logo me-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-heart" viewBox="0 0 24 24" fill="currentColor">
                        <path
                            d="M12 21.35l-1.84-1.66C4.48 14.71 1 11.43 1 7.5c0-3.1 2.4-5.5 5.5-5.5 1.74 0 3.41.81 4.5 2.09C12.09 2.81 13.76 2 15.5 2c3.1 0 5.5 2.4 5.5 5.5 0 3.93-3.48 7.21-9.16 12.19L12 21.35z" />
                    </svg>
                </div>
                <span class="navbar-brand-text">Atom Fisioterapia</span>
            </a>

            <nav class="d-none d-md-flex align-items-center">
                <ul class="navbar-nav flex-row"> <li class="nav-item me-3"><a class="nav-link nav-link-custom" href="<?= baseUrl() ?>">Home</a></li>
                    <li class="nav-item me-3"><a class="nav-link nav-link-custom" href="#sobre">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link nav-link-custom" href="#servicos">Serviços</a></li>
                </ul>
            </nav>

            <div class="d-none d-md-flex align-items-center">
                <?php if (Session::get("userId")) : // Menus para usuários logados (desktop)
                ?>
                    <ul class="navbar-nav flex-row align-items-center">
                        <li class="nav-item dropdown me-2">
                            <a class="nav-link dropdown-toggle text-dark nav-link-custom-dropdown" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1 text-primary"></i> Usuário
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 animated-dropdown">
                                <?php if ((int)Session::get("userNivel") <= 20) : ?>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario">Listar Usuários</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/form/insert/0">Novo Usuário</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/formTrocarSenha">Trocar a Senha</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Uf">UF's</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Cidade">Cidade</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= baseUrl() ?>login/signOut">Sair</a></li>
                            </ul>
                        </li>
                        <?php if ((int)Session::get("userNivel") <= 20) : ?>
                            <li class="nav-item dropdown me-2">
                                <a class="nav-link dropdown-toggle text-dark nav-link-custom-dropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-people-fill me-1 text-primary "></i> Pacientes
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente">Listar Pacientes</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente/form/insert/0">Novo Paciente</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>PlanoSaude">Plano Saude</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown me-2">
                                <a class="nav-link dropdown-toggle text-dark nav-link-custom-dropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-clipboard2-pulse-fill me-1 text-primary "></i> Fisioterapeutas
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Fisioterapeuta">Listar Fisioterapeutas</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Fisioterapeuta/form/insert/0">Novo Fisioterapeuta</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-dark nav-link-custom-dropdown" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-calendar-event-fill me-1 text-primary "></i> Agenda
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Sessao">Ver Agenda Completa</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Sessao/form/insert/0">Novo Agendamento</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php else : // Botão "Área restrita" para visitantes (desktop)
                ?>
                    <a href="<?= baseUrl() ?>Login" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm transition-hover-scale">Login</a>
                <?php endif; ?>
            </div>

            <button class="navbar-toggler d-md-none border-0" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse d-md-none w-100" id="navbarNavDropdown">
                <ul class="navbar-nav w-100 pt-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= baseUrl() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sobre">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicos">Serviços</a>
                    </li>

                    <?php if (Session::get("userId")) : // Menus para usuários logados (mobile)
                    ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> Usuário
                            </a>
                            <ul class="dropdown-menu border-0 animated-dropdown">
                                <?php if ((int)Session::get("userNivel") <= 20) : ?>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario">Listar Usuários</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/form/insert/0">Novo Usuário</a></li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/formTrocarSenha">Trocar a Senha</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Uf">UF's</a></li>
                                <li><a class="dropdown-item" href="<?= baseUrl() ?>Cidade">Cidade</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-danger" href="<?= baseUrl() ?>login/signOut">Sair</a></li>
                            </ul>
                        </li>

                        <?php if ((int)Session::get("userNivel") <= 20) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-people-fill me-1"></i> Pacientes
                                </a>
                                <ul class="dropdown-menu border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente">Listar Pacientes</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Paciente/form/insert/0">Novo Paciente</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if ((int)Session::get("userNivel") <= 20) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-clipboard2-pulse-fill me-1"></i> Fisioterapeutas
                                </a>
                                <ul class="dropdown-menu border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Fisioterapeuta">Listar Fisioterapeutas</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Fisioterapeuta/form/insert/0">Novo Fisioterapeuta</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <?php if ((int)Session::get("userNivel") <= 20) : ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bi bi-calendar-event-fill me-1"></i> Agenda
                                </a>
                                <ul class="dropdown-menu border-0 animated-dropdown">
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Sessao">Ver Agenda Completa</a></li>
                                    <li><a class="dropdown-item" href="<?= baseUrl() ?>Sessao/form/insert/0">Novo Agendamento</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                    <?php else : ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= baseUrl() ?>Login">Área restrita</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </header>

    <main class="container">