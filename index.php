<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Librería - Inicio</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container" style="text-align: center;">
        <h1>Sistema de Control de Librería</h1>
        <p>Bienvenido!!! Seleccione una opción para comenzar:</p>
        
        <div class="menu-dashboard">
            <div class="card">
                <h2>📚 Libros</h2>
                <p>Administración de libros.</p>
                <div class="card-actions">
                    <a href="consulta.php" class="btn">Ver Catálogo</a>
                    <a href="registro.php" class="btn-outline">Nuevo Libro</a>
                </div>
            </div>

            <div class="card">
                <h2>✍️ Autores</h2>
                <p>Administración de autores.</p>
                <div class="card-actions">
                    <a href="autores.php" class="btn">Autores</a>
                </div>
            </div>

            <div class="card">
                <h2>🏢 Editoriales</h2>
                <p>Administración de editoriales.</p>
                <div class="card-actions">
                    <a href="editoriales.php" class="btn">Editoriales</a>
                </div>
            </div>
        </div>
        
        <footer style="margin-top: 40px; font-size: 0.8em; color: #666;">
            &copy; 2025 Sistema de Librería - Práctica 8, Emilio Porras Alonso
        </footer>
    </div>
</body>
</html>