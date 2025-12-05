<?php include 'db.php'; 

// Lógica para guardar el libro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $idAutor = $_POST['idAutor'];
    $idEditorial = $_POST['idEditorial'];

    // Query para insertar el libro
    $sql_insert = "INSERT INTO libro (titulo, fecha_publicacion, idAutor, idEditorial) 
                   VALUES ('$titulo', '$fecha', '$idAutor', '$idEditorial')";

    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "Libro registrado exitosamente.";
    } else {
        $mensaje = "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Libros</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Registrar Nuevo Libro</h1>
        
        <nav>
            <a href="consulta.php">Ir a Consulta de Libros</a>
            <a href="registro.php">Registrar Nuevo Libro</a>
            <a href="index.php">Inicio</a>
        </nav>

        <?php if(isset($mensaje)) echo "<p style='color: green; text-align:center;'>$mensaje</p>"; ?>

        <form action="registro.php" method="POST">
            <label for="titulo">Título del Libro:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="fecha">Fecha de Publicación:</label>
            <input type="date" id="fecha" name="fecha" required>

            <label for="idAutor">Autor:</label>
            <select name="idAutor" id="idAutor" required>
                <option value="">Seleccione un autor...</option>
                <?php
                $sql = "SELECT id, nombre FROM autor ORDER BY nombre ASC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
                ?>
            </select>

            <label for="idEditorial">Editorial:</label>
            <select name="idEditorial" id="idEditorial" required>
                <option value="">Seleccione una editorial...</option>
                <?php
                $sql = "SELECT id, nombre FROM editorial ORDER BY nombre ASC";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Registrar Libro">
        </form>
    </div>
</body>
</html>