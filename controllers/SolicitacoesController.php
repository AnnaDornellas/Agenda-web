<?php

use System\Classes\Controller;
use App\Behavior\LabelsBehavior;
use Egulias\EmailValidator;

class SolicitacoesController extends Controller {

    public function __construct($viewPath) {
        $this->autoLayout("default");
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {
       
        $_args["users"] = ["nome" => null, "email" => null];

        if ($_POST) {

            $_args["users"] = $_POST;
        }

        $this->renderView($_args);
    }

    public function update($_args = []) {
        $this->renderView($_args);
    }

    public function add($_args = []) {
        $this->renderView($_args);
    }

    public function delete($_args = []) {
        $this->renderView($_args);
    }

}
