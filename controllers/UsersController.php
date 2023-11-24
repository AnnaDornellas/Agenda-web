<?php

use System\Classes\Auth;
use System\Classes\Controller;
use App\Model\UsersModel;
use App\Behavior\MainBehavior;
use App\Behavior\LabelsBehavior;

require_once DIR . DS . "models" . DS . "UsersModel.php";

class UsersController extends Controller {

    public function __construct($viewPath) {
        $this->viewPath = $viewPath;
    }

    public function index($_args = []) {

        $this->title = "Lista de Usuários";

        $auth = new Auth();
        if ($auth->logged() && $auth->allows("usuarios")) {
            $UsersModel = new UsersModel();
            $_args["users"] = $UsersModel->selectAll(["id" => $auth->user()->id]);
        } else {
            $auth->die();
        }

        $this->renderView($_args);
    }

    public function add($_args = []) {

        $this->title = "Novo Usuário";
        $_args["error"] = false;

        (isset($_POST["allow"])) ? $_args["allow"] = $_POST["allow"] : $_args["allow"] = "Gestor";
        (isset($_POST["name"])) ? $_args["name"] = $_POST["name"] : $_args["name"] = "";
        (isset($_POST["username"])) ? $_args["email"] = $_POST["email"] : $_args["email"] = "";
        (isset($_POST["registration"])) ? $_args["registration"] = $_POST["registration"] : $_args["registration"] = "";
        (isset($_POST["email"])) ? $_args["email"] = $_POST["email"] : $_args["email"] = "";
        (isset($_POST["department"])) ? $_args["department"] = $_POST["department"] : $_args["department"] = "";
        (isset($_POST["tel"])) ? $_args["tel"] = $_POST["tel"] : $_args["tel"] = "";

        $auth = new Auth();

        if ($auth->logged() && $auth->allows("usuarios")) {
            if (isset($_POST["email"])) {
                $UsersModel = new UsersModel();
                $MainBehavior = new MainBehavior();
                if (!$UsersModel->existsLogin($_args["email"])) {
                    if ($MainBehavior->checkEmail($_args["email"])) {
                        $check = [];

                        if (isset($_POST["usuarios"]) && $_POST["usuarios"] == "on") {
                            $check[] = "usuarios";
                        }
                        if (isset($_POST["solicitacoes"]) && $_POST["solicitacoes"] == "on") {
                            $check[] = "solicitacoes";
                        }
                        if (isset($_POST["documentos_index"]) && $_POST["documentos_index"] == "on") {
                            $check[] = "documentos_index";
                        }
                        if (isset($_POST["documentos_add"]) && $_POST["documentos_add"] == "on") {
                            $check[] = "documentos_add";
                        }
                        if (isset($_POST["documentos_edit"]) && $_POST["documentos_edit"] == "on") {
                            $check[] = "documentos_edit";
                        }
                        if (isset($_POST["documentos_delete"]) && $_POST["documentos_delete"] == "on") {
                            $check[] = "documentos_delete";
                        }
                        if (isset($_POST["documentos_print"]) && $_POST["documentos_print"] == "on") {
                            $check[] = "documentos_print";
                        }
                        if (isset($_POST["rastreamento"]) && $_POST["rastreamento"] == "on") {
                            $check[] = "rastreamento";
                        }
                        if (isset($_POST["pesca_relatorios"]) && $_POST["pesca_relatorios"] == "on") {
                            $check[] = "pesca_relatorios";
                        }
                        if (isset($_POST["pesca_especies"]) && $_POST["pesca_especies"] == "on") {
                            $check[] = "pesca_especies";
                        }
                        if (isset($_POST["pesca_embarcacoes"]) && $_POST["pesca_embarcacoes"] == "on") {
                            $check[] = "pesca_embarcacoes";
                        }
                        if (isset($_POST["pesca_lances"]) && $_POST["pesca_lances"] == "on") {
                            $check[] = "pesca_lances";
                        }

                        $params["allow"] = implode(",", $check);
                        $params["name"] = $_args["name"];
                        $params["username"] = $_args["email"];
                        $params["phone"] = $_args["tel"];
                        $params["email"] = $_args["email"];
                        $params["department"] = $_args["department"];
                        $params["registration"] = $_args["registration"];
                        $params["password"] = $this->hashPassword("sutin");

                        if ($UsersModel->insert($params)) {
                            $this->refer("users");
                        }
                    } else {
                        $_args["error"] = "O e-mail <strong>" . $_args["email"] . "</strong> é inválido!";
                    }
                } else {
                    $_args["error"] = "O usuário <strong>" . $_args["email"] . "</strong> já existe no sistema!";
                }
            }
        } else {
            $auth->die();
        }

        $this->renderView($_args);
    }

