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

            if ($usuario) {
                $_SESSION['usuario'] = $usuario['email'];
                header("Location: /triviados/Dashboard/show");
                exit;
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

