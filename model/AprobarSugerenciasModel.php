<?php

class AprobarSugerenciasModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function obtenerTodasLasSugerencias()
    {
        $sql = "SELECT id_incremental AS id, pregunta FROM preguntas WHERE estado = 0";
        return $this->db->query($sql);
    }

    public function aprobarPreguntaSugerida($id)
    {
        $sql = "UPDATE preguntas SET estado = 1 WHERE id_incremental = $id";
        return $this->db->query($sql);
    }

    public function rechazarPreguntaSugerida($id)
    {
        $sql = "DELETE FROM preguntas WHERE id_incremental = $id";
        return $this->db->query($sql);
    }
}