    public function edit($_args = []) {

        $this->title = "Editar Usuário";
        $_args["error"] = false;

        $MainBehavior = new MainBehavior();
        $UsersModel = new UsersModel();

        if ($_args[0] != "" && $MainBehavior->isNumber($_args[0])) {
            $getUser = $UsersModel->getUsersId($_args[0]);
            foreach ($getUser as $obj) {
                $userE = $obj;
            }

            $_args["id"] = $userE->id;
            $_args["allow"] = $userE->allow;
            $_args["name"] = $userE->name;
            $_args["username"] = $userE->username;
            $_args["registration"] = $userE->registration;
            $_args["email"] = $userE->email;
            $_args["department"] = $userE->department;
            $_args["tel"] = $userE->phone;

            $_args["check"] = "";

            $vars = explode(",", $userE->allow);

            $_args["check_usuarios"] = "";
            $_args["check_solicitacoes"] = "";

            foreach ($vars as $name => $value) {
                switch ($value) {
                    case "usuarios":
                        $_args["check_usuarios"] = "checked";
                        break;
                    case "solicitacoes":
                        $_args["check_solicitacoes"] = "checked";
                        break;
                    case "documentos_index":
                        $_args["check_documentos_index"] = "checked";
                        break;
                    case "documentos_add":
                        $_args["check_documentos_add"] = "checked";
                        break;
                    case "documentos_edit":
                        $_args["check_documentos_edit"] = "checked";
                        break;
                    case "documentos_delete":
                        $_args["check_documentos_delete"] = "checked";
                        break;
                    case "documentos_print":
                        $_args["check_documentos_print"] = "checked";
                        break;
                    case "pesca_relatorios":
                        $_args["check_pesca_relatorios"] = "checked";
                        break;
                    case "pesca_especies":
                        $_args["check_pesca_especies"] = "checked";
                        break;
                    case "pesca_embarcacoes":
                        $_args["check_pesca_embarcacoes"] = "checked";
                        break;
                    case "pesca_lances":
                        $_args["check_pesca_lances"] = "checked";
                        break;
                }
            }
        } else {
            $this->refer("users");
        }

        $auth = new Auth();
        if ($auth->logged() && $auth->allows("usuarios")) {
            if (isset($_POST["name"])) {
                (isset($_POST["allow"])) ? $_args["allow"] = $_POST["allow"] : $_args["allow"];
                (isset($_POST["id"])) ? $_args["id"] = $_POST["id"] : $_args["id"];
                (isset($_POST["name"])) ? $_args["name"] = $_POST["name"] : $_args["name"];
                (isset($_POST["department"])) ? $_args["department"] = $_POST["department"] : $_args["department"];
                (isset($_POST["tel"])) ? $_args["tel"] = $_POST["tel"] : $_args["tel"] = "";
                (isset($_POST["cbox"])) ? $_args["check"] = $_POST["cbox"] : $_args["check"];
                (isset($_POST["cbox"])) ? $_args["check"] = $_POST["cbox"] : $_args["check"];

                if ($_args["check"] == "on") {
                    $params["password"] = $this->hashPassword("sutin");
                    $params["chpwd"] = 1;
                }

                $params["name"] = $_args["name"];

                $check = [];

                if (isset($_POST["usuarios"]) && $_POST["usuarios"] == "on") {
                    $check[] = "usuarios";
                }
                if (isset($_POST["solicitacoes"]) && $_POST["solicitacoes"] == "on") {
                    $check[] = "solicitacoes";
                }
                if (isset($_POST["documentos_index"]) && $_POST["documentos_index"] == "on") {
                    $check[] = "documentos_index";
                }
                if (isset($_POST["documentos_add"]) && $_POST["documentos_add"] == "on") {
                    $check[] = "documentos_add";
                }
                if (isset($_POST["documentos_edit"]) && $_POST["documentos_edit"] == "on") {
                    $check[] = "documentos_edit";
                }
                if (isset($_POST["documentos_delete"]) && $_POST["documentos_delete"] == "on") {
                    $check[] = "documentos_delete";
                }
                if (isset($_POST["documentos_print"]) && $_POST["documentos_print"] == "on") {
                    $check[] = "documentos_print";
                }
                if (isset($_POST["pesca_relatorios"]) && $_POST["pesca_relatorios"] == "on") {
                    $check[] = "pesca_relatorios";
                }
                if (isset($_POST["pesca_especies"]) && $_POST["pesca_especies"] == "on") {
                    $check[] = "pesca_especies";
                }
                if (isset($_POST["pesca_embarcacoes"]) && $_POST["pesca_embarcacoes"] == "on") {
                    $check[] = "pesca_embarcacoes";
                }
                if (isset($_POST["pesca_lances"]) && $_POST["pesca_lances"] == "on") {
                    $check[] = "pesca_lances";
                }

                $where["id"] = $_args["id"];
                $params["allow"] = implode(",", $check);
                $params["department"] = $_args["department"];
                $params["phone"] = $_args["tel"];

                if ($UsersModel->update($params, $where)) {
                    $this->refer("users");
                }
            }
            $this->renderView($_args);
        } else {
            $auth->die();
        }
    }

