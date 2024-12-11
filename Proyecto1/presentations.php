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
    <link rel="stylesheet" href="./style/presentation.css">
    <link rel="stylesheet" href="./style/encabezado.css">
  </head>
  <body>
  <?php
require_once "backend/conexion.php"; // Incluir el archivo de conexión

// Consulta para obtener las presentaciones (ordena por fecha de creación descendente)
$sql = "SELECT p.*, u.username 
        FROM presentaciones p
        JOIN usuarios u ON p.usuario_id = u.id
        ORDER BY p.created_at DESC"; 
$stmt = $conn->prepare($sql);
$stmt->execute();
$presentaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="carousel-container">
  <?php foreach ($presentaciones as $presentacion): ?>
    <div class="carousel-item">
      <div class="col mb-4">
        <h1 class="col__titulo"><?php echo $presentacion['titulo']; ?></h1> 

        <div class="media-container"> 
          <?php if ($presentacion['tipo'] === 'VT'): ?> 
            <?php if ($presentacion['ruta_video']): ?>
              <video class="w-100 video-player" src="uploads/<?php echo $presentacion['ruta_video']; ?>" autoplay loop  muted ></video> 
            <?php endif; ?>
          <?php elseif ($presentacion['tipo'] === 'BT'): ?>
            <?php if ($presentacion['ruta_imagen']): ?>
              <img class="w-100" src="uploads/<?php echo $presentacion['ruta_imagen']; ?>" alt="Imagen"> 
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./Js/presentation.js"></script>
  </body>
</html>