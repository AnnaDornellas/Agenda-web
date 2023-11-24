<?php

namespace System\Classes;

use System\Classes\View;

class Controller extends View {

    public $viewPath = null;
    public $title = null;

    public function renderView($_args = null) {
        $_args["_controller"] = XCONTROLLER;
        $_args["_action"] = XACTION;

        $this->renderTheme($this->viewPath, $this->title, $_args);
    }

    public function hashPassword($password) {
        $options = [
            'cost' => 12
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public function verifyPassword($password, $hash) {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

    public function refer($link, $type = null, $message = null, $_args = null) {

        $textMessage = $this->replaceMessage($message, $_args);

        if ($type == "error") {
            $_SESSION["error"] = $textMessage;
        } else {
            $_SESSION["success"] = $textMessage;
        }

        header("Location: " . BASEURL . "/" . $link);
        exit;
    }

    public function replaceMessage($message, $_args = null) {

        if ($_args == null) {
            return $message;
        } else {
            $explds = explode("%s", $message);
            $txt = "";
            $i = 0;

            foreach ($explds as $expld) {
                if (isset($_args[$i]))
                    $txt .= $expld . $_args[$i];
                else
                    $txt .= $expld;
                $i++;
            }
            return $txt;
        }
    }

    public function convertFloatToDateTime($timeFloat, $isDateTime = false) {
        if (is_null($timeFloat) || trim($timeFloat) == '') {
            return null;
        }
        if ($isDateTime) {
            $str = date("d-m-Y H:i:s", strtotime("+0 second", $timeFloat));
        } else {
            $str = date("d-m-Y", strtotime("+0 second", $timeFloat));
        }
        return (false != $str) ? $str : null;
    }

    public function recaptcha($recaptcha) {
        $data = array(
            "secret" => '6Leo_TAiAAAAAD57zTT33ZWpfcqN5EpSUEFf4D0_',
            "response" => $recaptcha
        );

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_PROXY, '1.1.1.1');
        curl_setopt($curl, CURLOPT_PROXYPORT, '3128');

        curl_setopt($curl, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        $result = json_decode(curl_exec($curl));
        curl_close($curl);

        if (isset($result->success) && $result->success) {
            return true;
        } else {
            return false;
        }
    }

    public function reverseHTMLcomments($subject) {
        $_args = ["&aacute;", "&Aacute;", "&atilde;", "&Atilde;", "&acirc;", "&Acirc;", "&agrave;", "&Agrave;", "&eacute;", "&Eacute;", "&ecirc;", "&Ecirc;", "&iacute;", "&Iacute;", "&oacute;", "&Oacute;", "&otilde;", "&Otilde;", "&ocirc;", "&Ocirc;", "&uacute;", "&Uacute;", "&ccedil;", "&Ccedil;"];
        $_replace = ["á", "Á", "ã", "Ã", "â", "Â", "à", "À", "é", "É", "ê", "Ê", "í", "Í", "ó", "Ó", "õ", "Õ", "ô", "Ô", "ú", "Ú", "ç", "Ç"];
        $output = str_replace($_args, $_replace, $subject);
        return $output;
    }

}