    public function delete($_args = []) {

        $this->title = "Excluir Usuário";
        $_args["error"] = false;

        $MainBehavior = new MainBehavior();
        $UsersModel = new UsersModel();

        if ($_args[0] != "" && $MainBehavior->isNumber($_args[0])) {
            $getUser = $UsersModel->getUsersId($_args[0]);

            foreach ($getUser as $obj) {
                $userE = $obj;
            }
            $_args["id"] = $userE->id;
            $_args["allow"] = $userE->allow;
            $_args["name"] = $userE->name;
            $_args["username"] = $userE->username;
            $_args["email"] = $userE->email;
            $_args["check"] = "";
        } else {
            $this->refer("users");
        }

        $auth = new Auth();
        if ($auth->logged() && $auth->allows("usuarios")) {
            if (isset($_POST["id"])) {
                (isset($_POST["id"])) ? $_args["id"] = $_POST["id"] : $_args["id"];
                (isset($_POST["cbox"])) ? $_args["check"] = $_POST["cbox"] : $_args["check"];

                if ($_args["check"] == "on") {
                    if ($UsersModel->delUserID($_args["id"])) {
                        $this->refer("users");
                    }
                }
            }
            $this->renderView($_args);
        } else {
            $auth->die();
        }
    }

    public function status($_args = []) {

        $this->title = "Status de Usuário";
        $_args["error"] = false;

        $MainBehavior = new MainBehavior();
        $UsersModel = new UsersModel();

        if ($_args[0] != "" && $MainBehavior->isNumber($_args[0])) {
            $getUser = $UsersModel->getUsersId($_args[0]);
            foreach ($getUser as $obj) {
                $userE = $obj;
            }
            $_args["id"] = $userE->id;
            ($userE->status) ? $_args["status"] = 0 : $_args["status"] = 1;
        } else {
            $this->refer("users");
        }

        $auth = new Auth();

        if ($auth->logged() && $auth->allows("usuarios")) {
            $params["status"] = $_args["status"];
            $where["id"] = $_args["id"];
            if ($UsersModel->update($params, $where)) {
                $this->refer("users");
            }
            $this->renderView($_args);
        } else {
            $auth->die();
        }

        $this->renderView($_args);
    }

