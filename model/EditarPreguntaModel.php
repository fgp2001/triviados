<?php

class EditarPreguntaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
    public function getDatosPregunta($id_pregunta){
        $sql = "SELECT pregunta,id_categoria FROM preguntas WHERE id_incremental = $id_pregunta";
        return $this->db->query($sql);
    }
    public function getOpciones($id_pregunta){
        $sql = "SELECT opcion,es_correcta,id_incremental AS id FROM opciones WHERE pregunta_id = $id_pregunta";
        return $this->db->query($sql);
    }

    public function editarPregunta($idpregunta,$pregunta,$categoria){
        $sql="UPDATE preguntas SET pregunta='$pregunta',id_categoria=$categoria WHERE id_incremental=$idpregunta";
        $this->db->query($sql);
    }
    public function actualizarOpcion($idOpcion,$opcion,$esCorrecta){
        $sql="UPDATE opciones SET opcion='$opcion', es_correcta=$esCorrecta WHERE id_incremental=$idOpcion";
        $this->db->query($sql);
    }



    public function editarOpciones($idOpcion1,$idOpcion2,$idOpcion3,$idOpcion4,$Opcion1,$Opcion2,$Opcion3,$Opcion4,$esCorrecta){
        switch ($esCorrecta) {
            case 1:
                $this->actualizarOpcion($idOpcion1,$Opcion1,1);
                $this->actualizarOpcion($idOpcion2,$Opcion2,0);
                $this->actualizarOpcion($idOpcion3,$Opcion3,0);
                $this->actualizarOpcion($idOpcion4,$Opcion4,0);
            break;
            case 2:
                $this->actualizarOpcion($idOpcion1,$Opcion1,0);
                $this->actualizarOpcion($idOpcion2,$Opcion2,1);
                $this->actualizarOpcion($idOpcion3,$Opcion3,0);
                $this->actualizarOpcion($idOpcion4,$Opcion4,0);
            break;
            case 3:
                $this->actualizarOpcion($idOpcion1,$Opcion1,0);
                $this->actualizarOpcion($idOpcion2,$Opcion2,0);
                $this->actualizarOpcion($idOpcion3,$Opcion3,1);
                $this->actualizarOpcion($idOpcion4,$Opcion4,0);
            break;
            case 4:
                $this->actualizarOpcion($idOpcion1,$Opcion1,0);
                $this->actualizarOpcion($idOpcion2,$Opcion2,0);
                $this->actualizarOpcion($idOpcion3,$Opcion3,0);
                $this->actualizarOpcion($idOpcion4,$Opcion4,1);
            break;
        }
    }


}