<?php

class EditarPreguntaController
{
    private $model;
    private $view;

    public function __construct($model, $view){
        $this->model = $model;
        $this->view = $view;
    }
    public function form(){
        $datosPregunta=$this->model->getDatosPregunta($_GET['id']);
        $opcion1=$this->model->getOpciones($_GET['id'])[0];
        $opcion2=$this->model->getOpciones($_GET['id'])[1];
        $opcion3=$this->model->getOpciones($_GET['id'])[2];
        $opcion4=$this->model->getOpciones($_GET['id'])[3];


        $this->view->render("EditarPregunta", ["datosPregunta"=>$datosPregunta,"id"=>$_GET["id"],"opcion1"=>$opcion1,"opcion2"=>$opcion2,"opcion3"=>$opcion3,"opcion4"=>$opcion4]);
    }
    public function editar(){
        $idPregunta = $_GET['id'];
        $idOpcion1 =$_GET['o1'];
        $idOpcion2 =$_GET['o2'];
        $idOpcion3 =$_GET['o3'];
        $idOpcion4 =$_GET['o4'];
        $categoria = $_POST['Categoria'];
        $pregunta = $_POST['pregunta'];
        $esCorrecta = $_POST['esCorrecta'];
        $Opcion1 = $_POST['Opcion1'];
        $Opcion2 = $_POST['Opcion2'];
        $Opcion3 = $_POST['Opcion3'];
        $Opcion4 = $_POST['Opcion4'];

        $this->model->editarPregunta($idPregunta, $pregunta, $categoria);
        $this->model->editarOpciones($idOpcion1,$idOpcion2,$idOpcion3,$idOpcion4,$Opcion1,$Opcion2,$Opcion3,$Opcion4,$esCorrecta);
        header('location: /triviados/GestionarPregunta/show');
    }
}