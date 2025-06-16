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
    public function obtenerUsuarioQueJuega($id_partida){
        $sql = "SELECT id_usuario FROM partida WHERE id_incremental = $id_partida";
        $res = $this->db->query($sql);
        if(!$res) return false;
        return $res[0]["id_usuario"];
    }
    public function calcularNivelDeUsuario($id_usuario){
        $sql = "SELECT preguntas_respondidas,puntaje FROM usuarios WHERE id_incremental = $id_usuario";
        $res = $this->db->query($sql);
        $preguntas = $res[0]["preguntas_respondidas"];
        $puntajes = $res[0]["puntaje"];
        if($preguntas >=5){
            $calculo=($puntajes/$preguntas)*100;
            if($calculo<=100&& $calculo>=66){
                $nivel=3;
            }
            elseif ($calculo<=65 && $calculo>=33){
                $nivel=2;
            }
            elseif ($calculo<=32 && $calculo>=0){
                $nivel=1;
            }
        }
        else{
            $nivel=2;
        }
        return $nivel;
    }
    public function calcularDificultadDePregunta($id_pregunta){
    $sql = "SELECT veces_entregada , veces_correcta FROM preguntas WHERE id_incremental = $id_pregunta";
    $res = $this->db->query($sql);
    $vecesEntregada = $res[0]["veces_entregada"];
    $vecesCorrecta = $res[0]["veces_correcta"];
    if($vecesEntregada >=5){
        $calculo=($vecesCorrecta/$vecesEntregada)*100;
        if($calculo<=100&& $calculo>=66){
            $dificultad=1;
        }
        elseif ($calculo<=65 && $calculo>=33){
            $dificultad=2;
        }
        elseif ($calculo<=32 && $calculo>=0){
            $dificultad=3;
        }
    }
    else{
        $dificultad=2;
    }
    return $dificultad;
    }
    public function obtenerPreguntasRespondidasPorUsuario($id_usuario){
        $sql = "SELECT id_pregunta FROM usuario_pregunta WHERE id_usuario = $id_usuario";
        $preguntas_respondidas = $this->db->query($sql);
        $ids_respondidas = array_column($preguntas_respondidas, 'id_pregunta');
        $excluir = count($ids_respondidas) > 0 ? implode(',', $ids_respondidas) : 0;
        return $excluir;
    }
    public function renovarDatosTablaPreguntaUsuario($limite, $id_usuario){
        if($limite==0){
            $sql="DELETE FROM usuario_pregunta WHERE id_usuario = $id_usuario";
            $this->db->query($sql);
        }
    }
    public function obtenerCuantasNoRespodidas($excluidas)
    {
        $sql = "SELECT COUNT(*) FROM preguntas WHERE estado=1 AND reportado=0 AND id_incremental NOT IN ($excluidas)";
        $res = $this->db->query($sql);
        return $res[0]["COUNT(*)"];

    }
    public function indicarEntregaPregunta($id_pregunta){
        $sql="UPDATE preguntas SET veces_entregada = veces_entregada + 1 WHERE id_incremental = $id_pregunta";
        $this->db->query($sql);
    }
    public function verificarCorrecta($id_opcion,$id_pregunta){
        $sql = "SELECT es_correcta FROM opciones WHERE id_incremental = $id_opcion AND pregunta_id = $id_pregunta";
        $res = $this->db->query($sql);
        $es_correcta = $res[0]["es_correcta"];
        return $es_correcta;
    }
    public function insertarEnTablaUsuarioPregunta($id_pregunta,$id_usuario){
        $sqlInsert = "INSERT INTO usuario_pregunta (id_pregunta, id_usuario) VALUES ($id_pregunta, $id_usuario)";
        $this->db->query($sqlInsert);
    }
    public function indicarUsuarioRespondioUnaPregunta($id_usuario){
        $sql = "UPDATE usuarios SET preguntas_respondidas= preguntas_respondidas +  1 WHERE id_incremental = $id_usuario";
        $this->db->query($sql);
    }
    public function sumarPuntajeUsuario($id_usuario){
        $sql="UPDATE usuarios SET puntaje=puntaje + 1 WHERE id_incremental =$id_usuario ";
        $this->db->query($sql);
    }
    public function obtenerUnaPreguntaNoRespondida($excluidas,$id_usuario){
        $limite=$this->obtenerCuantasNoRespodidas($excluidas);
        $this->renovarDatosTablaPreguntaUsuario($limite,$id_usuario);
        $numeroRandom=rand(0, $limite-1);
        $encontrado=false;
        $iteraciones=0;
        while($encontrado==false && $iteraciones<$limite) {
            $sql = "SELECT * FROM preguntas WHERE estado = 1 AND reportado = 0 AND id_incremental NOT IN ($excluidas)";
            $res = $this->db->query($sql);
            $pregunta = $res[$numeroRandom];
            $nivel = $this->calcularNivelDeUsuario($id_usuario);
            $dificultad = $this->calcularDificultadDePregunta($pregunta["id_incremental"]);
            if ($dificultad == $nivel) {
                $this->indicarEntregaPregunta($pregunta["id_incremental"]);
                $encontrado = true;
            } else {
                $iteraciones++;
            }
        }
        if($encontrado==false){
            $sql = "SELECT * FROM preguntas WHERE estado = 1 AND reportado = 0 AND id_incremental NOT IN ($excluidas)";
            $res = $this->db->query($sql);
            $pregunta=$res[$numeroRandom];
            $this->indicarEntregaPregunta($pregunta["id_incremental"]);
        }
        return $pregunta;
    }
    public function sumarPuntajePartida($id_partida){
        $sqlPuntaje = "UPDATE partida SET puntaje_obtenido = puntaje_obtenido + 1 WHERE id_incremental = $id_partida";
        $this->db->query($sqlPuntaje);
    }
    public function preguntaRespondidaCorrectamente($id_pregunta){
        $sql="UPDATE preguntas SET veces_correcta = veces_correcta +1  WHERE id_incremental = $id_pregunta";
        $this->db->query($sql);
    }
    public function perdioPartida($id_partida)
    {
        $sqlEstado = "UPDATE partida SET estado = 0 WHERE id_incremental = $id_partida";
        $this->db->query($sqlEstado);
    }

    public function obtenerSiguientePregunta($id_partida) {
        $id_usuario=$this->obtenerUsuarioQueJuega($id_partida);
        $excluidas=$this->obtenerPreguntasRespondidasPorUsuario($id_usuario);
        $pregunta =$this->obtenerUnaPreguntaNoRespondida($excluidas,$id_usuario);
        $id_pregunta = $pregunta["id_incremental"];
        $sql = "SELECT * FROM opciones WHERE pregunta_id = $id_pregunta";
        $opciones = $this->db->query($sql);
        $pregunta['opciones'] = $opciones;
        $pregunta['opciones'] = $opciones ? $opciones : [];

        $pregunta['color_categoria'] = $this->obtenerColorDeCategoriaDeUnaPregunta($id_pregunta);


        return $pregunta;
    }

    public function obtenerColorDeCategoriaDeUnaPregunta($id_pregunta){
        $sqlCategoriaId = "SELECT id_categoria FROM preguntas WHERE id_incremental = $id_pregunta LIMIT 1";
        $resultadoCategoriaId = $this->db->query($sqlCategoriaId);

        if(!$resultadoCategoriaId || count($resultadoCategoriaId) == 0) {
            return "transparent";
        }

        $categoriaId = $resultadoCategoriaId[0]["id_categoria"];

        $sqlCategoriaColor = "SELECT color FROM categorias WHERE id = $categoriaId LIMIT 1";
        $resultadoColor = $this->db->query($sqlCategoriaColor);

        if(!$resultadoColor || count($resultadoColor) == 0) {
            return "transparent";
        }

        $colorEsp = strtolower($resultadoColor[0]["color"]);
        // Traducción de español a CSS
        $traducciones = [
            'rojo' => 'red',
            'azul' => 'blue',
            'verde' => 'green',
            'amarillo' => 'yellow',
            'naranja' => 'orange',
            'violeta' => 'purple',
            'negro' => 'black',
            'blanco' => 'white',
            'gris' => 'gray',
        ];

        return $traducciones[$colorEsp] ?? 'transparent';

    }

    public function guardarRespuesta($id_usuario, $id_pregunta, $id_opcion, $id_partida)
    {
        $es_correcta=$this->verificarCorrecta($id_opcion,$id_pregunta);
        $this->insertarEnTablaUsuarioPregunta($id_pregunta,$id_usuario);
        $this->indicarUsuarioRespondioUnaPregunta($id_usuario);
        if ($es_correcta) {
            $this->sumarPuntajeUsuario($id_usuario);
            $this->sumarPuntajePartida($id_partida);
            $this->preguntaRespondidaCorrectamente($id_pregunta);
            return true;
        } else {
            $this->perdioPartida($id_partida);
            return false;


        function obtenerRanking()
        {
            $sql = "SELECT u.nombre_usuario, COUNT(up.respondido_correcto) AS respuestas_correctas
            FROM usuario u
            JOIN usuario_pregunta up ON u.id_incremental = up.id_usuario
            WHERE up.respondido_correcto = 1
            GROUP BY u.id_incremental
            ORDER BY respuestas_correctas DESC";

            return $this->db->query($sql);
        }
    }

    }
}