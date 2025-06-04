<?php

class loginController{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;
    }



    function ejecutarLogin(){
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = $_POST["email"];
            $password = $_POST["password"];


            $usuario = $this->model->validarUsuario($email, $password);

            if ($usuario){
            $_SESSION['usuario'] = $usuario['email'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['tipo_usuario'] = strtolower($usuario['tipo_Usuario']);

            switch($_SESSION['tipo_usuario']){
                case 'admin':
                    header("Location: /triviados/Dashboard/show");
                    break;
                case 'editor':
                    header("Location: /triviados/PanelEditor/show");
                    break;
                case 'jugador':
                    header("Location: /triviados/Lobby/show");
                    break;
            }
            exit;
            } else{
                header("Location: /triviados/Login/show?error=rol_desconocido");
                exit;
            }

        }
    }

    function show(){
        $this->view->render("Login");
    }
}

