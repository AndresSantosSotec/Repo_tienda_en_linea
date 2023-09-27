<?php
$correo = $_POST['email'];
$pass = $_POST['password'];

$conn = new mysqli("localhost", "root", "", "midb");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$query = "INSERT INTO clientes (correo, password) VALUES (?, ?)"; // Cambiado "contra" a "password"
$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $correo, $pass);

if ($stmt->execute()) {
    // Registro exitoso, redirige al usuario a una página de confirmación o a donde desees.
    header("Location: index.html");
} else {
    echo "Error al registrar el usuario: " . $stmt->error;
}

// Cierra la conexión
$stmt->close();
$conn->close();
?>
