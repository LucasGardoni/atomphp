<?php

use Core\Library\Session;
use Core\Library\Request;

/**
 * Função para exibir alertas (sucesso ou erro) passados via GET na URL.
 * Esta é a função que estava faltando ou incorreta.
 */
if (!function_exists('exibeAlerta')) {
    function exibeAlerta() {
        // filter_input é uma forma segura de ler dados da URL ($_GET)
        $msgSucesso = filter_input(INPUT_GET, 'msgSucesso', FILTER_SANITIZE_SPECIAL_CHARS);
        $msgError = filter_input(INPUT_GET, 'msgError', FILTER_SANITIZE_SPECIAL_CHARS);

        $html = '';
        if ($msgSucesso) {
            $html = '<div class="alert alert-success m-2">' . $msgSucesso . '</div>';
        }
        if ($msgError) {
            $html = '<div class="alert alert-danger m-2">' . $msgError . '</div>';
        }
        return $html;
    }
}

/**
 * Retorna o valor de um campo para popular formulários "sticky".
 */
if (!function_exists('setValor')) {
    function setValor($cNomeCampo, $valorPadrao = "")
    {
        $inputs = Session::get('inputs');
        if (isset($inputs[$cNomeCampo])) {
            return htmlspecialchars($inputs[$cNomeCampo]);
        }
        return htmlspecialchars($valorPadrao);
    }
}

/**
 * Exibe a mensagem de erro de validação para um campo específico.
 */
if (!function_exists('setMsgFilderError')) {
    function setMsgFilderError($cNomeCampo)
    {
        $errors = Session::get('errors');
        if (isset($errors[$cNomeCampo])) {
            $errorMsg = $errors[$cNomeCampo];
            return "<div class='invalid-feedback d-block'>{$errorMsg}</div>";
        }
        return "";
    }
}

/**
 * Limpa os dados de formulário da sessão após o uso.
 */
if (!function_exists('limpaDadosSessao')) {
    function limpaDadosSessao() {
        Session::destroy('inputs');
        Session::destroy('errors');
    }
}

/**
 * Gera o título da página, agora com a chamada correta para exibeAlerta().
 */
if (!function_exists('formTitulo')) {
    function formTitulo($titulo, $btnNovo = false)
    {
        $request = new Request();
        $cHtmlBtn = $btnNovo ? buttons("new") : buttons("voltarTitulo");

        $cHtml = '  <div class="row bg-primary text-white m-2">
                        <div class="col-10 p-2">
                            <h3>' . $titulo . formSubTitulo($request->getAction()) . '</h3>
                        </div>
                        <div class="col-2 text-end p-2">
                            ' . $cHtmlBtn . '
                        </div>
                    </div>';
        
        // CORREÇÃO: Garante que a função de alerta seja chamada.
        $cHtml .= exibeAlerta(); 
        
        return $cHtml;
    }
}

/**
 * Gera o subtítulo do formulário com base na ação.
 */
function formSubTitulo($action)
{
    if ($action == "insert") { return " - Novo"; }
    elseif ($action == "update") { return " - Alteração"; }
    elseif ($action == "delete") { return " - Exclusão"; }
    elseif ($action == "view") { return " - Visualização"; }
    return "";
}

/**
 * Monta os botões do formulário (Voltar, Salvar/Enviar).
 */
function formButton()
{
    $request = new Request();
    $cHtml = '<hr><a href="' . baseUrl() . $request->getController() . '" title="Voltar" class="btn btn-secondary">Voltar</a>';
    if ($request->getAction() != "view") {
        $cHtml .= '&nbsp;<button type="submit" class="btn btn-primary">Salvar</button>';
    }
    return $cHtml;
}

/**
 * Gera botões de ícone para títulos ou listas.
 */
function buttons($acao, $id = 0) 
{
    $request = new Request();
    $button = "";
    if ($acao == "new") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/insert/0" class="btn btn-outline-info text-white btn-sm" title="Novo"><i class="fa-solid fa-pen"></i></a>';
    } elseif ($acao == "update") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/update/' . $id . '" class="btn btn-primary btn-sm" title="Alteração"><i class="fa-solid fa-pen-to-square"></i></a>';
    } elseif ($acao == "delete") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/delete/delete/' . $id . '" class="btn btn-danger btn-sm" title="Exclusão"><i class="fa-solid fa-trash-can"></i></i></a>';
    } elseif ($acao == "view") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '/form/view/' . $id . '" class="btn btn-primary btn-sm" title="Visualização"><i class="fa-solid fa-eye"></i></a>';
    } elseif ($acao == "voltarTitulo") {
        $button = '<a href="' . baseUrl()  . $request->getController() . '" class="btn btn-outline-info text-white btn-sm" title="Voltar"><i class="fa-solid fa-rotate-left"></i></a>';
    }
    return $button;    
}