<?php

use System\Classes\Controller;
use App\Behavior\LabelsBehavior;
use Egulias\EmailValidator;

class AgendaController extends Controller {

    public function __construct($viewPath) {
        $this->autoLayout("default");
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {
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
