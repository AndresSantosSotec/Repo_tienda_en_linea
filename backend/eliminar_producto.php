<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén el ID del producto a eliminar
    $producto_id = $_POST["producto_id"];

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "midb");

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Elimina el producto de la base de datos
    $sql = "DELETE FROM productos WHERE ID=$producto_id";

    if ($conn->query($sql) === TRUE) {
        // Redirecciona a la página de lista de productos después de la eliminación
        header("Location: ../admin.php");
        exit();
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }

    // Cierra la conexión
    $conn->close();
}
?>
