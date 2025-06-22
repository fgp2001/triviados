<?php

class RankingModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function obtenerRankingPorPuntaje() {
        $sql = "SELECT u.nombre_usuario, SUM(p.puntaje_obtenido) AS total_puntaje
                FROM partida p
                JOIN usuarios u ON u.id_incremental = p.id_usuario
                GROUP BY p.id_usuario
                ORDER BY total_puntaje DESC
                LIMIT 10";
        return $this->db->query($sql);
    }



}