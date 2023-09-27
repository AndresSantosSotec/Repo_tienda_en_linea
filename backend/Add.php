<?php
// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera los datos del formulario
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];
    $stock = $_POST["stock"];
    $imagen = $_POST["imagen"]; // Recupera el enlace de la imagen

    // Conexión a la base de datos
    $conn = new mysqli("localhost", "root", "", "midb");

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Consulta SQL para insertar un nuevo producto
    $sql = "INSERT INTO productos (Nombre, Descripcion, Precio, Stock, Imagen) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    // Bind de parámetros
    $stmt->bind_param("ssdis", $nombre, $descripcion, $precio, $stock, $imagen);

    // Ejecuta la consulta
    if ($stmt->execute()) {
        // Redirige a admin.php después de la inserción exitosa
        header("Location: ../admin.php");

        exit(); // Asegura que no se ejecuten más acciones después de la redirección
    } else {
        echo "Error al insertar el producto: " . $stmt->error;
    }

    // Cierra la conexión
    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no autorizado.";
}
?>
