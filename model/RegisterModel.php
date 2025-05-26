<?php

class RegisterModel
{
    private $db;

    public function __construct($database){
        $this->db = $database;
    }

    public function registrarUsuario($email, $password, $nombre, $fechaNacimiento, $sexo, $pais, $ciudad, $usuario, $fotoPath, $token){

        $sql = "INSERT INTO usuarios (email, password, nombre_completo, fecha_nacimiento, sexo, pais, ciudad, nombre_usuario, foto_perfil, validado, token_validacion)
        VALUES ('$email', '$password', '$nombre', '$fechaNacimiento', '$sexo', '$pais', '$ciudad', '$usuario', '$fotoPath', 0, '$token')";

        return $this->db->query($sql);

    }

    public function validarUsuarioPorToken($token){
        $stmt = $this->db->prepare("UPDATE usuarios SET validado = 1 WHERE token_validacion = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }



}