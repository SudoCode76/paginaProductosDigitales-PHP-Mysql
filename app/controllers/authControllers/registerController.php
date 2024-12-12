<?php
require_once __DIR__ . '/../../models/authModels/registerModel.php';

class RegisterController {
    private $model;

    public function __construct(){
        $this->model = new RegisterModel();
    }

    public function register($usuario, $password, $rol){
        return $this->model->register($usuario, $password, $rol);
    }
}
?>
