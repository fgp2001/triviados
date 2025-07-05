<?php

class PreguntasReportadasController
{
    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;

    }
    public function show(){
        $preguntasReportadas = $this->model->getPreguntasReportadas();
        $mensaje = null;
        if (isset($_GET["mensaje"])) {
            if ($_GET["mensaje"] === "validada") {
                $mensaje = "El Reporte fue Validado y La pregunta volvio al Juego.";
            } elseif ($_GET["mensaje"] === "eliminada") {
                $mensaje = "Pregunta eliminada definitivamente del Juego.";
            }
        }
        $this->view->render("PreguntasReportadas",["reportadas"=>$preguntasReportadas,"mensaje"=>$mensaje]);
    }

    public function validar(){
        $id=$_GET["id"];
        $this->model->EliminarReporte($id);
        header("Location: /triviados/PreguntasReportadas/show?mensaje=validada");
    }
    public function eliminar(){
        $id=$_GET["id"];
        $this->model->EliminarPregunta($id);
        header("Location: /triviados/PreguntasReportadas/show?mensaje=eliminada");
    }
}