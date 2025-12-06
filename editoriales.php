<?php 
include 'db.php'; 
include 'header.php'; // Incluye la navegación y estilos

// --- LÓGICA PHP: REGISTRAR EDITORIAL ---
$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['nombre_editorial'])) {
    // Limpieza básica de la entrada
    $nombre = $conn->real_escape_string($_POST['nombre_editorial']);
    
    $sql_insert = "INSERT INTO editorial (nombre) VALUES ('$nombre')";

    if ($conn->query($sql_insert) === TRUE) {
        $mensaje = "Editorial <strong>$nombre</strong> agregada exitosamente.";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "Error al agregar: " . $conn->error;
        $tipo_mensaje = "danger";
    }
}
?>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-danger text-white fw-bold" style="background-color: #795548 !important;"> 🏢 Registrar Editorial
            </div>
            <div class="card-body">
                <p class="small text-muted">Ingrese el nombre de la casa editorial para agregarla al catálogo.</p>
                
                <?php if(!empty($mensaje)): ?>
                    <div class="alert alert-<?php echo $tipo_mensaje; ?> alert-dismissible fade show" role="alert">
                        <?php echo $mensaje; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="editoriales.php" method="POST">
                    <div class="mb-3">
                        <label for="nombre_editorial" class="form-label">Nombre de la Editorial</label>
                        <input type="text" class="form-control" id="nombre_editorial" name="nombre_editorial" placeholder="Ej. Penguin Random House" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Guardar Editorial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-light fw-bold text-dark border-bottom">
                📚 Editoriales Registradas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 15%;">ID</th>
                                <th>Nombre de la Editorial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta: Mostrar las más recientes primero
                            $sql = "SELECT * FROM editorial ORDER BY id DESC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='text-center text-muted small'>" . $row["id"] . "</td>";
                                    echo "<td class='fw-bold'>" . $row["nombre"] . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2' class='text-center py-4 text-muted'>No hay editoriales registradas en el sistema.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>