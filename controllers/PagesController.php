<?php

use System\Classes\Controller;
use System\Classes\Auth;
use App\Model\UsersModel;
use App\Behavior\MainBehavior;
use App\Behavior\LabelsBehavior;

class PagesController extends Controller {

    public function __construct($viewPath) {
        $this->viewPath = $viewPath;
    }

    public function welcome($_args = []) {

        $this->renderView($_args);
    }

    public function contatos($_args = []) {

        $this->renderView($_args);
    }

    public function login($_args = []) {
        $this->autoLayout("default");
        $this->title = "Faça seu Login";

        if ($_POST) {

            $auth = new Auth();
            $auth->set($_POST);
            
          

            if ($auth->logged())
                $this->refer("ocupacoes");
            else
                $this->logout();

        }

        $this->renderView($_args);
    }

    public function logout($_args = []) {
        $this->autoLayout("default");
        $this->title = "Ops, saiu";

        $auth = new Auth();
        $auth->die($auth->user()->username);

        $this->renderView($_args);
    }

    public function register($_args = []) {
        $this->autoLayout("default");
        $this->title = "Cadastre-se";

        if ($_POST) {
            $params["username"] = $_POST["username"];
            $params["password"] = $this->hashPassword($_POST["password"]);

            $UsersModel = new UsersModel();
            $UsersModel->insert($params);

            $this->refer("login", "success", "Olá %s, seu cadastro foi efetuado com sucesso!", [$params["username"]]);
        }

        $this->renderView($_args);
    }

}