    public function allows($_args = []) {

        $this->title = "Permissões de Usuário";
        $_args["error"] = false;

        $MainBehavior = new MainBehavior();
        $UsersModel = new UsersModel();

        if ($_args[0] != "" && $MainBehavior->isNumber($_args[0])) {
            $getUser = $UsersModel->getUsersId($_args[0]);
            foreach ($getUser as $obj) {
                $userE = $obj;
            }
            $_args["id"] = $userE->id;
            $_args["allow"] = $userE->allow;
            $_args["name"] = $userE->name;
            $_args["username"] = $userE->username;
            $_args["email"] = $userE->email;

            $vars = explode(",", $userE->allow);

            $_args["check_usuarios"] = "";
            $_args["check_solicitacoes"] = "";

            foreach ($vars as $name => $value) {
                switch ($value) {
                    case "usuarios":
                        $_args["check_usuarios"] = "checked";
                        break;
                    case "solicitacoes":
                        $_args["check_solicitacoes"] = "checked";
                        break;
                    case "documentos_index":
                        $_args["check_documentos_index"] = "checked";
                        break;
                    case "documentos_add":
                        $_args["check_documentos_add"] = "checked";
                        break;
                    case "documentos_edit":
                        $_args["check_documentos_edit"] = "checked";
                        break;
                    case "documentos_delete":
                        $_args["check_documentos_delete"] = "checked";
                        break;
                    case "documentos_print":
                        $_args["check_documentos_print"] = "checked";
                        break;
                    case "pesca_relatorios":
                        $_args["check_pesca_relatorios"] = "checked";
                        break;
                    case "pesca_especies":
                        $_args["check_pesca_especies"] = "checked";
                        break;
                    case "pesca_embarcacoes":
                        $_args["check_pesca_embarcacoes"] = "checked";
                        break;
                    case "pesca_lances":
                        $_args["check_pesca_lances"] = "checked";
                        break;
                }
            }
        } else {
            $this->refer("users");
        }

        if ($_args[0] != "" && $MainBehavior->isNumber($_args[0])) {
            $getUser = $UsersModel->getUsersId($_args[0]);
            foreach ($getUser as $obj) {
                $userE = $obj;
            }
            $_args["id"] = $userE->id;
            ($userE->status) ? $_args["status"] = 0 : $_args["status"] = 1;
        } else {
            $this->refer("users");
        }

        $auth = new Auth();
        if ($auth->logged() && $auth->allows("usuarios")) {

            if (isset($_POST["action"])) {
                $check = [];

                if (isset($_POST["usuarios"]) && $_POST["usuarios"] == "on") {
                    $check[] = "usuarios";
                }
                if (isset($_POST["solicitacoes"]) && $_POST["solicitacoes"] == "on") {
                    $check[] = "solicitacoes";
                }
                if (isset($_POST["documentos_index"]) && $_POST["documentos_index"] == "on") {
                    $check[] = "documentos_index";
                }
                if (isset($_POST["documentos_add"]) && $_POST["documentos_add"] == "on") {
                    $check[] = "documentos_add";
                }
                if (isset($_POST["documentos_edit"]) && $_POST["documentos_edit"] == "on") {
                    $check[] = "documentos_edit";
                }
                if (isset($_POST["documentos_delete"]) && $_POST["documentos_delete"] == "on") {
                    $check[] = "documentos_delete";
                }
                if (isset($_POST["documentos_print"]) && $_POST["documentos_print"] == "on") {
                    $check[] = "documentos_print";
                }
                if (isset($_POST["pesca_relatorios"]) && $_POST["pesca_relatorios"] == "on") {
                    $check[] = "pesca_relatorios";
                }
                if (isset($_POST["pesca_especies"]) && $_POST["pesca_especies"] == "on") {
                    $check[] = "pesca_especies";
                }
                if (isset($_POST["pesca_embarcacoes"]) && $_POST["pesca_embarcacoes"] == "on") {
                    $check[] = "pesca_embarcacoes";
                }
                if (isset($_POST["pesca_lances"]) && $_POST["pesca_lances"] == "on") {
                    $check[] = "pesca_lances";
                }

                $where["id"] = $_args["id"];
                $params["allow"] = implode(",", $check);
                if ($UsersModel->update($params, $where)) {
                    $this->refer("users");
                }
            }

            $this->renderView($_args);
        } else {
            $auth->die();
        }
    }

    public function ajax_users_department_distinct_all($_args) {
        $this->title = "Render Users Department";
        $this->autoLayout("ajax");

        $_args["error"] = false;

        $auth = new Auth();
        if ($auth->logged() && $auth->allows("usuarios")) {
            $UsersModel = new UsersModel();
            $_args["ajax_users_department_distinct_all"] = $UsersModel->getDistinctUsersAllDepartment();
        } else {
            $auth->die();
        }

        $this->renderView($_args);
    }

}
