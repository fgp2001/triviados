<?php

class LobbyController{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }


    public function show() {
        session_start();
        $nombre = $_SESSION['nombre_usuario'] ?? 'Invitado';



        if($nombre !== 'Invitado') {
            $foto = $this->model->getImagenPerfil($nombre);
        } else{
            $foto = '/triviados/img/default-avatar.jpg';
        }

        $this->view->render("Lobby", ['nombre_usuario' => $nombre, 'foto' => $foto]);
    }

}