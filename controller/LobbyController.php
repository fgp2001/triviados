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
        $this->view->render("Lobby", ["nombre_usuario" => $nombre]);
    }

}