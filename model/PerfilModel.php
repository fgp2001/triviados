<?php
class PerfilModel {
    private $db;

    public function __construct($database){
        $this->db = $database;

    }
        public function getPerfilDatos($nombre_usuario){
            $sql = "SELECT nombre_completo, email, foto_perfil
                    FROM usuarios
                    WHERE nombre_usuario = '$nombre_usuario' LIMIT 1";

            $resultado = $this->db->query($sql);

            if ($resultado !== false && count($resultado) > 0) {
                $fila = $resultado[0];
                //Campos que no existen todavia
                $fila['fecha_registro'] = "";
                $fila['ultimo_acceso'] = "";
                $fila['puntaje_total'] = 0;
                $fila['partidas_jugadas'] = 0;
                $fila['partidas_ganadas'] = 0;
                $fila['partidas_perdidas'] = 0;

                $imagen_path = $fila['foto_perfil'];

                if (empty($imagen_path)){
                    $imagen_path = '/img/default-avatar.jpg';
                }

                $fila['imagen_perfil'] = $imagen_path;
                $fila['nombre_usuario'] = $nombre_usuario;
                return $fila;
            }
            return [
                "nombre_usuario" => $nombre_usuario,
                "nombre_completo" => "",
                "email" => "",
                "fecha_registro" => "",
                "ultimo_acceso" => "",
                "puntaje_total" => 0,
                "partidas_jugadas" => 0,
                "partidas_ganadas" => 0,
                "partidas_perdidas" => 0,
                "imagen_perfil" => "/img/default-avatar.jpg"
            ];
        }
}
