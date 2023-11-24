<?php

use System\Classes\Controller;
use System\Classes\Auth;
use App\Model\UsersModel;
use App\Behavior\MainBehavior;
use App\Behavior\LabelsBehavior;

class AutomoveisController extends Controller {

    public function __construct($viewPath) {
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {
        
        
        $this->renderView($_args);
    }
    
    public function novo($_args = []) {
        
        
        $this->renderView($_args);
    }

}
