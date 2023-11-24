<?php

namespace App\Behavior;

class MainBehavior {

    public function __construct() {
        
    }

    public function getCamelCase($name_file) {
        $name_file = str_replace("-", "_", $name_file);
        $name_file = explode("_", $name_file);

        $str = "";

        if (sizeof($name_file) == 0) {
            return ucfirst($name_file);
        } else {

            foreach ($name_file as $file) {
                $str .= ucfirst($file);
            }
            return $str;
        }
    }

    public function getMethod($name_file) {
        $name_file = str_replace("-", "_", $name_file);
        return strtolower($name_file);
    }

    public function checkEmail($email) {
        if (!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)) {
            return false;
        } else {
            return true;
        }
    }

    public function isNumber($number) {
        if (!preg_match("/^[0-9]*$/", $number)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkUsername($name) {
        if (!preg_match("/^[a-zA-Z0-9]+$/", $name)) {
            return false;
        } else {
            return true;
        }
    }

}
