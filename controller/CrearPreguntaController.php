<?php

class CrearPreguntaController
{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }


    public function show() {
        $this->view->render("CrearPregunta");
    }
    public function agregar(){
        $pregunta = $_POST['pregunta'];
        $Categoria = $_POST['Categoria'];
        $Opcion1 = $_POST['Opcion1'];
        $Opcion2 = $_POST['Opcion2'];
        $Opcion3 = $_POST['Opcion3'];
        $Opcion4 = $_POST['Opcion4'];
        $esCorrecta = $_POST['esCorrecta'];
        $this->model->agregarPregunta($pregunta,$Categoria);
        $this->model->agregarOpciones($Opcion1,$Opcion2,$Opcion3,$Opcion4,$esCorrecta);
        $this->view->render("PreguntaAVerificar");
    }
}