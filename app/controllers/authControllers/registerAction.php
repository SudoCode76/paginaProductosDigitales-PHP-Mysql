<?php
require_once __DIR__ . '/registerController.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_confirmation = filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_STRING);
    $rol = filter_input(INPUT_POST, 'rol', FILTER_VALIDATE_INT);

    // Validar que se hayan recibido todos los datos
    if ($usuario && $password && $password_confirmation && $rol) {
        // Verificar que las contraseñas coincidan
        if ($password !== $password_confirmation) {
            header("Location: ../views/registros/registrar.php?error=contraseñas_no_coinciden");
            exit();
        }

        // Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $controller = new RegisterController();
        $registerSuccess = $controller->register($usuario, $hashedPassword, $rol);

        if ($registerSuccess) {
            // Registro exitoso, redirigir al login con mensaje de éxito
            header("Location: ../app/views/login.php?success=1");
            exit();
        } else {
            // Error en el registro (usuario ya existe), redirigir con mensaje de error
            header("Location: ../views/registros/registrar.php?error=usuario_existente");
            exit();
        }
    } else {
        // Datos incompletos, redirigir con mensaje de error
        header("Location: ../views/registros/registrar.php?error=datos_incompletos");
        exit();
    }
}
?>
