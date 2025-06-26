<?php

class LogoutController
{

    public function ejecutar()
    {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /triviados/Login/show?mensaje=sesion_cerrada");
        exit();
    }

}