<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Tienda en Línea Modulo de administracion </title>
    <!-- Enlace a Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/darkly/bootstrap.min.css"
        integrity="sha384-nNK9n28pDUDDgIiIqZ/MiyO3F4/9vsMtReZK39klb/MtkZI3/LtjSjlmyVPS3KdN" crossorigin="anonymous">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Modulo de administracion</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.html">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido de la Tienda en Línea -->
    <div class="container mt-5">
        <div class="col text-end">
            <a href="insert.php" class="btn btn-primary">Agregar Productos</a>
        </div>

        <h1>Lista de Productos</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Ejemplo de fila de datos (puedes repetirla para más productos) -->
                <?php
                // Conexión a la base de datos
                $conn = new mysqli("localhost", "root", "", "midb");

                // Verifica la conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener todos los productos
                $sql = "SELECT * FROM productos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $row['ID'] . '</td>';
                        echo '<td>' . $row['Nombre'] . '</td>';
                        echo '<td>' . $row['Descripcion'] . '</td>';
                        echo '<td>Q' . $row['Precio'] . '</td>';
                        echo '<td>' . $row['Stock'] . '</td>';
                        echo '<td><a href="' . $row['Imagen'] . '" target="_blank">Ver Imagen</a></td>';
                        echo '<td>';
                        echo '<a href="#" class="btn btn-success" data-toggle="modal" data-target="#editarModal" data-producto-id="' . $row['ID'] . '" data-nombre="' . $row['Nombre'] . '" data-descripcion="' . $row['Descripcion'] . '" data-precio="' . $row['Precio'] . '" data-stock="' . $row['Stock'] . '"><i class="fas fa-edit"></i> Editar</a>';
                        echo '<a href="#" class="btn btn-danger" data-toggle="modal" data-target="#eliminarModal" data-producto-id="' . $row['ID'] . '"><i class="fas fa-trash"></i> Eliminar</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">No se encontraron productos en la base de datos.</td></tr>';
                }

                // Cierra la conexión
                $conn->close();
                ?>
                <!-- Fin del ejemplo de fila de datos -->
            </tbody>
        </table>
        <!-- Modal de Edición -->
        <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarModalLabel">Editar Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="backend/editar_producto.php" method="POST">
                            <div class="mb-3">
                                <label for="editar-nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control" id="editar-nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="editar-descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="editar-descripcion" name="descripcion"
                                    rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="editar-precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="editar-precio" name="precio" step="0.01"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="editar-stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="editar-stock" name="stock" required>
                            </div>
                            <input type="hidden" id="producto-id" name="producto_id">
                            <button type="submit" class="btn btn-success">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmación de Eliminación -->
        <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarModalLabel">Confirmar Eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que deseas eliminar este producto?
                    </div>
                    <div class="modal-footer">
                        <form action="backend/eliminar_producto.php" method="POST">
                            <input type="hidden" id="eliminar-producto-id" name="producto_id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Enlace a Bootstrap JS y jQuery (necesarios para el funcionamiento de Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            // Captura los valores al hacer clic en "Editar"
            $('#editarModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var producto_id = button.data('producto-id');
                var nombre = button.data('nombre');
                var descripcion = button.data('descripcion');
                var precio = button.data('precio');
                var stock = button.data('stock');

                var modal = $(this);
                modal.find('#producto-id').val(producto_id);
                modal.find('#editar-nombre').val(nombre);
                modal.find('#editar-descripcion').val(descripcion);
                modal.find('#editar-precio').val(precio);
                modal.find('#editar-stock').val(stock);
            });

            // Captura el valor al hacer clic en "Eliminar"
            $('#eliminarModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var producto_id = button.data('producto-id');

                var modal = $(this);
                modal.find('#eliminar-producto-id').val(producto_id);
            });
        });
    </script>
</body>

</html>