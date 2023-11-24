<?php
namespace App\Model;
use System\Classes\Model;

class UsersModel extends Model {

    public function selectAll($where = null) {
        $users = $this->drive("users");
        if ($where == null) {
            $users->select("*")->execute();
        } else {
            $logical_operator = ["!="];
            $users->select("*")->conditions($where, $logical_operator)->execute();
        }
        return $users->get();
    }

    public function delUserID($id) {
        $where["id"] = $id;
        $users = Model::drive('users');
        $users->delete()->conditions($where)->execute();
        return true;
    }

    public function existsLogin($username) {
        $users = $this->drive("users");
        $params = ["username" => $username];
        $users->select("*")->conditions($params, ["="])->execute();
        $row = $users->get();

        if (isset($row[0])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsers($username) {
        $users = $this->drive("users");
        $params = ["username" => $username];
        $users->select("*")->conditions($params, ["="])->execute();
        $row = $users->get();
        return json_decode(json_encode($row[0]));
    }

    public function getUsersId($id) {
        $users = $this->drive("users");
        $params = ["id" => $id];
        $users->select("*")->conditions($params, ["="])->execute();
        return json_decode(json_encode($users->get()));
    }
    
    public function getUsersAll() {
        $users = $this->drive("users");
        $users->select("*")->orderBy(["name"], "asc")->execute();
        $row = $users->get();
        return json_decode(json_encode($row));
    }

    public function insert($params) {
        $users = $this->drive("users");
        $users->insert($params)->execute();
        return true;
    }

    public function update($params, $where) {
        $users = $this->drive("users");
        $users->update($params)->conditions($where)->execute();
        return true;
    }
    
    public function getDistinctUsersAllDepartment() {
        $users = $this->drive("users");

        $where = ['id' => 0, 'department' => 'NULL'];
        $logical_operator = ['!=', '!='];

        $users->select(["department"])->distinct()->conditions($where, $logical_operator)->orderBy(["department"], "asc")->execute();
        $row = $users->get();
        return json_decode(json_encode($row), true);
    }

}
