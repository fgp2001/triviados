<?php
#include <stdlib.h>

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
            //Falta agregar la opcion de que si es un editor lo mande al panel de edicion
            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];

                if ($usuario['email'] === 'admin@admin.com') {
                    header("Location: /triviados/Dashboard/show");
                    exit;
                } else{
                    header("Location: /triviados/Lobby/show");
                    exit;
                }
            } else{
                header("Location:../LoginView.mustache?error=1");
                exit;
            }

        }
    }

    function show(){
        $this->view->render("Login");
    }
}

