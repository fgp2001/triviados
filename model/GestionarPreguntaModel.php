<?php

class GestionarPreguntaModel
{

    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function obtenerTodasLasPreguntas(){
        $sql = "SELECT id_incremental AS id, pregunta FROM preguntas";
        return $this->db->query($sql);
    }

    public function editarPregunta($id, $texto)
    {
        $sql = "UPDATE preguntas SET pregunta = '$texto' WHERE id_incremental = $id";
        $this->db->query($sql);
    }

    public function eliminarPregunta($id){
        $sql = "DELETE FROM opciones WHERE pregunta_id = $id";
        $this->db->query($sql);

        $sql = "DELETE FROM preguntas WHERE id_incremental = $id";
        $this->db->query($sql);
    }


}