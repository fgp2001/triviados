<?php

class loginModel{
    private $db;


    public function __construct($database)
    {
        $this->db = $database;
    }

    public function validarUsuario($email, $password){
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
        $usuarios = $this->db->query($sql);

        return $usuarios;
    }

}
