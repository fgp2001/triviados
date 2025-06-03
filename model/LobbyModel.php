<?php

class LobbyModel
{

    private $db;

    public function __construct($database){
        $this->db = $database;

    }

    public function getImagenPerfil($nombre_usuario) {
            $sql = "SELECT foto_perfil FROM usuarios WHERE nombre_usuario = '$nombre_usuario' LIMIT 1";

            $resultado = $this->db->query($sql);

            if ($resultado !== false && count($resultado) > 0) {
                $fila = $resultado[0];
                $imagen_path = $fila['foto_perfil'];

                if (empty($imagen_path)) {
                    return '/triviados/img/default-avatar.jpg';  // ruta correcta del default
                }

                if (!preg_match('/\.(jpg|jpeg|png|gif)$/i', $imagen_path)) {
                    $imagen_path .= '.png';
                }
                return '/triviados/' . $imagen_path;
            }

        return '/triviados/img/default-avatar.jpg';
        }

}