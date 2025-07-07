<?php

class DashboardModel
{
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function obtenerPartidasTotalesPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT DATE_FORMAT(fecha_inicio, '$formato') AS formato, COUNT(*) AS total
        FROM partida
        GROUP BY formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerPreguntasTotalesPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT DATE_FORMAT(fecha_creacion, '$formato') AS formato, COUNT(*) AS total
        FROM preguntas
        WHERE estado = 1
        GROUP BY formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerUsuariosTotalesPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT DATE_FORMAT(fecha_registro, '$formato') AS formato, COUNT(*) AS total
        FROM usuarios
        WHERE tipo_Usuario = 'Jugador'
        GROUP BY formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerPreguntasCreadasPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT DATE_FORMAT(fecha_creacion, '$formato') AS formato, COUNT(*) AS total
        FROM preguntas p
        INNER JOIN usuarios u ON u.id = p.id_usuario
        WHERE u.tipo_Usuario = 'Jugador' AND p.estado = 1
        GROUP BY formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerPorcentajeDePreguntasCorrectasPorUsuarioPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT u.nombre_usuario, DATE_FORMAT(p.fecha_creacion, '$formato') AS formato,
       ROUND((SUM(p.veces_correcta) / SUM(p.veces_entregada)) * 100, 2) AS porcentaje_correctas
       FROM preguntas p INNER JOIN usuarios u ON u.id_incremental = p.id_usuario
       WHERE p.veces_entregada > 0 
       GROUP BY u.id_incremental, formato
       ORDER BY formato, porcentaje_correctas DESC";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerCantidadDeUsuariosPorPaisPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT pais, COUNT(*) AS cantidad,  DATE_FORMAT(fecha_registro, '$formato') AS formato
        FROM usuarios
        WHERE tipo_Usuario = 'Jugador'
        GROUP BY pais, formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function obtenerCantidadDeUsuariosPorSexoPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT sexo, COUNT(*) AS cantidad,  DATE_FORMAT(fecha_registro, '$formato') AS formato
        FROM usuarios 
        WHERE tipo_Usuario = 'Jugador'
        GROUP BY sexo, formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerCantidadDeUsuariosPorGrupoDeEdadPorPeriodo($periodo){
        $formato = $this->obtenerPeriodo($periodo);
        $sql = "SELECT CASE 
            WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 18 THEN 'Menores'
            WHEN TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) >= 60 THEN 'Jubilados'
            ELSE 'Medio'
        END AS grupo_edad, 
        COUNT(*) AS cantidad, DATE_FORMAT(fecha_registro, '$formato') AS formato
        FROM usuarios
        WHERE tipo_Usuario = 'Jugador'
        GROUP BY grupo_edad, formato
        ORDER BY formato";

        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    private function obtenerPeriodo($periodo){
        switch ($periodo) {
            case 'dia':
                $formato = "%Y-%m-%d";
                break;
            case 'semana':
                $formato = "%Y-%u";
                break;
            case 'año':
                $formato = "%Y";
                break;
            case 'mes':
            default:
                $formato = "%Y-%m";
                break;
        }
        return $formato;
    }
}