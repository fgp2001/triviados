<?php

class PreguntasReportadasModel
{
    public function __construct($database){
        $this->db = $database;

    }
    public function getPreguntasReportadas(){
        $sql = "SELECT id_incremental AS id,pregunta FROM preguntas WHERE reportado=1";
        return $this->db->query($sql);
    }
    public function EliminarReporte($id){
        $sql = "UPDATE preguntas SET reportado=0 WHERE id_incremental=$id";
        return $this->db->query($sql);
    }
    public function EliminarPregunta($id){
        $sql = "DELETE FROM preguntas WHERE id_incremental=$id";
        return $this->db->query($sql);
    }

}