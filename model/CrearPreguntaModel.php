<?php

class CrearPreguntaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function conseguirIdMasAltoPregunta(){
        $sql="SELECT MAX(id_incremental) AS id_mas_alto FROM preguntas";
        $result = $this->db->query($sql);
        return $result[0]["id_mas_alto"];
    }
}