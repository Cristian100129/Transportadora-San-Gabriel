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
    <link rel="stylesheet" href="./style/view_dos.css">
    <link rel="stylesheet" href="./style/encabezado.css">
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="./index.php">Transportadora San Gabriel</a>
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
                  <i class="fas fa-home"></i>  Inicio 
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./login.php">
                  <i class="fa-solid fa-user"></i>  Iniciar sesion
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./register.php">
                  <i class="fas fa-sign-in-alt"></i>  Registrarse
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
      <?php
      require_once "backend/conexion.php"; 

      // Consulta para obtener las presentaciones de tipo VT
      $sql = "SELECT * FROM presentaciones WHERE tipo = 'VT'";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
      ?>
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
      <?php foreach ($presentaciones as $presentacion): ?>
        <div class="container">
          <div class="row">
            <div class="col-12"> 
              <div class="titulo">
                <h2><?php echo $presentacion['titulo']; ?></h2>
              </div>
              <div class="video-container">
                <?php if ($presentacion['ruta_video']): ?>
                  <video src="uploads/<?php echo $presentacion['ruta_video']; ?>" controls autoplay loop></video> 
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="./Js/view_dos.js"></script>
    </body>
    </html>