<?php

namespace System\Classes;
use System\Classes\DataBuilding;

class Model {

    static function drive($use = null) {
        return new DataBuilding($use);
    }
    
    public function test() {
        return Model::drive()->test();
    }

}
