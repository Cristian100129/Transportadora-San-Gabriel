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
                  echo '<a class="nav-link" href="view_uno_session.php">'; 
                  echo '<i class="fa-solid fa-video"></i> Video con Banner Lateral'; 
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
                  echo '<a class="nav-link" href="update.php">'; 
                  echo '<i class="fas fa-user-edit"></i> Editar perfil'; 
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
        require_once "./backend/conexion.php"; 
        session_start();

        // Obtener el ID del usuario de la sesión
        $usuario_id = $_SESSION['user_id'];

        // Obtener la información de la presentación a editar
        if (isset($_GET["id"])) {
            $id_presentacion = $_GET["id"];

            try {
                // Verificar que la presentación pertenezca al usuario actual
                $stmt = $conn->prepare("SELECT * FROM reproductor_videos_presentaciones WHERE id = :id_presentacion AND usuario_id = :usuario_id");
                $stmt->bindParam(':id_presentacion', $id_presentacion);
                $stmt->bindParam(':usuario_id', $usuario_id);
                $stmt->execute();
                $presentacion = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$presentacion) {
                    echo "<script>alert('No tienes permiso para editar esta presentación o no existe.'); window.location.href='./welcome_update.php?error=1';</script>"; 
                    exit();
                }

                // Obtener la programación
                $stmt = $conn->prepare("SELECT * FROM reproductor_videos_programacion WHERE presentacion_id = :id_presentacion");
                $stmt->bindParam(':id_presentacion', $id_presentacion);
                $stmt->execute();
                $programacion = $stmt->fetch(PDO::FETCH_ASSOC); 

                if (!$programacion) {
                    echo "<script>alert('No se encontró la programación para esta presentación.'); window.location.href='./welcome_update.php?error=1';</script>"; 
                    exit();
                }

            } catch (PDOException $e) {
                echo "<script>alert('Error al obtener la presentación: " . $e->getMessage() . "'); window.location.href='./welcome_update.php?error=1';</script>";
                exit();
            }
        } else {
            echo "<script>alert('ID de presentación no válido.'); window.location.href='./welcome_update.php?error=1';</script>";
            exit();
        }

        if ($presentacion && $programacion) { 
        ?>

        <div class="container mt-5">
            <h1>Actualizar Presentación</h1>
            <form action="./backend/update_presentation.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_presentacion" value="<?php echo $presentacion['id']; ?>"> 
                <input type="hidden" name="ruta_video_actual" value="<?php echo $presentacion['ruta_video']; ?>">
                <input type="hidden" name="ruta_imagen_actual" value="<?php echo $presentacion['ruta_imagen']; ?>">

                <div id="campos-adicionales"> 
                    <fieldset id="info-presentacion">
                        <legend>Información de la Presentación</legend>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $presentacion['titulo']; ?>" required>
                        </div>

                        <div class="mb-3" id="contenedor-video">
                            <label for="video" class="form-label">Video:</label>
                            <input type="file" class="form-control" id="video" name="video" accept="video/*">
                            <?php if ($presentacion['ruta_video']): ?>
                                <p>Video actual: <?php echo $presentacion['ruta_video']; ?></p> 
                            <?php endif; ?>
                        </div>

                        <div class="mb-3" id="contenedor-imagen">
                            <label for="imagen" class="form-label">Imagen:</label>
                            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            <?php if ($presentacion['ruta_imagen']): ?>
                                <p>Imagen actual: <?php echo $presentacion['ruta_imagen']; ?></p> 
                            <?php endif; ?>
                        </div>

                        <div class="mb-3" id="contenedor-texto-banner">
                            <label for="texto_banner" class="form-label">Texto del Banner:</label>
                            <textarea class="form-control" id="texto_banner" name="texto_banner"><?php echo $presentacion['texto_banner']; ?></textarea>
                        </div>

                        <div class="mb-3" id="contenedor-duracion">
                            <label for="duracion" class="form-label">Duración (en segundos):</label>
                            <input type="number" class="form-control" id="duracion" name="duracion" value="<?php echo $presentacion['duracion']; ?>">
                        </div>
                    </fieldset>

                    <fieldset class="mt-4" id="programacion">
                        <legend>Programación</legend>
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de inicio:</label>
                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" value="<?php echo $programacion['hora_inicio']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="dia_semana" class="form-label">Día de la semana (opcional):</label>
                            <select class="form-select" id="dia_semana" name="dia_semana">
                                <option value="">Seleccionar día</option>
                                <?php 
                                $diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                                for ($i = 1; $i <= 7; $i++): ?>
                                    <option value="<?php echo $i; ?>" <?php if ($programacion['dia_semana'] == $i) echo 'selected'; ?>><?php echo $diasSemana[$i-1]; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </fieldset>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Actualizar Presentación</button>
                <a href="./welcome_delete.php?id=<?php echo $presentacion['id']; ?>" class="btn btn-danger mt-4">Eliminar Presentación</a> 
            </form>
        </div>

        <?php
        } else {
            echo "<p>No se encontró la presentación o la programación.</p>"; 
        }
        ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./Js/index.js"></script>
    <script src="./Js/welcome.js"></script>
  </body>
</html>