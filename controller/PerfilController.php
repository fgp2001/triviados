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
        $usuario = $_GET['nombre_usuario'] ?? 'Invitado';

        $perfilDatos = $this->model->getPerfilDatos($usuario);

        $this->view->render("Perfil", $perfilDatos);

    }

    public function mostrarQR(){
        require_once(__DIR__ . '/../libs/phpqrcode/qrlib.php');

        $usuario = $_GET['nombre_usuario'] ?? 'Invitado';

        $url = "/triviados/Perfil/show?nombre_usuario=" . urlencode($usuario);

        header('Content-Type: image/png');
        QRcode::png($url, false, QR_ECLEVEL_L, 6, 2);
        exit;
    }

}
