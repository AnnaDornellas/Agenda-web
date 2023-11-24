<?php

use System\Classes\Controller;
use App\Behavior\LabelsBehavior;

class ErrorController extends Controller {

    public function __construct($viewPath) {
//        $this->autoLayout("acqua");
        $this->viewPath = $viewPath;
    }
    
    public function not_found_403($_args = []) {
        $this->renderView($_args);
    }
    
    public function not_found_404($_args = []) {
        $this->renderView($_args);
    }
    
    public function not_found_500($_args = []) {
        $this->renderView($_args);
    }

}
