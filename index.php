<?php
session_start();

//Silenciador del error de parseo de mustache
set_error_handler(function($errno, $errstr) {
    if ($errno === E_WARNING && strpos($errstr, 'Trying to access array offset on value of type null') !== false) {
        return true; // Silencia ese warning puntual
    }
    return false; // El resto de errores los muestra
});

require_once("Configuration.php");

$rutasPublicas = [
    'Login/show',
    'Login/ejecutarLogin',
    'Register/show',
    'Register/registrar',
    'Register/validar',
    'Register/enviarEmailValidacion',
    'Register/validarEmailAjax',
    'Logout/ejecutar'
];

$controller = $_GET['controller'] ?? null;
$method = $_GET['method'] ?? null;

$ruta = "$controller/$method";

//Si no hay sesion iniciada y la ruta no es publica, nos redirige al lobby
if (!isset($_SESSION['id_incremental']) && !in_array($ruta, $rutasPublicas, true)) {
    header("Location: /triviados/Login/show?error=sesion_no_iniciada");
    exit;
}


if (isset($_SESSION['id_incremental'])){
    $tipoUsuario = strtolower($_SESSION['tipo_usuario'] ?? '');

    if (str_starts_with($ruta, 'Dashboard') && $tipoUsuario !== 'admin') {
        session_unset();
        session_destroy();
        header("Location: /triviados/Login/show?error=acceso_denegado");
        exit;
    }

    if (str_starts_with($ruta, 'PanelEditor') ||
        str_starts_with($ruta, 'GestionarPregunta') ||
        str_starts_with($ruta, 'AprobarSugerencias') ||
        str_starts_with($ruta, 'PreguntasReportadas') ||
        str_starts_with($ruta, 'EditarPregunta')) {
        if ($tipoUsuario !== 'editor') {
            session_unset();
            session_destroy();
            header("Location: /triviados/Login/show?error=acceso_denegado");
            exit;
        }
    }

    if (str_starts_with($ruta, 'Lobby') ||
        str_starts_with($ruta, 'Partida') ||
        str_starts_with($ruta, 'CrearPregunta') ||
        str_starts_with($ruta, 'Ranking') ||
        str_starts_with($ruta, 'Perfil')) {
        if ($tipoUsuario !== 'jugador') {
            session_unset();
            session_destroy();
            header("Location: /triviados/Login/show?error=acceso_denegado");
            exit;
        }
    }

}

$configuration = new Configuration();
$router = $configuration->getRouter();
$router->go($controller, $method);
