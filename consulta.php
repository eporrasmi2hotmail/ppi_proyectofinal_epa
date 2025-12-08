<?php 
include 'db.php'; 
include 'header.php'; // Este es el que gestiona la navegación y estilos (bootstrap)

// --- CONFIGURACIÓN DE PAGINACIÓN ---
$registros_por_pagina = 5; // Cantidad de libros a mostrar por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

// Calculamos el inicio (offset) para el control de la navegación
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// --- 1. CONSULTA PARA CONTAR TOTAL DE REGISTROS ---
$sql_total = "SELECT COUNT(*) as total FROM libro";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_registros = $row_total['total'];

// Calcular total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// --- 2. CONSULTA PRINCIPAL CON LÍMITE (Paginada) para mejor control de paginación ---
//  Se agregó el "LIMIT $offset, $registros_por_pagina" al final
$sql = "SELECT l.id, l.titulo, l.fecha_publicacion, l.portada, a.nombre AS autor, e.nombre AS editorial 
        FROM libro l 
        INNER JOIN autor a ON l.idAutor = a.id 
        INNER JOIN editorial e ON l.idEditorial = e.id
        ORDER BY l.titulo ASC 
        LIMIT $offset, $registros_por_pagina";

$result = $conn->query($sql);
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
    <table class="table table-hover align-middle table-sm">
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
                echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
                
                echo "<td>";
                if (!empty($row['portada'])) {
                echo "<img src='data:image/jpeg;base64," . base64_encode($row['portada']) . "' class='img-thumbnail' style='width:50px; height:auto;'>";
                } else {
                echo "<span class='badge bg-secondary'>N/A</span>";
                }
                echo "</td>";

                echo "<td class='fw-bold'>" . htmlspecialchars($row["titulo"]) . "</td>";
                
                echo "<td><small>" . date("d/m/Y", strtotime($row["fecha_publicacion"])) . "</small></td>";
                echo "<td><small>" . htmlspecialchars($row["autor"]) . "</small></td>";
                echo "<td><small>" . htmlspecialchars($row["editorial"]) . "</small></td>";
                echo "</tr>";
            }
            } else {
            echo "<tr><td colspan='7' class='text-center py-4'>No hay libros registrados en esta página.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php if ($total_paginas > 1): ?>
<nav aria-label="Navegación de páginas" class="mt-4">
  <ul class="pagination justify-content-center flex-wrap">
    
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