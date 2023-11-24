<?php

namespace App\Model;

use System\Classes\Model;

class OcupacoesModel extends Model {

    public function select($id = null) {
        $occupations = Model::drive('occupations');

        if ($id == null) {
            $occupations->select("*")->orderBy(["created"], "desc")->execute();
        } else {
            $params["id"] = $id;
            $occupations->select("*")->conditions($params)
                    ->orderBy(["created"], "desc")->execute();
        }

        $row = $occupations->get();

        if ($id == null) {
            if (isset($row[0])) {
                return $row;
            } else {
                return false;
            }
        } else {
            if (isset($row[0])) {
                return $row[0];
            } else {
                return false;
            }
        }
    }

    public function add($parametros) {
        $occupations = Model::drive('occupations');
        $occupations->insert($parametros)->execute();
        return true;
    }

    public function edit($parametros, $where) {
        $occupations = Model::drive('occupations');
        $occupations->update($parametros)->conditions($where)->execute();
        return true;
    }

    public function delete($where) {
        $occupations = Model::drive('occupations');
        $occupations->delete()->conditions($where)->execute();
        return true;
    }

}
