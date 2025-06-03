<?php

class PartidaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
}