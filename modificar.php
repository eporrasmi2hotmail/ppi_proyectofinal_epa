<?php 
include 'db.php'; 
include 'header.php'; // Este es el que gestiona la navegación y estilos (bootstrap)

// --- 1. LÓGICA DE ACTUALIZACIÓN (Cuando se envía el formulario) ---
$mensaje = "";
$tipo_mensaje = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $fecha = $_POST['fecha'];
    $idAutor = $_POST['idAutor'];
    $idEditorial = $_POST['idEditorial'];

    // Verificar si se subió una nueva imagen
    if (isset($_FILES['portada']) && $_FILES['portada']['size'] > 0) {
        $imagenTemporal = $_FILES['portada']['tmp_name'];
        $contenido = file_get_contents($imagenTemporal);
        $portadaContenido = addslashes($contenido);
        
        $sql_update = "UPDATE libro SET 
                       titulo='$titulo', 
                       fecha_publicacion='$fecha', 
                       idAutor='$idAutor', 
                       idEditorial='$idEditorial',
                       portada='$portadaContenido'
                       WHERE id=$id";
    } else {
        $sql_update = "UPDATE libro SET 
                       titulo='$titulo', 
                       fecha_publicacion='$fecha', 
                       idAutor='$idAutor', 
                       idEditorial='$idEditorial'
                       WHERE id=$id";
    }

    if ($conn->query($sql_update) === TRUE) {
        $mensaje = "Libro actualizado correctamente.";
        $tipo_mensaje = "success";
        $_GET['id'] = null; // Volver a la lista
    } else {
        $mensaje = "Error al actualizar: " . $conn->error;
        $tipo_mensaje = "danger";
    }
}
?>
<style> /* Estilo para fondo fijo semitransparente */
    body {
        background-image: url('fondo_librería.jpg');
        background-attachment: fixed;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.85);
        z-index: -1;
    }
</style>
<style>
    .page-link { color: #5d4037; }
    .page-link:hover { color: #3e2723; background-color: #efebe9; }
    .page-item.active .page-link { background-color: #5d4037; border-color: #5d4037; color: white; }
</style>

<?php if(!empty($mensaje)): ?>
    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
        <?php echo $mensaje; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>


<?php
// --- 2. MODO EDICIÓN: Si hay un ID en la URL, mostramos el formulario ---
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_editar = $_GET['id'];
    $sql_buscar = "SELECT * FROM libro WHERE id = $id_editar";
    $resultado_buscar = $conn->query($sql_buscar);
    
    if ($resultado_buscar->num_rows > 0) {
        $libro = $resultado_buscar->fetch_assoc();
?>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark fw-bold">
                        ✏️ Editando: <?php echo $libro['titulo']; ?>
                    </div>
                    <div class="card-body">
                        <form action="modificar.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">

                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título del Libro</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $libro['titulo']; ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fecha" class="form-label">Fecha de Publicación</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $libro['fecha_publicacion']; ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="idAutor" class="form-label">Autor</label>
                                    <select class="form-select" name="idAutor" required>
                                        <?php
                                        $res_autor = $conn->query("SELECT id, nombre FROM autor");
                                        while($row = $res_autor->fetch_assoc()) {
                                            $selected = ($row['id'] == $libro['idAutor']) ? "selected" : "";
                                            echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="idEditorial" class="form-label">Editorial</label>
                                <select class="form-select" name="idEditorial" required>
                                    <?php
                                    $res_editorial = $conn->query("SELECT id, nombre FROM editorial");
                                    while($row = $res_editorial->fetch_assoc()) {
                                        $selected = ($row['id'] == $libro['idEditorial']) ? "selected" : "";
                                        echo "<option value='" . $row['id'] . "' $selected>" . $row['nombre'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label d-block">Portada Actual / Cambiar Imagen</label>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="border p-1 rounded bg-light" style="width: 80px; height: 100px; display: flex; align-items: center; justify-content: center;">
                                        <?php if (!empty($libro['portada'])): ?>
                                            <img src="data:image/jpeg;base64,<?php echo base64_encode($libro['portada']); ?>" style="max-width: 100%; max-height: 100%;">
                                        <?php else: ?>
                                            <span class="small text-muted">Sin img</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="flex-grow-1">
                                        <input type="file" class="form-control" name="portada" accept="image/*">
                                        <div class="form-text">Si no selecciona un archivo, se mantendrá la portada actual.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="modificar.php" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php
    } else {
        echo "<div class='alert alert-danger'>Libro no encontrado.</div>";
    }

// --- 3. MODO LISTA: Si NO hay ID, mostramos la tabla con PAGINACIÓN ---
} else {
    // --- LÓGICA DE PAGINACIÓN ---
    $registros_por_pagina = 5;
    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    if ($pagina_actual < 1) $pagina_actual = 1;
    $offset = ($pagina_actual - 1) * $registros_por_pagina;

    // Contar total
    $sql_total = "SELECT COUNT(*) as total FROM libro";
    $result_total = $conn->query($sql_total);
    $row_total = $result_total->fetch_assoc();
    $total_registros = $row_total['total'];
    $total_paginas = ceil($total_registros / $registros_por_pagina);
?>
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-4">Seleccione el libro que desea modificar</h4>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th style="width: 80px;">Portada</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Consulta con LIMIT y OFFSET para mejor control de paginación
                        $sql = "SELECT l.id, l.titulo, l.portada, a.nombre as autor 
                                FROM libro l 
                                INNER JOIN autor a ON l.idAutor = a.id
                                ORDER BY l.titulo ASC
                                LIMIT $offset, $registros_por_pagina";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                
                                echo "<td>";
                                if (!empty($row['portada'])) {
                                    echo "<img src='data:image/jpeg;base64," . base64_encode($row['portada']) . "' class='rounded border' style='width:50px; height:auto;'>";
                                } else {
                                    echo "<span class='badge bg-secondary'>Sin img</span>";
                                }
                                echo "</td>";

                                echo "<td class='fw-bold'>" . $row["titulo"] . "</td>";
                                echo "<td>" . $row["autor"] . "</td>";
                                
                                echo "<td class='text-end'>
                                        <a href='modificar.php?id=" . $row["id"] . "' class='btn btn-warning btn-sm text-dark fw-bold'>
                                            ✏️ Editar
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No hay libros registrados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <?php if ($total_paginas > 1): ?>
            <nav aria-label="Navegación de páginas" class="mt-4">
              <ul class="pagination justify-content-center mb-0">
                
                <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
                  <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>">Anterior</a>
                </li>

                <?php for($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?php echo ($pagina_actual >= $total_paginas) ? 'disabled' : ''; ?>">
                  <a class="page-link" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente</a>
                </li>
                
              </ul>
            </nav>
            <?php endif; ?>
            </div>
    </div>
<?php } ?>

</div> 
<footer class="bg-light border-top mt-5 py-4">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-3 mb-md-0">
                <p class="text-secondary mb-0"><em>"La verdad no se oculta, se desoculta"</em></p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <p class="text-secondary mb-0"><strong>Sapere aude</strong></p>
            </div>
            <div class="col-md-4">
                <p class="text-secondary mb-0">© 2025 Emilio Porras Alonso. Derechos reservados.</p>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>