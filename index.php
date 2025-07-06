<?php
session_start();

require_once("Configuration.php");

$controller = $_GET['controller'] ?? null;
$method = $_GET['method'] ?? null;

// NO REQUIEREN LOGIN SON PUBLICOS
$publicos = [
    'Login' => ['show', 'ejecutarLogin'],
    'Register' => ['show', 'registrar' , 'validar', 'enviarEmailValidacion', 'validarEmailAjax'],
    'Logout' => ['ejecutar']
];

// Permitir si es público
if (isset($publicos[$controller]) && in_array($method, $publicos[$controller])) {
    $permitido = true;
} else {
    $tipoUsuario = strtolower($_SESSION['tipo_usuario'] ?? '');
    $permitido = false;

    switch ($controller) {
        case 'Dashboard':
            $permitido = ($tipoUsuario === 'admin');
            break;
        case 'PanelEditor':
        case 'GestionarPregunta':
        case 'AprobarSugerencias':
        case 'PreguntasReportadas':
        case 'EditarPregunta':
        $permitido = ($tipoUsuario === 'editor');
            break;
        case 'Lobby':
        case 'Partida':
        case 'CrearPregunta':
        case 'Ranking':
        case 'Perfil':
            $permitido = ($tipoUsuario === 'jugador');
            break;

        default:
            $permitido = false;
            break;
    }
}

// Si no tiene permiso para alguno de los controladores, devuelve acceso denegado
if (!$permitido) {
    header("Location: /triviados/Login/show?error=acceso_denegado");
    exit;
}

$configuration = new Configuration();
$router = $configuration->getRouter();
$router->go($controller, $method);
