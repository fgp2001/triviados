<?php

class PartidaController
{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }

    public function iniciarPartida(){

        if (!isset($_SESSION['id_incremental'])) {
            $this->view->render("Error", ["mensaje" => "Usuario no autenticado"]);
            return;
        }
        //Crea nueva partida
        $id_usuario = $_SESSION['id_incremental'];
        $id_partida = $this->model->crearPartida($id_usuario);
        if (!$id_partida) {
            $this->view->render("Error", ["mensaje" => "No se pudo iniciar la partida"]);
            return;
        }
        $_SESSION['id_partida'] = $id_partida;
        $this->mostrarPregunta();

    }

    public function mostrarPregunta(){
        if (!isset($_SESSION['id_partida'])) {
            $this->view->render("Error", ['mensaje' => 'Partida no iniciada']);
            return;
        }
        $id_partida = $_SESSION['id_partida'];

        $pregunta = $this->model->obtenerSiguientePregunta($id_partida);

        if (!$pregunta) {
            $this->view->render("Error", ["mensaje" => "No hay mas preguntas! Se termino el juego"]);
            return;
        }

        if (!isset($pregunta['opciones']) || !is_array($pregunta['opciones'])) {
            $pregunta['opciones'] = [];
        }


        $this->view->render("Partida", $pregunta);
    }

    public function responderPregunta(){
        if (!isset($_SESSION['id_incremental']) || !isset($_SESSION['id_partida'])) {
            $this->view->render("Error", ['mensaje' => 'Partida no iniciada']);
            return;
        }

        $id_usuario = $_SESSION['id_incremental'];
        $id_partida = $_SESSION['id_partida'];

        if(!isset($_POST['id_pregunta']) || !isset($_POST['opcion'])){
            $this->view->render("Error", ['mensaje' => 'Datos inválidos']);
            return;
        }

        $id_pregunta = (int)$_POST['id_pregunta'];
        $id_opcion = (int)$_POST['opcion'];

        $correcto = $this->model->guardarRespuesta($id_usuario, $id_pregunta, $id_opcion, $id_partida);

        if ($correcto) {
            //Sigue jugando
            $this->mostrarPregunta();
        } else {
            //Termino el juego
            unset($_SESSION['id_partida']);
            $this->view->render("FinPartida", ["mensaje" => "Se termino el juego, te equivocaste!"]);
        }

    }


    /*public function show(){
        $this->view->render("Partida");
    }*/
}

?>