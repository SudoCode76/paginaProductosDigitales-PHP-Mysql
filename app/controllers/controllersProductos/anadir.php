<?php
// Incluir la conexión a la base de datos
require_once __DIR__ . '/../../config/conexion.php';

// Inicializar variables para mensajes de éxito o error
$mensaje = "";

// Procesar el formulario cuando se envíe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y sanitizar los datos del formulario
    $tituloProducto = trim($_POST['tituloProducto']);
    $descripcionProducto = trim($_POST['descripcionProducto']);
    $urlPortada = trim($_POST['urlPortada']);
    $categoriasProducto_idcategorias = intval($_POST['categoriasProducto_idcategorias']);

    if (empty($tituloProducto) || empty($descripcionProducto) || empty($urlPortada) || empty($categoriasProducto_idcategorias)) {
        $mensaje = "Por favor, completa todos los campos obligatorios.";
    } else {
        $sql = "INSERT INTO productoDigital (tituloProducto, descripcionProducto, urlPortada, categoriasProducto_idcategorias) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);

        if ($stmt) {
            // Vincular los parámetros
            $stmt->bind_param("sssi", $tituloProducto, $descripcionProducto, $urlPortada, $categoriasProducto_idcategorias);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir con mensaje de éxito
                header("Location: ../../views/dashboard.php?success=Producto añadido exitosamente");
                exit();
            } else {
                // Redirigir con mensaje de error
                header("Location: ../../views/dashboard.php?error=Error al añadir producto: " . urlencode($stmt->error));
                exit();
            }

            // Cerrar el statement
            $stmt->close();
        } else {
            // Redirigir si hay un error en la preparación del statement
            header("Location: ../../views/dashboard.php?error=Error en la preparación de la consulta: " . urlencode($conexion->error));
            exit();
        }
    }
}

// Obtener las categorías de producto para el campo de selección
$sqlCategorias = "SELECT idcategoriasProducto, nombreCategoria FROM categoriasProducto";
$resultCategorias = $conexion->query($sqlCategorias);

if (!$resultCategorias) {
    die("Error al obtener las categorías: " . $conexion->error);
}

$categoriasProducto = $resultCategorias->fetch_all(MYSQLI_ASSOC);

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto Digital</title>
    <!-- Enlace a DaisyUI y Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css"/>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container mx-auto mt-10 p-5">
        <h1 class="text-3xl font-bold mb-6">Añadir Nuevo Producto Digital</h1>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (!empty($mensaje)) : ?>
            <div class="alert alert-error shadow-lg mb-5">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span><?php echo htmlspecialchars($mensaje); ?></span>
                </div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="space-y-6">
            <!-- Título del Producto -->
            <div class="form-control">
                <label for="tituloProducto" class="label">Título del Producto:</label>
                <input type="text" id="tituloProducto" name="tituloProducto" class="input input-bordered" required>
            </div>

            <!-- Descripción del Producto -->
            <div class="form-control">
                <label for="descripcionProducto" class="label">Descripción del Producto:</label>
                <textarea id="descripcionProducto" name="descripcionProducto" class="textarea textarea-bordered" rows="4" required></textarea>
            </div>

            <!-- URL de la Portada -->
            <div class="form-control">
                <label for="urlPortada" class="label">URL de la Portada:</label>
                <input type="text" id="urlPortada" name="urlPortada" class="input input-bordered">
            </div>

            <!-- Categoría del Producto -->
            <div class="form-control">
                <label for="categoriasProducto_idcategorias" class="label">Categoría del Producto:</label>
                <select id="categoriasProducto_idcategorias" name="categoriasProducto_idcategorias" class="select select-bordered" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    <?php foreach ($categoriasProducto as $categoria) : ?>
                        <option value="<?php echo htmlspecialchars($categoria['idcategoriasProducto']); ?>">
                            <?php echo htmlspecialchars($categoria['nombreCategoria']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Botón de Envío -->
            <div class="form-control">
                <button type="submit" class="btn btn-primary">Guardar Producto</button>
            </div>
        </form>
    </div>
</body>
</html>
