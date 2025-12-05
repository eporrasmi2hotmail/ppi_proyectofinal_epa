<?php include 'db.php'; 

// Lógica para registrar Autor
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nombre_autor'])) {
    $nombre = $conn->real_escape_string($_POST['nombre_autor']);
    
    $sql_insert = "INSERT INTO autor (nombre) VALUES ('$nombre')";

    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "Autor agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Autores</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Administración de Autores</h1>
        
        <nav>
            <a href="consulta.php">Ver Libros</a>
            <a href="registro.php">Registrar Libro</a>
            <a href="editoriales.php">Editoriales</a>
            <a href="index.php">Inicio</a>
        </nav>

        <?php if(isset($mensaje)) echo "<p style='color: green; text-align:center;'>$mensaje</p>"; ?>

        <div style="margin-bottom: 30px; border-bottom: 1px dashed #d7ccc8; padding-bottom: 20px;">
            <h3>Registrar Nuevo Autor</h3>
            <form action="autores.php" method="POST">
                <label for="nombre_autor">Nombre del Autor:</label>
                <input type="text" id="nombre_autor" name="nombre_autor" required placeholder="Ej. Juan Rulfo">
                <input type="submit" value="Guardar Autor">
            </form>
        </div>

        <h3>Autores Registrados</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM autor ORDER BY nombre ASC"; // Ordenado por nombre
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='text-align:center'>No hay autores registrados.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>