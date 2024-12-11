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
    <link rel="stylesheet" href="./style/welcome.css">
    <link rel="stylesheet" href="./style/index.css">
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
          <div class="container mt-5">
  <h1>Subir Presentación</h1>
  <form id="presentacionForm" action="./backend/presentation.php" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo de Presentación:</label>
      <select class="form-select" id="tipo" name="tipo" required>
        <option value="">Selecciona una opción</option>
        <option value="VT">Video con Título (VT)</option>
        <option value="BT">Banner con Título (BT)</option>
      </select>
    </div>

    <div id="campos-adicionales">
      <fieldset id="info-presentacion">
        <legend>Información de la Presentación</legend>
        <div class="mb-3">
          <label for="titulo" class="form-label">Título:</label>
          <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>

        <div class="mb-3" id="contenedor-video">
          <label for="video" class="form-label">Video:</label>
          <input type="file" class="form-control" id="video" name="video" accept="video/*">
        </div>

        <div class="mb-3" id="contenedor-imagen">
          <label for="imagen" class="form-label">Imagen:</label>
          <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
        </div>

        <div class="mb-3" id="contenedor-texto-banner">
          <label for="texto_banner" class="form-label">Texto del Banner :</label>
          <textarea class="form-control" id="texto_banner" name="texto_banner"></textarea>
        </div>

        <div class="mb-3" id="contenedor-duracion">
          <label for="duracion" class="form-label">Duración del video (segundos):</label>
          <input type="number" class="form-control" id="duracion" name="duracion">
        </div>
      </fieldset>

      <fieldset class="mt-4" id="programacion">
        <legend>Programación</legend>
        <div class="mb-3">
          <label for="hora_inicio" class="form-label">Hora de inicio:</label>
          <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
        </div>

        <div class="mb-3">
          <label for="dia_semana" class="form-label">Día de la semana (opcional):</label>
          <select class="form-select" id="dia_semana" name="dia_semana">
            <option value="">Seleccionar día</option>
            <option value="1">Domingo</option>
            <option value="2">Lunes</option>
            <option value="3">Martes</option>
            <option value="4">Miércoles</option>
            <option value="5">Jueves</option>
            <option value="6">Viernes</option>
            <option value="7">Sábado</option>
          </select>
        </div>
      </fieldset>
    </div>

    <button type="submit" class="btn btn-primary mt-4">Guardar Presentación</button>
  </form>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./Js/index.js"></script>
    <script src="./Js/welcome.js"></script>
  </body>
</html>