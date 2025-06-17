<?php

class LobbyController{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }


    public function show() {

        $nombre = $_SESSION['nombre_usuario'] ?? 'Invitado';
        $tipoUsuario = $_SESSION['tipo_usuario'] ?? null;

        if ($tipoUsuario !== 'jugador') {
            header("Location: /triviados/Login/show?error=nosepuede");
            exit;
        }

        $foto = $this->model->getImagenPerfil($nombre) ?? '/triviados/img/default-avatar.jpg';
        $puntaje = $this->model->getPuntajeUsuario($nombre);


        $this->view->render("Lobby", ['nombre_usuario' => $nombre, 'foto' => $foto, 'puntaje' => $puntaje]);

    }
}