<?php

session_start();

use Core\Library\Ambiente;
use Core\Library\Routes;

require_once ".." . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
require_once ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "Constants.php";

// seta time zone
date_default_timezone_set(DEFAULT_TIME_ZONE);

// Remove query string para evitar que a rota capture parâmetros incorretos
$uriLimpo = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($uriLimpo !== null) {
    $_SERVER['REQUEST_URI'] = $uriLimpo;
}



$ambiente = new Ambiente();
$routes = new Routes();

$ambiente->load();

// Chamando minha rota
$routes->rota();