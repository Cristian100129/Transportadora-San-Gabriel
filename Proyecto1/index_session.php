<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Proyecto San gabriel</title>
    <!-- Esta es la libreria para logos que uso de font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Libreria de bootstrap  -->
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
              <button class="btn btn-outline-success" type="button" onclick="filtrarPresentaciones()"><i class="fas fa-search"></i></button> 
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
                  <?php
                  session_start();
                  // Obtiene el nombre del usuario de la sesión
                  $username = $_SESSION['username'];
                  // Mostrar el nombre de usuario en el elemento de navegación
                  echo '<li class="nav-item">';
                  echo '<span class="nav-link">'; 
                  echo '<i class="fa-solid fa-user"></i> Hola, ' . $username . '!'; 
                  echo '</span>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="index_session.php">'; 
                  echo '<i class="fa-solid fa-house"></i> inicio'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="view_dos_session.php">'; 
                  echo '<i class="fa-solid fa-video"></i> Video con Título'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="view_tres_session.php">'; 
                  echo '<i class="fa-solid fa-image"></i> Banner con Título'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="welcome.php">'; 
                  echo '<i class="fa-solid fa-arrow-up"></i> subir presentacion'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="welcome_update.php">'; 
                  echo '<i class="fa-solid fa-upload"></i> Editar presentacion'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="welcome_delete.php">'; 
                  echo '<i class="fa-solid fa-trash"></i> eliminar presentacion'; 
                  echo '</a>';
                  echo '</li>';
                  echo '<li class="nav-item">';
                  echo '<a class="nav-link" href="./backend/logout.php">';
                  echo '<i class="fas fa-sign-out-alt"></i> Cerrar sesión'; 
                  echo '</a>';
                  echo '</li>';
                  ?>
                  </ul>
                </div>
              </div>
            </div>
          </nav>
          <?php
      require_once "backend/conexion.php"; // Incluir el archivo de conexión
      // Consulta para obtener las presentaciones
      $sql = "SELECT p.*, u.username 
              FROM presentaciones p
              JOIN usuarios u ON p.usuario_id = u.id";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
      <div class="container text-center">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
        <?php foreach ($presentaciones as $presentacion): ?>
              <div class="col__video">
                <div class="col mb-4">
                  <h1 class="col__titulo"><?php echo $presentacion['titulo']; ?></h1> 

                  <div class="media-container"> 
                    <?php if ($presentacion['tipo'] === 'VT'): ?> 
                      <?php if ($presentacion['ruta_video']): ?>
                        <video class="w-100 video-player" src="uploads/<?php echo $presentacion['ruta_video']; ?>" autoplay loop controls></video> 
                      <?php endif; ?>
                      <?php if ($presentacion['ruta_imagen']): ?>
                        <img class="w-100" src="uploads/<?php echo $presentacion['ruta_imagen']; ?>" alt="Imagen"> 
                      <?php endif; ?>
                    <?php elseif ($presentacion['tipo'] === 'BT'): ?>
                      <?php if ($presentacion['ruta_imagen']): ?>
                        <img class="w-100" src="uploads/<?php echo $presentacion['ruta_imagen']; ?>" alt="Imagen"> 
                      <?php endif; ?>
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
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./Js/index.js"></script>
    <script src="./Js/welcome.js"></script>
  </body>
</html>