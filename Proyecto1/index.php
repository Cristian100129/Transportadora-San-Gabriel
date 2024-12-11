<?php
require_once "backend/conexion.php"; // Incluir el archivo de conexión

try {
    // Consulta para obtener las presentaciones
    $sql = "SELECT p.*, u.username 
            FROM presentaciones p
            JOIN usuarios u ON p.usuario_id = u.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>

    <!doctype html>
    <html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Proyecto San gabriel</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="./style/index.css">
        <link rel="stylesheet" href="./style/encabezado.css">
    </head>
    <body>
    
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">Transportadora San Gabriel</a>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" id="busqueda" placeholder="Buscar" aria-label="Search">
                    <button class="btn btn-outline-success" type="button" onclick="filtrarPresentaciones()">
                        <i class="fas fa-search"></i>
                    </button> 
                </form>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Transportadora San Gabriel</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./index.php">
                                    <i class="fas fa-home"></i>  Inicio 
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./login.php">
                                    <i class="fa-solid fa-user"></i>  Iniciar sesion
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./register.php">
                                    <i class="fas fa-sign-in-alt"></i>  Registrarse
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container2">
    <h1 class="container2__videos">Videos subidos recientemente</h1>
    <div class="container2__filtro">
        <select id="selector-paginas" class="form-select">
            <option value="">Selecciona una opción</option> 
            <option value="./view_dos.php">Video con Título</option>
            <option value="./view_tres.php">Banner con Título</option>
        </select>
    </div>
</div>

<div class="container text-center">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
        <?php foreach ($presentaciones as $presentacion): ?>
            <div class="col__video">
                <div class="col mb-4">
                    <h1 class="col__titulo"><?php echo $presentacion['titulo']; ?></h1> 

                    <div class="media-container"> 
                        <?php if ($presentacion['tipo'] === 'VT' && isset($presentacion['ruta_video'])): ?> 
                            <video class="w-100 video-player" src="uploads/<?php echo $presentacion['ruta_video']; ?>" controls autoplay loop>
                                Tu navegador no soporta la etiqueta de video.
                            </video> 
                        <?php elseif ($presentacion['tipo'] === 'BT' && isset($presentacion['ruta_imagen'])): ?>
                            <img class="w-100" src="uploads/<?php echo $presentacion['ruta_imagen']; ?>" alt="Imagen"> 
                        <?php endif; ?>
                    </div>

                    <br>
                    <span class="upload-date">Fecha de subida: <?php echo date("d/m/Y", strtotime($presentacion['created_at'])); ?></span>
                    <span class="username">Subido por: <?php echo $presentacion['username']; ?></span> 
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
       
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="./Js/index.js"></script>
    </body>
    </html>

    <?php
} catch (PDOException $e) {
    echo "Error al obtener las presentaciones: " . $e->getMessage();
}
?>