<?php 
include 'db.php'; 
include 'header.php'; // Este es el que gestiona la navegación y estilos (bootstrap)

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
<div class="row justify-content-center mb-4">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h4 class="card-title text-center mb-3">Buscar Libros</h4>
                <form action="busqueda.php" method="POST" class="d-flex gap-2">
                    <input type="text" name="busqueda" class="form-control form-control-lg" placeholder="Ingrese título o nombre del autor..." required>
                    <button type="submit" class="btn btn-success btn-lg">Buscar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $busqueda = $conn->real_escape_string($_POST['busqueda']);
        
        // Búsqueda coincidencias en Titulo O Autor
        $sql = "SELECT l.titulo, l.fecha_publicacion, l.portada, a.nombre AS autor, e.nombre AS editorial 
                FROM libro l 
                INNER JOIN autor a ON l.idAutor = a.id 
                INNER JOIN editorial e ON l.idEditorial = e.id
                WHERE l.titulo LIKE '%$busqueda%' OR a.nombre LIKE '%$busqueda%'";
        
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
    ?>
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <?php if (!empty($row['portada'])): ?>
                            <div class="text-center">
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['portada']); ?>" class="card-img-top" alt="Portada" style="max-height: 300px; width: 50%; object-fit: cover;">
                            </div>
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center py-5">Sin Portada</div>
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?php echo $row['titulo']; ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted"><?php echo $row['autor']; ?></h6>
                            <p class="card-text small">
                                <strong>Editorial:</strong> <?php echo $row['editorial']; ?><br>
                                <strong>Fecha:</strong> <?php echo $row['fecha_publicacion']; ?>
                            </p>
                        </div>
                    </div>
                </div>
    <?php
            }
        } else {
            echo "<div class='col-12 text-center'><div class='alert alert-warning'>No se encontraron resultados para: <strong>$busqueda</strong></div></div>";
        }
    }
    ?>
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