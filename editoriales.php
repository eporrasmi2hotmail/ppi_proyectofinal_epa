<?php include 'db.php'; 

// Lógica para registrar Editorial
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nombre_editorial'])) {
    $nombre = $conn->real_escape_string($_POST['nombre_editorial']);
    
    $sql_insert = "INSERT INTO editorial (nombre) VALUES ('$nombre')";

    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "Editorial agregada correctamente.";
    } else {
        $mensaje = "Error al agregar la editorial: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración de Editoriales</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Administración de Editoriales</h1>
        
        <nav>
            <a href="consulta.php">Ver Libros</a>
            <a href="registro.php">Registrar Libro</a>
            <a href="autores.php">Autores</a>
            <a href="index.php">Inicio</a>
        </nav>

        <?php if(isset($mensaje)) echo "<p style='color: green; text-align:center;'>$mensaje</p>"; ?>

        <div style="margin-bottom: 30px; border-bottom: 1px dashed #d7ccc8; padding-bottom: 20px;">
            <h3>Registrar Nueva Editorial</h3>
            <form action="editoriales.php" method="POST">
                <label for="nombre_editorial">Nombre de la Editorial:</label>
                <input type="text" id="nombre_editorial" name="nombre_editorial" required placeholder="Ej. Fondo de Cultura Económica">
                <input type="submit" value="Guardar Editorial">
            </form>
        </div>

        <h3>Editoriales Registradas</h3>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%;">ID</th>
                    <th>Nombre</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM editorial ORDER BY nombre ASC"; // Ordenado por nombre para mayor facilidad
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' style='text-align:center'>No hay editoriales registradas.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>