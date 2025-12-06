<?php 
include 'db.php'; 
include 'header.php'; // Incluye la navegación y estilos

// --- LÓGICA PHP: REGISTRAR LIBRO ---
$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $idAutor = $_POST['idAutor'];
    $idEditorial = $_POST['idEditorial'];

    // --- Procesamiento de la Imagen (BLOB) ---
    $portadaContenido = ""; // Por defecto vacío
    
    // Verificamos si se subió un archivo y si no hubo errores
    if (isset($_FILES['portada']) && $_FILES['portada']['size'] > 0) {
        $imagenTemporal = $_FILES['portada']['tmp_name'];
        // Leemos el archivo en binario
        $contenido = file_get_contents($imagenTemporal);
        // Escapamos caracteres especiales para SQL
        $portadaContenido = addslashes($contenido);
    }

    // Query de inserción
    $sql_insert = "INSERT INTO libro (titulo, fecha_publicacion, idAutor, idEditorial, portada) 
                   VALUES ('$titulo', '$fecha', '$idAutor', '$idEditorial', '$portadaContenido')";

    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "Libro <strong>$titulo</strong> registrado exitosamente.";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Error al registrar: " . $conn->error;
        $tipo_mensaje = "danger";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        
        <?php if(!empty($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                <?php echo $mensaje; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold" style="background-color: #5d4037 !important;"> 📖 Registrar Nuevo Libro
            </div>
            <div class="card-body">
                <p class="text-muted mb-4">Complete el formulario para agregar un nuevo título al inventario.</p>

                <form action="registro.php" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título del Libro</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej. Cien Años de Soledad" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha de Publicación</label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="idAutor" class="form-label">Autor</label>
                            <div class="input-group">
                                <select class="form-select" name="idAutor" id="idAutor" required>
                                    <option value="">Seleccione un autor...</option>
                                    <?php
                                    $sql = "SELECT id, nombre FROM autor ORDER BY nombre ASC";
                                    $result = $conn->query($sql);
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <a href="autores.php" class="btn btn-outline-secondary" title="Nuevo Autor">➕</a>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="idEditorial" class="form-label">Editorial</label>
                            <div class="input-group">
                                <select class="form-select" name="idEditorial" id="idEditorial" required>
                                    <option value="">Seleccione una editorial...</option>
                                    <?php
                                    $sql = "SELECT id, nombre FROM editorial ORDER BY nombre ASC";
                                    $result = $conn->query($sql);
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                                <a href="editoriales.php" class="btn btn-outline-secondary" title="Nueva Editorial">➕</a>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="portada" class="form-label">Portada del Libro (Imagen)</label>
                            <input type="file" class="form-control" id="portada" name="portada" accept="image/*">
                            <div class="form-text">Formatos: JPG, PNG, GIF.</div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">Registrar Libro</button>
                        <a href="consulta.php" class="btn btn-outline-secondary">Cancelar</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>