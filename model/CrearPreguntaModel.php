<?php

class CrearPreguntaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
}