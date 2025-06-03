<?php

require_once __DIR__ . '/../libs/MailService.php';

class RegisterController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }


    public function registrar(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nombre = $_POST["nombre"];
            $fechaNacimiento = $_POST["date"];
            $sexo = $_POST["sexo"];
            $pais = $_POST["pais"];
            $ciudad = $_POST["ciudad"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $password2 = $_POST["password2"];
            $usuario = $_POST["usuario"];

            if ($password != $password2) {
                die("Las contraseñas no coinciden!");
            }

            $fotoPath = "";
            if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
                $nombreFoto = basename($_FILES["foto"]["name"]);
                $nombreFinal = $usuario . ".png";
                $fotoPath = "img/" . $nombreFinal;
                move_uploaded_file($_FILES["foto"]["tmp_name"], $fotoPath);
            }

            $token = bin2hex(random_bytes(16));

            $registrado = $this->model->registrarUsuario($email, $password, $nombre, $fechaNacimiento, $sexo, $pais, $ciudad, $usuario, $fotoPath, $token);

            if ($registrado) {
                $this->enviarEmailValidacion($email, $token);
                $this->view->render("RegisterExito");
            } else{
                $this->view->render("RegisterError");
            }

            }
    }

    private function enviarEmailValidacion($email, $token) {
        $mailService = new MailService();
        $mailService->enviarValidacion($email, $token);
    }

    public function validar(){

        if (isset($_GET["token"])) {
            $token = $_GET["token"];
            $result = $this->model->validarUsuarioPorToken($token);
            if ($result) {
                echo "Tu cuenta ha sido validada. ¡Bienvenido a Triviados!";
            } else{
                echo "La cuenta no pudo ser validada.";
            }
        } else{
            echo "Token no recibido.";
        }

    }

    function show(){
        $this->view->render("RegisterForm");
    }
}