<?php

namespace System\Classes;

class View {

    private $theme = "anna";
    private $lang = "pt-br";
    private $charset = "utf-8";
    private $title = PAGE_TITLE;
    private $viewPath = null;

    public function autoLayout($set_layout) {
        $this->theme = $set_layout;
    }

    public static function flashSuccess() {
        if (isset($_SESSION["success"])) {
            $message = $_SESSION["success"];
            unset($_SESSION["success"]);
            return $message;
        }
    }

    public static function flashError() {
        if (isset($_SESSION["error"]) && $_SESSION["error"] != "") {
            $message = $_SESSION["error"];
            unset($_SESSION["error"]);
            return $message;
        }
    }

    public function renderTheme($viewPath, $title = null, $_args = null) {

        $this->viewPath = $viewPath;
        $_theme = $this->theme;
        ($title == null) ? $_title = $this->title : $_title = $title;
        $_lang = $this->lang;
        $_charset = $this->charset;

        if (is_array($_args) && sizeof($_args) != 0) {
            @extract($_args);
            ob_start();
        }

        $_base = function ($path, $theme = null) {
            if ($theme == null)
                $base = BASEURL . "/www/" . $this->theme . '/' . $path;
            else
                $base = BASEURL . "/www/" . $theme . '/' . $path;

            return $base;
        };

        $_baseTheme = function ($path) {
            $base = DIR . DS . "themes" . DS . $this->theme . DS . $path;
            return $base;
        };

        $_element = function ($file_element) {

            if ($file_element != null) {
                $filename = DIR . DS . "themes" . DS . $this->theme . DS . 'elements' . DS;
                $file = str_replace('.phtml', '', $file_element);
                $filename = $filename . $file . '.phtml';
                return $filename;
            }
            return $file_element;
        };

        $_css = function ($file_css) {
            if ($file_css != null) {
                $filename = BASEURL . "/www/" . $this->theme . '/css/';
                if ($file_css[0] == "/") {
                    $filename = BASEURL . "/www/" . $this->theme . '/css/';
                    $filename = rtrim($filename, '/');
                }
                $file = str_replace('//', '/', $file_css);
                $file = str_replace('.css', '', $file_css);
                $filename = $filename . $file . '.css';
                return $filename;
            }
            return $file_css;
        };

        $_js = function ($file_js) {
            if ($file_js != null) {
                $filename = BASEURL . "/www/" . $this->theme . '/js/';
                if ($file_js[0] == "/") {
                    $filename = BASEURL . "/www/" . $this->theme . '/js/';
                    $filename = rtrim($filename, '/');
                }
                $file = str_replace('//', '/', $file_js);
                $file = str_replace('.js', '', $file_js);
                $filename = $filename . $file . '.js';
                return $filename;
            }
            return $file_js;
        };

        $_img = function ($file_img) {
            if ($file_img != null) {
                $filename = BASEURL . "/www/" . $this->theme . '/assets/img/';
                if ($file_img[0] == "/") {
                    $filename = BASEURL . "/www/" . $this->theme . '/assets/img/';
                    $filename = rtrim($filename, '/');
                }
                $filename = $filename . $file_img;
                return $filename;
            }
            return $file_img;
        };

        $_Auth = function () {
            $auth = new Auth();
            if ($auth->user() != null) {
                $user = $auth->user();
                $user->logged = $auth->logged();
            } else {
                $user["logged"] = $auth->logged();
                $user = (object) $user;
            }
            return $user;
        };

        $_allows = function ($allow_type) {
            $auth = new Auth();
            if ($auth->user() != null) {
                $user = $auth->user();
                $allows = explode(",", $auth->user()->allow);
                if (in_array($allow_type, $allows)) {
                    return true;
                } else {
                    return false;
                }
            }
        };

        $_date_format = function ($data, $type = null) {
            if ($type == "timestamp") {
                $expld1 = explode(" ", $data);
                $expld2 = explode("-", $expld1[0]);
                return "{$expld2[2]}/{$expld2[1]}/{$expld2[0]} {$expld1[1]}";
            } else if ($type == "get_dt_timestamp") {
                $expld1 = explode(" ", $data);
                $expld2 = explode("-", $expld1[0]);
                return "{$expld2[2]}/{$expld2[1]}/{$expld2[0]}";
            } else {
                $expld2 = explode("-", $data);
                return "{$expld2[2]}/{$expld2[1]}/{$expld2[0]}";
            }
        };

        $_refer = function ($link = null) {
            return BASEURL . "/" . $link;
        };

        $_format_ship_name = function ($ship_name = null) {
            $pos = strpos($ship_name, '&;');
            if ($pos === false) {
                return $ship_name;
            } else {
                $expld = explode('&;', $ship_name);
                return trim($expld[1]);
            }
        };

        $_link_paginator = function ($indice, $url, $isActive = false) {
            $lk = "<li class='page-item'>";
            if ($isActive) {
                $lk .= "<a class='page-link active' href='{$url}'>{$indice}</a>";
            } else {
                $lk .= "<a class='page-link' href='{$url}'>{$indice}</a>";
            }
            $lk .= "</li>";
            return $lk;
        };

        $_data_post = function(){

            return [
                [
                  'id' => 1,
                  'title' => 'Programando em PHP',
                  'description' => 'Neste post você vai aprender tudo que precisa para ser um bom programador de PHP!',
                  'tags' => ['programação', 'PHP', 'lógica de programação'],
                  'img' => 'prog-1.jpg'
                ],
                [
                  'id' => 2,
                  'title' => 'Orientação a Objetos com Java',
                  'description' => 'Aprenda o paradigma de orientação a objetos com Java, uma linguagem em alta no mercado.',
                  'tags' => ['Java', 'OOP', 'Programação Avançada'],
                  'img' => 'prog-2.jpg'
                ],
                [
                  'id' => 3,
                  'title' => 'A importância da lógica de programação',
                  'description' => 'A lógica de programação é o ponto inicial de muitos estudantes de programação, será que é importante?',
                  'tags' => ['lógica', 'programação', 'algoritmos'],
                  'img' => 'prog-3.jpg',
                ],
                [
                  'id' => 4,
                  'title' => 'Programando em PHP',
                  'description' => 'Neste post você vai aprender tudo que precisa para ser um bom programador de PHP!',
                  'tags' => ['programação', 'PHP', 'lógica de programação'],
                  'img' => 'prog-4.jpg'
                ],
              ];

        };

        include $_baseTheme("themes.phtml");
    }

}
