<?php
$correo = $_POST['email'];
$pass = $_POST['password'];

// Crear conexión
$conn = new mysqli("localhost", "root", "", "midb");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para la tabla "clientes"
$query_clientes = "SELECT * FROM clientes WHERE correo = ? AND password = ?";
$stmt_clientes = $conn->prepare($query_clientes);
$stmt_clientes->bind_param("ss", $correo, $pass);

// Ejecutar consulta para la tabla "clientes"
if ($stmt_clientes->execute()) {
    $result_clientes = $stmt_clientes->get_result();
    $filas_clientes = $result_clientes->num_rows;

    if ($filas_clientes > 0) {
        include("home.php");
        echo '<script>alert("Bienvenido");</script>';
    } else {
        // Si no se encuentra en la tabla "clientes", consulta la tabla "tb_admin"
        $query_admin = "SELECT * FROM tb_admin WHERE correo = ? AND password = ?";
        $stmt_admin = $conn->prepare($query_admin);
        $stmt_admin->bind_param("ss", $correo, $pass);

        if ($stmt_admin->execute()) {
            $result_admin = $stmt_admin->get_result();
            $filas_admin = $result_admin->num_rows;

            if ($filas_admin > 0) {
                header("Location: admin.php"); // Redirige al usuario a admin.php
            } else {
                include("index.html");
                echo '<script>alert("Los datos son incorrectos");</script>';
            }

            $result_admin->close();
        } else {
            die("Error en la consulta de admin: " . $stmt_admin->error);
        }
    }

    $result_clientes->close();
} else {
    die("Error en la consulta de clientes: " . $stmt_clientes->error);
}

$stmt_clientes->close();
$conn->close();
?>
