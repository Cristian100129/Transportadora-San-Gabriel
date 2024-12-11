
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
    <link rel="stylesheet" href="./style/update.css">
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
          <?php
require_once "backend/conexion.php";
session_start();

// Obtiene las presentaciones del usuario
$sql = "SELECT p.*, pr.hora_inicio, pr.dia_semana
        FROM presentaciones p
        INNER JOIN programacion pr ON p.id = pr.presentacion_id
        WHERE p.usuario_id = :usuario_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':usuario_id', $_SESSION['user_id']);
$stmt->execute();
$presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si hay presentaciones
if (count($presentaciones) === 0) {
    echo "<script>alert('No tienes presentaciones para editar.'); window.location.href='welcome.php';</script>";
    exit();
}
?>

<div class="container mt-5">
  <h1>Editar Presentación</h1>

  <?php foreach ($presentaciones as $presentacion): ?>
    <form id="editarPresentacionForm-<?php echo $presentacion['id']; ?>" action="./backend/.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="presentacion_id" value="<?php echo $presentacion['id']; ?>">

      <fieldset>
        <legend>Información de la Presentación</legend>
        <div class="mb-3">
          <label for="titulo-<?php echo $presentacion['id']; ?>" class="form-label">Título:</label>
          <input type="text" class="form-control" id="titulo-<?php echo $presentacion['id']; ?>" name="titulo" value="<?php echo $presentacion['titulo']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="tipo-<?php echo $presentacion['id']; ?>" class="form-label">Tipo de Presentación:</label>
          <select class="form-select" id="tipo-<?php echo $presentacion['id']; ?>" name="tipo" required>
            <option value="VT" <?php if ($presentacion['tipo'] === 'VT') echo 'selected'; ?>>Video con Título (VT)</option>
            <option value="VBL" <?php if ($presentacion['tipo'] === 'VBL') echo 'selected'; ?>>Video con Banner Lateral (VBL)</option>
            <option value="BT" <?php if ($presentacion['tipo'] === 'BT') echo 'selected'; ?>>Banner con Título (BT)</option>
          </select>
        </div>

        <div class="mb-3" id="contenedor-video-<?php echo $presentacion['id']; ?>">
          <label for="video-<?php echo $presentacion['id']; ?>" class="form-label">Video (solo para VT y VBL):</label>
          <input type="file" class="form-control" id="video-<?php echo $presentacion['id']; ?>" name="video" accept="video/*">
          <input type="hidden" name="ruta_video_actual" value="<?php echo $presentacion['ruta_video']; ?>">
          <?php if ($presentacion['ruta_video']): ?>
            <video width="320" height="240" controls>
              <source src="uploads/<?php echo $presentacion['ruta_video']; ?>" type="video/mp4">
              Tu navegador no soporta la etiqueta de video.
            </video>
          <?php endif; ?>
        </div>

        <div class="mb-3" id="contenedor-imagen-<?php echo $presentacion['id']; ?>">
          <label for="imagen-<?php echo $presentacion['id']; ?>" class="form-label">Imagen (solo para VBL y BT):</label>
          <input type="file" class="form-control" id="imagen-<?php echo $presentacion['id']; ?>" name="imagen" accept="image/*">
          <input type="hidden" name="ruta_imagen_actual" value="<?php echo $presentacion['ruta_imagen']; ?>">
          <?php if ($presentacion['ruta_imagen']): ?>
            <img src="uploads/<?php echo $presentacion['ruta_imagen']; ?>" alt="Imagen de la presentación" width="200">
          <?php endif; ?>
        </div>

        <div class="mb-3" id="contenedor-texto-banner-<?php echo $presentacion['id']; ?>">
          <label for="texto_banner-<?php echo $presentacion['id']; ?>" class="form-label">Texto del Banner (solo para VBL):</label>
          <textarea class="form-control" id="texto_banner-<?php echo $presentacion['id']; ?>" name="texto_banner"><?php echo $presentacion['texto_banner']; ?></textarea>
        </div>

        <div class="mb-3" id="contenedor-duracion-<?php echo $presentacion['id']; ?>">
          <label for="duracion-<?php echo $presentacion['id']; ?>" class="form-label">Duración (solo para BT, en segundos):</label>
          <input type="number" class="form-control" id="duracion-<?php echo $presentacion['id']; ?>" name="duracion" value="<?php echo $presentacion['duracion']; ?>">
        </div>
      </fieldset>

      <fieldset class="mt-4">
        <legend>Programación</legend>
        <div class="mb-3">
          <label for="hora_inicio-<?php echo $presentacion['id']; ?>" class="form-label">Hora de inicio:</label>
          <input type="time" class="form-control" id="hora_inicio-<?php echo $presentacion['id']; ?>" name="hora_inicio" value="<?php echo $presentacion['hora_inicio']; ?>" required>
        </div>

        <div class="mb-3">
          <label for="dia_semana-<?php echo $presentacion['id']; ?>" class="form-label">Día de la semana (opcional):</label>
          <select class="form-select" id="dia_semana-<?php echo $presentacion['id']; ?>" name="dia_semana">
            <option value="">Seleccionar día</option>
            <?php 
            for ($i = 1; $i <= 7; $i++) {
              $selected = ($presentacion['dia_semana'] == $i) ? 'selected' : '';
              echo "<option value=\"$i\" $selected>" . diaSemana($i) . "</option>";
            }
            ?>
          </select>
        </div>
      </fieldset>

      <button type="submit" class="btn btn-primary mt-4">Guardar Cambios</button>
      <a href="welcome_update.php" class="btn btn-secondary mt-4">Regresar</a>
    </form>
    <hr> 
  <?php endforeach; ?>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./Js/index.js"></script>
    <script src="./Js/welcome.js"></script>
  </body>
</html>
