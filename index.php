<?php 
include 'db.php'; 
include 'header.php'; // Carga la navegación y abre el contenedor principal ya con características de Bootstrap

// Consulta para obtener un libro aleatorio (ORDER BY RAND)
$sql_random = "SELECT l.titulo, l.fecha_publicacion, l.portada, a.nombre AS autor, e.nombre AS editorial 
               FROM libro l 
               INNER JOIN autor a ON l.idAutor = a.id 
               INNER JOIN editorial e ON l.idEditorial = e.id
               ORDER BY RAND() LIMIT 1";
$result = $conn->query($sql_random);
$libro_random = $result->fetch_assoc();
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

<div class="row align-items-center mt-3">
    <div class="col-lg-6 mb-4">
        <div class="p-5 rounded-3 shadow-sm" style="background-color: #fff; border-left: 5px solid var(--cafe-principal);">
            <h1 class="display-5 fw-bold" style="color: var(--cafe-principal);">Bienvenido</h1>
            <p class="lead text-secondary">
                He creado ALETHEÍA (Ἀλήθεια), una librería de pensamiento filosófico con profundo significado, cuyo nombre 
                viene del griego antiguo y significa "verdad" o "desocultamiento". Es un concepto fundamental en filosofía,
                 especialmente en Heidegger, 
                que entendía la verdad no como mera correspondencia, sino como revelación o desvelamiento del ser. 
            </p>
            <hr class="my-4">
            <p>Puedes registrar nuevos títulos, consultar el catálogo existente y administrar la información de autores y editoriales de manera sencilla.
               Utiliza la barra de navegación superior para acceder a las diferentes secciones.</p>
            <a href="consulta.php" class="btn btn-primary btn-lg px-4">Ver Catálogo</a>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow border-0">
            <div class="card-header text-white fw-bold" style="background-color: #8d6e63;">
                ⭐ Recomendación del Momento
            </div>
            <div class="row g-0">
                <div class="col-md-5 bg-light d-flex align-items-center justify-content-center">
                    <?php if (!empty($libro_random['portada'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($libro_random['portada']); ?>" 
                             class="img-fluid rounded-start" 
                             style="max-height: 400px; width: 100%; object-fit: cover;" 
                             alt="Portada del libro">
                    <?php else: ?>
                        <div class="text-muted py-5 text-center w-100">
                            <span>Sin Portada</span>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-7">
                    <div class="card-body">
                        <?php if($libro_random): ?>
                            <h5 class="card-title fw-bold text-dark"><?php echo $libro_random['titulo']; ?></h5>
                            <p class="card-text mt-3">
                                <span class="d-block text-muted"><small>Autor:</small></span>
                                <span class="fs-5"><?php echo $libro_random['autor']; ?></span>
                            </p>
                            <p class="card-text">
                                <span class="d-block text-muted"><small>Editorial:</small></span>
                                <strong><?php echo $libro_random['editorial']; ?></strong>
                            </p>
                            <p class="card-text">
                                <small class="text-muted">Publicado el: <?php echo date("d-m-Y", strtotime($libro_random['fecha_publicacion'])); ?></small>
                            </p>
                        <?php else: ?>
                            <p class="text-muted text-center mt-4">No hay libros registrados en la base de datos.</p>
                            <div class="text-center">
                                <a href="registro.php" class="btn btn-sm btn-outline-secondary">Registrar el primero</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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