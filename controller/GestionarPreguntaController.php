<?php

class GestionarPreguntaController
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
        $preguntas = $this->model->obtenerTodasLasPreguntas();

        $mensaje = null;
        if (isset($_GET["mensaje"])) {
            if ($_GET["mensaje"] === "modificada") {
                $mensaje = "Pregunta modificada correctamente.";
            } elseif ($_GET["mensaje"] === "eliminada") {
                $mensaje = "Pregunta eliminada correctamente.";
            }
        }

        $this->view->render("GestionarPregunta", [
            "preguntas" => $preguntas,
            "mensaje" => $mensaje
        ]);

    }

    public function modificar()
    {
        $id = $_POST['id'];
        $texto = $_POST['pregunta'];
        $this->model->editarPregunta($id, $texto);
        header("Location: /triviados/GestionarPregunta/show?mensaje=modificada");
    }

    public function baja(){
        $id = $_GET['id'];
        $this->model->eliminarPregunta($id);
        header("Location: /triviados/GestionarPregunta/show?mensaje=eliminada");
    }
}