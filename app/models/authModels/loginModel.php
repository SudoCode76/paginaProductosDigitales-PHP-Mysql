<?php
require_once __DIR__ . '/../../config/conexion.php';

class LoginModel {
    private $conn;

    public function __construct(){
        global $conexion;
        $this->conn = $conexion;
    }

    public function login($usuario, $password){
        $sql = "SELECT * from usuarios JOIN roles ON usuarios.roles_idroles = roles.idroles WHERE usuarios.usuario = ? AND usuarios.password = ?";


        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }
}
?>
