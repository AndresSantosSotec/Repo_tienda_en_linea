<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos del formulario
    $producto_id = $_POST["producto_id"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "midb");

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualiza el producto en la base de datos
    $sql = "UPDATE productos SET Nombre='$nombre', Descripcion='$descripcion', Precio=$precio, Stock=$stock WHERE ID=$producto_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecciona a la página de lista de productos después de la edición
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error al editar el producto: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();
}
?>
