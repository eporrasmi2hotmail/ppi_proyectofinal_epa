<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Libros</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <h1>Catálogo de Libros</h1>

        <nav>
            <a href="consulta.php">Libros</a>
            <a href="registro.php">Registrar Nuevo Libro</a>
            <a href="autores.php">Autores</a>
            <a href="editoriales.php">Editoriales</a>
            <a href="index.php">Inicio</a>
        </nav>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha Publicación</th>
                    <th>Autor</th>
                    <th>Editorial</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Se usa JOIN para traer los nombres en lugar de los IDs, haciendo la consulta más sencilla
                $sql = "SELECT l.id, l.titulo, l.fecha_publicacion, a.nombre AS autor, e.nombre AS editorial 
                        FROM libro l 
                        INNER JOIN autor a ON l.idAutor = a.id 
                        INNER JOIN editorial e ON l.idEditorial = e.id ORDER BY l.titulo ASC";
                
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["titulo"] . "</td>";
                        echo "<td>" . $row["fecha_publicacion"] . "</td>";
                        echo "<td>" . $row["autor"] . "</td>";
                        echo "<td>" . $row["editorial"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center'>No hay libros registrados</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>