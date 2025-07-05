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

        if (
            isset($_SESSION['id_pregunta_actual'], $_SESSION['pregunta_data'], $_SESSION['hora_inicio_pregunta']) &&
            !isset($_SESSION['pregunta_respondida'])
        ) {
            $_SESSION['pregunta_data']['hora_inicio_pregunta'] = $_SESSION['hora_inicio_pregunta'];
            $this->view->render("Partida", $_SESSION['pregunta_data']);
            return;
        }


        $id_partida = $_SESSION['id_partida'];
        $pregunta = $this->model->obtenerSiguientePregunta($id_partida);

        if (!$pregunta) {
            $this->view->render("Error", ["mensaje" => "No hay mas preguntas! Se termino el juego"]);
            return;
        }

        $_SESSION['id_pregunta_actual'] = $pregunta['id_incremental'];
        $_SESSION['pregunta_data'] = $pregunta;
        $_SESSION['hora_inicio_pregunta'] = time();
        unset($_SESSION['pregunta_respondida']); // Por si quedó de antes
        $pregunta['hora_inicio_pregunta'] = $_SESSION['hora_inicio_pregunta'];
        $pregunta['correctas']=$_SESSION['correctas'] ?? 0;

        $this->view->render("Partida", $pregunta);
    }

    public function responderPregunta() {
        if (!isset($_SESSION['id_incremental']) || !isset($_SESSION['id_partida'])) {
            $this->view->render("Error", ['mensaje' => 'Partida no iniciada']);
            return;
        }

        $tiempoInicio = $_SESSION['hora_inicio_pregunta'] ?? null;
        $tiempoLimite = 30;

        if ($tiempoInicio === null) {
            $this->view->render("Error", ['mensaje' => 'Tiempo de respuesta no disponible']);
            return;
        }

        $tiempoActual = time();
        $tiempoTranscurrido = $tiempoActual - $tiempoInicio;

        if ($tiempoTranscurrido > $tiempoLimite) {
            unset($_SESSION['id_partida']);
            $this->view->render("FinPartida", [
                "mensaje" => "¡Se acabó el tiempo! Perdiste.",
                "respondidas" => $_SESSION['respondidas'] ?? 0,
                "correctas" => $_SESSION['correctas'] ?? 0
            ]);
            $this->limpiarContadores();
            return;
        }

        if (!isset($_POST['id_pregunta']) || !isset($_POST['opcion'])) {
            $this->view->render("Error", ['mensaje' => 'Datos inválidos']);
            return;
        }

        if (!isset($_SESSION['respondidas'])) $_SESSION['respondidas'] = 0;
        if (!isset($_SESSION['correctas'])) $_SESSION['correctas'] = 0;
        $_SESSION['respondidas']++;

        $id_usuario = $_SESSION['id_incremental'];
        $id_partida = $_SESSION['id_partida'];
        $id_pregunta = (int)$_POST['id_pregunta'];
        $id_opcion = (int)$_POST['opcion'];

        $correcto = $this->model->guardarRespuesta($id_usuario, $id_pregunta, $id_opcion, $id_partida);


        if ($correcto) {
            $_SESSION['correctas']++;
            $_SESSION['pregunta_respondida'] = true; // YA LA RESPONDIMOS BIEN
            header("Location: /triviados/Partida/mostrarPregunta"); //Entonces buscamos la siguiente
            exit;
        } else {
            unset($_SESSION['id_partida']);
            $this->view->render("FinPartida", [
                "mensaje" => "Se terminó el juego, te equivocaste.",
                "respondidas" => $_SESSION['respondidas'] ?? 0,
                "correctas" => $_SESSION['correctas'] ?? 0
            ]);
            $this->limpiarContadores();
        }
    }

    private function limpiarContadores() {
        unset($_SESSION['respondidas']);
        unset($_SESSION['correctas']);
        unset($_SESSION['id_pregunta_actual']);
        unset($_SESSION['pregunta_data']);
        unset($_SESSION['hora_inicio_pregunta']);
        unset($_SESSION['pregunta_respondida']);
    }

    public function reportarPregunta() {
        $this->model->reportarPregunta($_SESSION['id_pregunta_actual']);
        $this->model->perdioPartida($_SESSION['id_partida']);
        $this->view->render("FinPartida", [ "mensaje" => "Se Termino la Partida por una Pregunta Reportada.",
            "respondidas" => $_SESSION['respondidas'] ?? 0,
            "correctas" => $_SESSION['correctas'] ?? 0]);
        $this->limpiarContadores();
    }
}

?>