<?php

use System\Classes\Controller;

class EstudantesController extends Controller {

    public function __construct($viewPath) {
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {
        $this->renderView($_args);
    }

    public function nomes($_args = []) {

        $_args["nome"] = $_args[0];
        $_args["idade"] = $_args[1];
        $_args["profissao"] = $_args[2];
        $_args["info"] = "Matriculas abertas";
        
        $_args["disciplinas"] = array("matemática", "português", "história", "Orientação a objetos", "ciências");
        
        $_args["disciplinas2"] = [0 => "matemática",
            1 => "português",
            3 => "história",
            4 => "Orientação a objetos",
            5 => "ciências"];

        $this->renderView($_args);
    }

}
