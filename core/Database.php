<?php

class Database{

    private $conn;

    function __construct($servername, $username,$dbname, $password)
    {
        $this->conn = new Mysqli($servername, $username, $password, $dbname) or die("Error de conexion" . mysqli_connect_error());


    }

    public function query($sql){
        $result = $this->conn->query($sql);

        if ($result === false) {
            // Error en consulta
            return false;
        }

        if ($result === true) {
            // Para INSERT, UPDATE, DELETE
            return true;
        }

        // Para SELECT, devolver todos los registros en array asociativo
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    function __destruct(){
        $this->conn->close();
    }


}