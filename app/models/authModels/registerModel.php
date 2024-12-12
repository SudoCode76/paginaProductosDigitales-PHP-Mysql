<?php
require_once __DIR__ . '/../../config/conexion.php';

class RegisterModel {
    private $conn;

    public function __construct(){
        global $conexion;
        $this->conn = $conexion;
    }

    public function register($usuario, $password, $rol){
        // Verificar si el usuario ya existe
        $checkSql = "SELECT * FROM usuarios WHERE usuario = ?";
        $checkStmt = $this->conn->prepare($checkSql);
        if ($checkStmt === false) {
            die('Error al preparar la consulta de verificación: ' . htmlspecialchars($this->conn->error));
        }
        $checkStmt->bind_param("s", $usuario);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        if ($result->num_rows > 0) {
            // Usuario ya existe
            $checkStmt->close();
            return false;
        }
        $checkStmt->close();

        // Insertar el nuevo usuario
        $insertSql = "INSERT INTO usuarios (usuario, password, roles_idroles) VALUES (?, ?, ?)";
        $insertStmt = $this->conn->prepare($insertSql);
        if ($insertStmt === false) {
            die('Error al preparar la consulta de inserción: ' . htmlspecialchars($this->conn->error));
        }
        $insertStmt->bind_param("ssi", $usuario, $password, $rol);
        $insertResult = $insertStmt->execute();
        if ($insertResult) {
            $insertStmt->close();
            return true;
        } else {
            $insertStmt->close();
            return false;
        }
    }
}
?>
