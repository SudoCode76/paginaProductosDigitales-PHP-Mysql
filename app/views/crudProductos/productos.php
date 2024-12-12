<?php
require_once __DIR__ . '/../config/checkSession.php';
require_once __DIR__ . '/../config/conexion.php';
?>

<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>GESTIÓN DE PRODUCTOS</title>
</head>

<body class="bg-base-200">
    <div class="container mx-auto px-4 py-8">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-primary">Gestión de Productos</h1>
                    <a href="../../controllers/gestionCuentasClientes/anadir.php" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>Añadir Producto
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="table table-zebra">
                        <thead class="bg-base-300">
                            <tr class="text-base">
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Ruta Portada</th>
                                <th>Categoría</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT productodigital.idproductoDigital, productodigital.tituloProducto, productodigital.descripcionProducto, productodigital.urlPortada, categoriasproducto.nombreCategoria
FROM productodigital JOIN categoriasproducto ON productodigital.categoriasProducto_idcategorias = categoriasproducto.idcategoriasProducto";
                            $stmt = $conexion->prepare($sql);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='hover:bg-base-200'>
                                    <td class='font-semibold'>" . htmlspecialchars($row["tituloProducto"]) . "</td>
                                    <td class='text-sm text-base-content/70'>" . htmlspecialchars($row["descripcionProducto"]) . "</td>
                                    <td class='text-sm'>" . htmlspecialchars($row["urlPortada"]) . "</td>
                                    <td>
                                        <span class='badge badge-secondary badge-outline'>" . htmlspecialchars($row["nombreCategoria"]) . "</span>
                                    </td>
                                    <td class='text-center'>
                                        <div class='join'>
                                            <a href='../../controllers/gestionCuentasClientes/editar.php?id=" . urlencode($row["idproductoDigital"]) . "' class='btn btn-warning btn-sm join-item'>
                                                <i class='fas fa-edit mr-1'></i>Editar
                                            </a>
                                            <a href='../../controllers/gestionCuentasClientes/eliminar.php?id=" . urlencode($row["idproductoDigital"]) . "' class='btn btn-error btn-sm join-item'>
                                                <i class='fas fa-trash-alt mr-1'></i>Eliminar
                                            </a>
                                        </div>
                                    </td>
                                  </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center text-base-content/50 py-4'>
                                    <div class='flex flex-col items-center'>
                                        <i class='fas fa-box-open text-4xl mb-2'></i>
                                        <p>No hay productos registrados</p>
                                    </div>
                                </td></tr>";
                            }
                            $stmt->close();
                            $conexion->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>