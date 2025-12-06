<?php 
include 'db.php'; 
include 'header.php'; // Incluye navegación y estilos

// --- CONFIGURACIÓN DE PAGINACIÓN ---
$registros_por_pagina = 5; // Cantidad de libros a mostrar por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Calculamos el inicio (offset)
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// --- 1. CONSULTA PARA CONTAR TOTAL DE REGISTROS ---
$sql_total = "SELECT COUNT(*) as total FROM libro";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_registros = $row_total['total'];

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// --- 2. CONSULTA PRINCIPAL CON LÍMITE (Paginada) ---
// Nota: Agregamos "LIMIT $offset, $registros_por_pagina" al final
$sql = "SELECT l.id, l.titulo, l.fecha_publicacion, l.portada, a.nombre AS autor, e.nombre AS editorial 
        FROM libro l 
        INNER JOIN autor a ON l.idAutor = a.id 
        INNER JOIN editorial e ON l.idEditorial = e.id
        ORDER BY l.id DESC 
        LIMIT $offset, $registros_por_pagina";

$result = $conn->query($sql);
?>

<style>
    .page-link {
        color: #5d4037; /* Café texto */
    }
    .page-link:hover {
        color: #3e2723;
        background-color: #efebe9;
    }
    .page-item.active .page-link {
        background-color: #5d4037; /* Café fondo */
        border-color: #5d4037;
        color: white;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Catálogo Completo</h2>
    <div>
        <span class="badge bg-secondary me-2">Total: <?php echo $total_registros; ?> libros</span>
        <a href="registro.php" class="btn btn-primary">➕ Nuevo Libro</a>
    </div>
</div>

<div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table class="table table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th style="width: 80px;">Portada</th>
                <th>Título</th>
                <th>Fecha</th>
                <th>Autor</th>
                <th>Editorial</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    
                    echo "<td>";
                    if (!empty($row['portada'])) {
                        echo "<img src='data:image/jpeg;base64," . base64_encode($row['portada']) . "' class='img-thumbnail' style='width:60px; height:auto;'>";
                    } else {
                        echo "<span class='badge bg-secondary'>N/A</span>";
                    }
                    echo "</td>";

                    echo "<td class='fw-bold'>" . $row["titulo"] . "</td>";
                    echo "<td>" . date("d/m/Y", strtotime($row["fecha_publicacion"])) . "</td>";
                    echo "<td>" . $row["autor"] . "</td>";
                    echo "<td>" . $row["editorial"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center py-4'>No hay libros registrados en esta página.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php if ($total_paginas > 1): ?>
<nav aria-label="Navegación de páginas" class="mt-4">
  <ul class="pagination justify-content-center">
    
    <li class="page-item <?php echo ($pagina_actual <= 1) ? 'disabled' : ''; ?>">
      <a class="page-link" href="?pagina=<?php echo $pagina_actual - 1; ?>" tabindex="-1">Anterior</a>
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

</div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>