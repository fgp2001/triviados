<?php


require_once($_SERVER['DOCUMENT_ROOT'] . '/triviados/core/Database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/triviados/model/loginModel.php');

session_start();

function conectar(){
    $config = parse_ini_file("config.ini", true);
    $servername = $config['database']['server'];
    $username = $config['database']['user'];
    $dbname = $config['database']['dbname'];
    $password = $config['database']['pass'];

    return new Database($servername, $username, $dbname, $password);
}


function ejecutarLogin(){
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $db = conectar();
        $loginModel = new loginModel($db);
        $usuario = $loginModel->validarUsuario($email, $password);

        if ($usuario) {
            $_SESSION['usuario'] = $usuario['email'];
            header("Location:../dashboard.php");
            exit;
        } else{
            header("Location:../loginView.php?error=1");
            exit;
        }

    }
}