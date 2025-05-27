<?php
class PerfilController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;

    }


    public function show()
    {
        session_start();
        $usuario = $_SESSION['nombre_usuario'] ?? 'Invitado';

        $perfilDatos = $this->model->getPerfilDatos($usuario);

        $this->view->render("Perfil", $perfilDatos);

    }

}
