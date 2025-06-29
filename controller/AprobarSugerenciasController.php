<?php

class AprobarSugerenciasController
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
        $sugerencias = $this->model->obtenerTodasLasSugerencias();

        $mensaje = null;
        if (isset($_GET["mensaje"])) {
            if ($_GET["mensaje"] === "aprobada") {
                $mensaje = "Pregunta aprobada correctamente.";
            } elseif ($_GET["mensaje"] === "rechazada") {
                $mensaje = "Pregunta rechazada correctamente.";
            }
        }

        $this->view->render("AprobarSugerencias", ["sugerencias" => $sugerencias, "mensaje" => $mensaje]);
    }

    public function aprobada()
    {
        $id = $_GET['id'];
        $this->model->aprobarPreguntaSugerida($id);
        header("Location: /triviados/AprobarSugerencias/show?mensaje=aprobada");
    }

    public function rechazada(){
        $id = $_GET['id'];
        $this->model->rechazarPreguntaSugerida($id);
        header("Location: /triviados/AprobarSugerencias/show?mensaje=rechazada");
    }
}