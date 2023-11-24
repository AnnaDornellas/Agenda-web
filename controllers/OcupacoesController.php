<?php

use System\Classes\Controller;
use App\Model\OcupacoesModel;
use System\Classes\Auth;

class OcupacoesController extends Controller {

    public function __construct($viewPath) {
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {

        $auth = new Auth();
        if(!$auth->logged()){
            $this->refer("login");
        }
        
        $OcupacoesModel = new OcupacoesModel();
        $_args["occupations"] = $OcupacoesModel->select();
        $this->renderView($_args);
    }

    public function add($_args = []) {
        
        $auth = new Auth();
        if(!$auth->logged()){
            $this->refer("login");
        }

        if ($_POST) {

            $parametros["name"] = $_POST["name"];
            $parametros["occupation"] = $_POST["occupation"];
            $parametros["email"] = $_POST["email"];

            $OcupacoesModel = new OcupacoesModel();

            if ($OcupacoesModel->add($parametros)) {
                $this->refer("ocupacoes");
            }
        }

        $this->renderView($_args);
    }

    public function delete($_args = []) {
        
        $auth = new Auth();
        if(!$auth->logged()){
            $this->refer("login");
        }

        $where["id"] = $_args[0];
        $OcupacoesModel = new OcupacoesModel();
        $OcupacoesModel->delete($where);
        $this->refer("ocupacoes");

        $this->renderView($_args);
    }

    public function edit($_args = []) {
        
        $auth = new Auth();
        if(!$auth->logged()){
            $this->refer("login");
        }

        $_args["id"] = $_args[0];

        $OcupacoesModel = new OcupacoesModel();
        $_args["pessoa"] = $OcupacoesModel->select($_args["id"]);

        if (!$_args["pessoa"]) {
            $this->refer("ocupacoes");
        }

        if ($_POST) {

            $parametros["name"] = $_POST["name"];
            $parametros["occupation"] = $_POST["occupation"];
            $parametros["email"] = $_POST["email"];

            $where["id"] = $_args["id"];

            $OcupacoesModel->edit($parametros, $where);
            $this->refer("ocupacoes");
        }

        $this->renderView($_args);
    }

}
