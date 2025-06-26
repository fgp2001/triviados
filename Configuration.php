<?php
require_once("core/Database.php");
require_once("core/FilePresenter.php");
require_once("core/MustachePresenter.php");
require_once("core/Router.php");

require_once("model/LoginModel.php");
require_once("controller/LoginController.php");
require_once("model/RegisterModel.php");
require_once("controller/RegisterController.php");
require_once ("controller/DashboardController.php");
require_once ("model/DashboardModel.php");
require_once ("controller/LobbyController.php");
require_once ("model/LobbyModel.php");
require_once ("model/PerfilModel.php");
require_once ("controller/PerfilController.php");
require_once ("controller/PartidaController.php");
require_once ("model/PartidaModel.php");
require_once ("controller/RankingController.php");
require_once ("model/RankingModel.php");
require_once ("controller/CrearPreguntaController.php");
require_once ("model/CrearPreguntaModel.php");
require_once("controller/PanelEditorController.php");
require_once("model/PanelEditorModel.php");
require_once("controller/GestionarPreguntaController.php");
require_once("model/GestionarPreguntaModel.php");
require_once("controller/LogoutController.php");


include_once('vendor/mustache/src/Mustache/Autoloader.php');

class Configuration
{
    public function getDatabase()
    {
        $config = $this->getIniConfig();

        return new Database(
            $config["database"]["server"],
            $config["database"]["user"],
            $config["database"]["dbname"],
            $config["database"]["pass"],
            $config["database"]["port"]

        );
    }

    public function getIniConfig()
    {
        return parse_ini_file("configuration/config.ini", true);
    }


   public function getLoginController(){
        return new loginController(
            new loginModel($this->getDatabase()),$this->getViewer()
        );
   }


    public function getRegisterController(){
        return new RegisterController(
            new RegisterModel($this->getDatabase()),
            $this->getViewer()
        );
    }

    public function getDashboardController(){
        return new DashboardController(
            new DashboardModel($this->getDatabase()),
            $this->getViewer()
        );
    }

    public function getLobbyController(){
        return new LobbyController(
            new LobbyModel($this->getDatabase()),
            $this->getViewer()
        );
    }
    public function getPerfilController(){
        return new PerfilController(
            new PerfilModel($this->getDatabase()),
                $this->getViewer()
        );
    }
    public function getPartidaController(){
        return new PartidaController(
            new PartidaModel($this->getDatabase()),
            $this->getViewer()
        );
    }
    public function getRankingController(){
        return new RankingController(
            new RankingModel($this->getDatabase()),
            $this->getViewer()
        );
    }
    public function getCrearPreguntaController(){
        return new CrearPreguntaController(
            new CrearPreguntaModel($this->getDatabase()),
            $this->getViewer()
        );
    }

    public function getPanelEditorController(){
        return new PanelEditorController(
            new PanelEditorModel($this->getDatabase()),
            $this->getViewer()
        );
    }

    public function getGestionarPreguntaController(){
        return new GestionarPreguntaController(
            new GestionarPreguntaModel($this->getDatabase()),
            $this->getViewer()
        );
    }

    public function getLogoutController()
    {
        return new LogoutController();
    }

    public function getRouter()
    {
        return new Router("getLoginController", "show", $this);
    }

    public function getViewer()
    {
        //return new FileView();
        return new MustachePresenter("view");
    }
}