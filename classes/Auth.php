<?php

namespace System\Classes;

use System\Classes\Model;
use System\Classes\Controller;

class Auth {

    private $authLogged = null;
    private $authTable = null;
    private $authFieldUsername = null;
    private $authFieldPassword = null;
    private $authLogoutRedirectNickname = null;
    private $authMessageLogout = null;
    private $authMessageAccessDenied = null;
    private $authMessageInvalidPassword = null;
    private $authMessageInvalidStatus = null;
    private $message = null;
    private $usernames = null;
    private $password = null;

    public function set($params) {
        
        $this->setAuthTable(authTable);
        $this->setAuthFieldUsername(authFieldUsername);
        $this->setAuthFieldPassword(authFieldPassword);
        $this->setAuthLogoutRedirectNickname(authLogoutRedirectNickname);
        $this->setAuthMessageLogout(authMessageLogout);
        $this->setAuthMessageAccessDenied(authMessageAccessDenied);
        
        $pieces = explode(",", authFieldUsername);
        
        $array = [];
        foreach($pieces as $piece){
            $array[$piece] = $params["username"];
        }
       
        $this->setUsernames($array);
        $this->setPassword($params[authFieldPassword]);
        
        $this->existsUser();
        $this->user();
    }

    private function setUsernames($usernames) {
        $this->usernames = $usernames;
    }
    
    private function setPassword($password) {
        $this->password = $password;
    }
    
    private function setToken($token) {
        $this->token = $token;
    }

    private function setAuthTable($table_name) {
        $this->authTable = $table_name;
    }

    private function setAuthMessageLogout($message_logout) {
        $this->authMessageLogout = $message_logout;
    }

    private function setAuthLogoutRedirectNickname($redirect_nickname) {
        $this->authLogoutRedirectNickname = $redirect_nickname;
    }

    private function setAuthMessageAccessDenied($access_denied) {
        $this->authMessageAccessDenied = $access_denied;
    }

    private function setAuthMessageInvalidPassword($invalid_password) {
        $this->authMessageInvalidPassword = $invalid_password;
    }

    private function setAuthMessageInvalidStatus($invalid_status) {
        $this->authMessageInvalidStatus = $invalid_status;
    }

    private function setAuthFieldUsername($field_username) {
        $this->authFieldUsername = $field_username;
    }

    private function setAuthFieldPassword($field_password) {
        $this->authFieldPassword = $field_password;
    }

    private function setLogged($Logged) {
        $this->authLogged = $Logged;
    }

    private function setMessage($message) {
        $this->message = $message;
    }
    
    public function getUsernames() {
        return $this->usernames;
    }
    
    public function getPassword() {
        return $this->password;
    }

    private function getAuthMessageLogout() {
        return $this->authMessageLogout;
    }

    private function getAuthLogoutRedirectNickname() {
        return $this->authLogoutRedirectNickname;
    }

    private function getAuthMessageAccessDenied() {
        return $this->authMessageAccessDenied;
    }

    private function getAuthMessageInvalidPassword() {
        return $this->authMessageInvalidPassword;
    }

    private function getAuthMessageInvalidStatus() {
        return $this->authMessageInvalidStatus;
    }

    private function getAuthTable() {
        return $this->authTable;
    }

    private function getAuthFieldUsername() {
        return $this->authFieldUsername;
    }

    private function getAuthFieldPassword() {
        return $this->authFieldPassword;
    }

    public function getMessage() {
        return $this->message;
    }

    private function existsUser() {

        $params = [];

        $users = Model::drive($this->getAuthTable());
        $logical_operator = ['='];
        $users->select('*')->conditions($this->getUsernames(), $logical_operator, "OR")->execute();
                
        $row = $users->get();
        
        if (isset($row[0])) {
            $user = $row[0];
            if ($user["status"]) {
                $Controller = new Controller();
                if ($Controller->verifyPassword($this->getPassword(), $user[$this->getAuthFieldPassword()])) {
                    
                    foreach ($user as $name => $value) {
                        $_SESSION[$name] = $value;
                    }
                    
                    $this->setLogged(true);
                    $this->setMessage("Olá {$user['username']}, seja bem-vindo(a)!");
                } else {
                    $this->invalidPassword();
                }
            } else {
                $this->invalidStatus();
            }
        } else {
            $this->denied();
        }
       
    }

    public function logged() {

        foreach (authFieldUsername as $username) {
            if (isset($_SESSION[$username]) && isset($_SESSION[authFieldPassword])) {
                $this->setLogged(true);
                return $this->authLogged;
            }
        }

        $this->setLogged(false);
        return $this->authLogged;
    }

    public function user() {
        $user = null;
        foreach (authFieldUsername as $username) {
            if (isset($_SESSION[$username]) && isset($_SESSION[authFieldPassword])) {
                return (object) $_SESSION;
            }
        }
        return $user;
    }

    public function allows($allow_type) {
        if (isset($_SESSION[authFieldUsername]) && isset($_SESSION[authFieldPassword])) {
            $allows = explode(",", $_SESSION["allow"]);
            if (in_array($allow_type, $allows)) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function die($username = null) {

        $this->setAuthLogoutRedirectNickname(authLogoutRedirectNickname);
        $this->setAuthMessageLogout(authMessageLogout);
        $this->setAuthMessageAccessDenied(authMessageAccessDenied);

        session_destroy();
        session_start();

        $Controller = new Controller();
        $Controller->refer($this->getAuthLogoutRedirectNickname(), "success", $this->getAuthMessageLogout(), [$username]);
        exit;
    }

    public function denied() {

        $this->setAuthMessageAccessDenied(authMessageAccessDenied);

        session_destroy();
        session_start();

        $Controller = new Controller();
        $Controller->refer($this->getAuthLogoutRedirectNickname(), "error", $this->getAuthMessageAccessDenied());
        exit;
    }

    public function invalidPassword() {

        $this->setAuthMessageInvalidPassword(authMessageInvalidPassword);

        session_destroy();
        session_start();

        $Controller = new Controller();
        $Controller->refer($this->getAuthLogoutRedirectNickname(), "error", $this->getAuthMessageInvalidPassword());
        exit;
    }

    public function invalidStatus() {

        $this->setAuthMessageInvalidStatus(authMessageInvalidStatus);

        session_destroy();
        session_start();

        $Controller = new Controller();
        $Controller->refer($this->getAuthLogoutRedirectNickname(), "error", $this->getAuthMessageInvalidStatus());
        exit;
    }

}
