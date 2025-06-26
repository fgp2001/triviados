<?php
class PerfilModel {
    private $db;

    public function __construct($database){
        $this->db = $database;

    }

    public function obtenerUltimoAccesoPorUltimaPartida($idUsuario) {

        $sql = "SELECT MAX(fecha_inicio) AS ultimo_acceso
                FROM partida
                WHERE id_usuario = $idUsuario";

        $resultado = $this->db->query($sql);
        return ($resultado !== false && count($resultado) > 0) ? $resultado[0]['ultimo_acceso'] : null;
    }

    public function obtenerCantidadPartidasJugadas($idUsuario) {

        $sql = "SELECT COUNT(*) AS partidas_jugadas
                FROM partida
                WHERE id_usuario = $idUsuario";

        $resultado = $this->db->query($sql);
        return ($resultado !== false && count($resultado) > 0) ? (int)$resultado[0]['partidas_jugadas'] : 0;

    }
        public function getPerfilDatos($nombre_usuario){
            $sql = "SELECT id_incremental, nombre_completo, email, foto_perfil, puntaje
                    FROM usuarios
                    WHERE nombre_usuario = '$nombre_usuario' LIMIT 1";

            $resultado = $this->db->query($sql);

            if ($resultado !== false && count($resultado) > 0) {
                $fila = $resultado[0];

                $fila['partidas_jugadas'] = $this->obtenerCantidadPartidasJugadas($fila['id_incremental']);
                $ultimoAcceso = $this->obtenerUltimoAccesoPorUltimaPartida($fila['id_incremental']);
                $fila['ultimo_acceso'] = $ultimoAcceso ?? "";

                //Campos que no existen todavia
                $fila['fecha_registro'] = "";
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

            //Si no hay datos, entonces devolver
            return [
                "nombre_usuario" => $nombre_usuario,
                "nombre_completo" => "",
                "email" => "",
                "fecha_registro" => "",
                "ultimo_acceso" => "",
                "puntaje" => 0,
                "partidas_jugadas" => 0,
                "partidas_ganadas" => 0,
                "partidas_perdidas" => 0,
                "imagen_perfil" => "/img/default-avatar.jpg"
            ];
        }
}
