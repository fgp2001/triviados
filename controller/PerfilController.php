<?php
class PerfilController
{
    private $model;
    private $view;

    public function __construct($model, $view)
    {
        $this->model = $model;
        $this->view = $view;

    }


    public function show()
    {
        session_start();

        if (!isset($_SESSION['id_incremental'])) {
            header('Location: index.php');
            exit();
        }
       $id = $_SESSION['id_incremental'];
        $datos = $this->model->obtenerDatosUsuario($id);
        if($datos){
            $this->view->render('PerfilView', $datos);
        }else {
            $this->view->render('Error', ['mensaje' => 'No se pudo cargar el perfil.']);
        }
    }


}
