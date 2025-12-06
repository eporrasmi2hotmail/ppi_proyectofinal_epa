<?php
$servername = "db";
$username = "root"; // Usuario por defecto
$password = "root_password";     // Contraseña por defecto
$dbname = "libreria_practica8";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificamos la conexión
if ($conn->connect_error) {
    die("Conexión no exitosa: " . $conn->connect_error);
}

//mysqli_close($conn);

?>