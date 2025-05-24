<?php

class loginModel{
    private $db;


    public function __construct($database)
    {
        $this->db = $database;
    }

    public function validarUsuario($email, $password){
        $sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password' AND validado = 1";
        $resultado = $this->db->query($sql);

        if ($resultado && count($resultado) > 0) {
            return $resultado[0]; // Devuelve el primer usuario
        }
        return false;
    }

}
