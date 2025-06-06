<?php

class PartidaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function crearPartida($id_usuario){
        $fecha_inicio = date('Y-m-d H:i:s');
        $estado = 1; // Activa
        $puntaje_obtenido = 0;

        $sql = "INSERT INTO partida (id_usuario, fecha_inicio, estado, puntaje_obtenido) VALUES ($id_usuario, '$fecha_inicio', $estado, $puntaje_obtenido)";
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $this->db->getLastInsertId();
        }
        return false;

    }

    public function obtenerSiguientePregunta($id_partida) {
        $sql = "SELECT id_usuario FROM partida WHERE id_incremental = $id_partida";
        $res = $this->db->query($sql);
        if(!$res) return false;
        $id_usuario = $res[0]["id_usuario"];

        //Obtener preguntas respondidas por usuario
        $sql = "SELECT id_pregunta FROM usuario_pregunta WHERE id_usuario = $id_usuario AND entregado = 1";
        $preguntas_respondidas = $this->db->query($sql);
        $ids_respondidas = array_column($preguntas_respondidas, 'id_pregunta');
        $excluir = count($ids_respondidas) > 0 ? implode(',', $ids_respondidas) : 0;


        //Obtener siguiente pregunta no respondida
        $sql = "SELECT * FROM preguntas WHERE id_incremental NOT IN ($excluir) LIMIT 1";
        $pregunta = $this->db->query($sql);
        if (!$pregunta) return false;

        $pregunta = $pregunta[0];

        //Obtener opciones de esta pregunta
        $id_pregunta = $pregunta["id_incremental"];
        $sqlOpciones = "SELECT * FROM opciones WHERE pregunta_id = $id_pregunta";
        $opciones = $this->db->query($sqlOpciones);
        $pregunta['opciones'] = $opciones;
        $pregunta['opciones'] = $opciones ? $opciones : [];

        return $pregunta;
    }

    public function guardarRespuesta($id_usuario, $id_pregunta, $id_opcion, $id_partida){
        //Verificamos si la opcion que se ingreso fue correcta
        $sql = "SELECT es_correcta FROM opciones WHERE id_incremental = $id_opcion AND id_pregunta = $id_pregunta";
        $res = $this->db->query($sql);
        if (!$res) return false;
        $es_correcta = $res[0]["es_correcta"];

        //Se guarda en usuario_pregunta la respuesta del usuario
        $entregado = 1;
        $respondido_correcto = $es_correcta ? 1 : 0;

        //Verifica si ya existe registro para esta pregunta y usuario
        $sqlChequeo = "SELECT * FROM usuario_pregunta WHERE id_pregunta = $id_pregunta AND id_usuario = $id_usuario";
        $existe = $this->db->query($sqlChequeo);
        if ($existe) {
            //Actualiza el registro
            $sqlUpdate = "UPDATE usuario_pregunta SET entregado = $entregado, respondido_correcto = $respondido_correcto WHERE id_pregunta = $id_pregunta AND id_usuario = $id_usuario";
            $this->db->query($sqlUpdate);
        } else {
            //Crea nuevo registro
            $sqlInsert = "INSERT INTO usuario_pregunta (id_pregunta, id_usuario, entregado, respondido_correcto) VALUES ($id_pregunta, $id_usuario, $entregado, $respondido_correcto)";
            $this->db->query($sqlInsert);
        }

        if ($es_correcta){
            //Se incrementa el puntaje de la partida
            $sqlPuntaje = "UPDATE partida SET puntaje_obtenido = puntaje_obtenido + 1 WHERE id_incremental = $id_partida";
            $this->db->query($sqlPuntaje);
            return true;
        } else{
            //Cambia el estado a partida finalizada ya que no es correcta
            $sqlEstado = "UPDATE partida SET estado = 0 WHERE id_incremental = $id_partida";
            $this->db->query($sqlEstado);
            return false;
        }

    }
}