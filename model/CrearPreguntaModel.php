<?php

class CrearPreguntaModel
{
    private $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function conseguirIdMasAltoPregunta(){
        $sql="SELECT MAX(id_incremental) AS id_mas_alto FROM preguntas";
        $result = $this->db->query($sql);
        return $result[0]["id_mas_alto"];
    }
    public function agregarPregunta($pregunta,$categoria){
        $sql="INSERT INTO preguntas (pregunta,estado,verificado,id_usuario,id_categoria) VALUES ('$pregunta',0,1,1,'$categoria')";
        $this->db->query($sql);
    }
    public function agregarOpciones($opcion1,$opcion2,$opcion3,$opcion4,$esCorrecta){
        $preguntaID=$this->conseguirIdMasAltoPregunta();
        switch($esCorrecta){
            case 1:
                $sql="INSERT INTO opciones(pregunta_id,opcion,es_correcta)
                        VALUES ($preguntaID,'$opcion1',1),
                               ($preguntaID,'$opcion2',0),
                               ($preguntaID,'$opcion3',0),
                               ($preguntaID,'$opcion4',0)";
                $this->db->query($sql);
                break;
            case 2:
                $sql="INSERT INTO opciones(pregunta_id,opcion,es_correCTA)
                        VALUES ($preguntaID,'$opcion1',0),
                               ($preguntaID,'$opcion2',1),
                               ($preguntaID,'$opcion3',0),
                               ($preguntaID,'$opcion4',0)";
                $this->db->query($sql);
                break;
            case 3:
                $sql="INSERT INTO opciones(pregunta_id,opcion,es_correcta)
                        VALUES ($preguntaID,'$opcion1',0),
                               ($preguntaID,'$opcion2',0),
                               ($preguntaID,'$opcion3',1),
                               ($preguntaID,'$opcion4',0)";
                $this->db->query($sql);
                break;
            case 4:
                $sql="INSERT INTO opciones(pregunta_id,opcion,es_correcta)
                       VALUES ($preguntaID,'$opcion1',0),
                              ($preguntaID,'$opcion2',0),
                              ($preguntaID,'$opcion3',0),
                              ($preguntaID,'$opcion4',1)";
                $this->db->query($sql);
                break;

        }
    }
}