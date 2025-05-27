<?php
class PerfilModel {
    private $db;

    public function __construct($database){
        $this->db = $database;

    }
    public function obtenerDatosUsuario($id){
         $sql = "SELECT email, nombre_completo, fecha_nacimiento, sexo, pais, ciudad, nombre_usuario, foto_perfil
                FROM usuarios WHERE id_incremental = ?";
        $stmt = $this->db->prepare($sql);

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
return $resultado->fetch_assoc();
    }
}
