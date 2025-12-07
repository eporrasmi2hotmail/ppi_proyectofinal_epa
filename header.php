<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Librería</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Personalización para los colores de la librería */
        :root {
            --cafe-principal: #5d4037;
            --fondo-crema: #fdfbf7;
        }

        body {
            background-color: var(--fondo-crema);
        }

        /* Sobreescribimos el color de la barra para que sea Café */
        .navbar-custom {
            background-color: var(--cafe-principal) !important;
        }

        .btn-primary {
            background-color: var(--cafe-principal);
            border-color: #4e342e;
        }

        .btn-primary:hover {
            background-color: #3e2723;
            border-color: #3e2723;
        }
        
        /* Ajuste para que las imágenes de las portadas se vean uniformes en las cards */
        .card-img-top {
            height: 400px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">🦉 ALETHEÍA</a>
    <a class="navbar-brand fst-italic">Librería de Pensamiento Filosófico</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        
        <li class="nav-item">
            <a class="nav-link" href="index.php">Inicio</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="consulta.php">Catálogo</a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link" href="busqueda.php">🔍 Buscar</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Administrar
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="registro.php">➕ Nuevo Libro</a></li>
                <li><a class="dropdown-item" href="modificar.php">✏️ Modificar Libro</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="autores.php">Gestión de Autores</a></li>
                <li><a class="dropdown-item" href="editoriales.php">Gestión de Editoriales</a></li>
            </ul>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4 mb-5">