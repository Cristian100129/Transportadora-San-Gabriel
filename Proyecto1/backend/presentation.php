<?php
require_once "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : ""; 
    $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : ""; 
    $texto_banner = isset($_POST["texto_banner"]) ? $_POST["texto_banner"] : null;
    $duracion = isset($_POST["duracion"]) ? $_POST["duracion"] : null;
    $dia_semana = isset($_POST["dia_semana"]) ? $_POST["dia_semana"] : null;
    $hora_inicio = isset($_POST["hora_inicio"]) ? $_POST["hora_inicio"] : ""; 

    $usuario_id = $_SESSION['user_id'];

    $ruta_video = null;
    $ruta_imagen = null;

    // Subir video si se seleccionó
    if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
        $ruta_video = subirArchivo($_FILES['video'],'ruta_video');
        if ($ruta_video === false) {
            echo "<script>window.location.href='../welcome.php?error=1';</script>";
            exit();
        }
    }

    // Subir imagen si se seleccionó
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ruta_imagen = subirArchivo($_FILES['imagen'],'ruta_imagen');
        if ($ruta_imagen === false) {
            echo "<script>window.location.href='../welcome.php?error=1';</script>";
            exit();
        }
    }

    try {
        $conn->beginTransaction();

        try {
            // Insertar presentación
            $stmt = $conn->prepare("INSERT INTO presentaciones (usuario_id, titulo, tipo, ruta_video, ruta_imagen, texto_banner, duracion) 
                                    VALUES (:usuario_id, :titulo, :tipo, :ruta_video, :ruta_imagen, :texto_banner, :duracion)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->bindParam(':ruta_video', $ruta_video);
            $stmt->bindParam(':ruta_imagen', $ruta_imagen);
            $stmt->bindParam(':texto_banner', $texto_banner);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->execute();

            $presentacion_id = $conn->lastInsertId();

            // Calcular el orden
            $stmt = $conn->prepare("SELECT MAX(orden) FROM programacion WHERE usuario_id = :usuario_id");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->execute();
            $orden_maximo = $stmt->fetchColumn();
            $orden = ($orden_maximo !== false) ? $orden_maximo + 1 : 1;

            // Insertar programación
            $stmt = $conn->prepare("INSERT INTO programacion (usuario_id, presentacion_id, hora_inicio, orden, dia_semana) 
                                    VALUES (:usuario_id, :presentacion_id, :hora_inicio, :orden, :dia_semana)");
            $stmt->bindParam(':usuario_id', $usuario_id);
            $stmt->bindParam(':presentacion_id', $presentacion_id);
            $stmt->bindParam(':hora_inicio', $hora_inicio);
            $stmt->bindParam(':orden', $orden);
            $stmt->bindParam(':dia_semana', $dia_semana);
            $stmt->execute();

            $conn->commit();

            // Redirigir según el tipo de presentación
            $url_redireccion = '';
            if ($tipo === 'VT') {
                $url_redireccion = '../view_dos_session.php';
            } elseif ($tipo === 'BT') {
                $url_redireccion = '../view_tres_session.php';
            }

            echo "<script>alert('Presentación guardada correctamente.'); window.location.href='$url_redireccion';</script>";
            exit();

        } catch (PDOException $e) {
            $conn->rollBack();
            echo "<script>alert('Error al guardar la presentación: " . $e->getMessage() . "'); window.location.href='../welcome.php?error=1';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='../welcome.php?error=1';</script>";
        exit();
    }
}

function subirArchivo($archivo) {
    $ruta_base = $_SERVER['DOCUMENT_ROOT'] . '/Proyecto/';
    $target_dir = $ruta_base . 'uploads/';
    $nombre_original = basename($archivo["name"]);
    $target_file = $target_dir . $nombre_original; 
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Verifica el tamaño del archivo (1GB máximo)
    if ($archivo["size"] > 1073741824) { 
        $uploadOk = 0;
        echo "<script>alert('El archivo es demasiado grande.');</script>"; 
    }

    $allowed_types = ["jpg", "png", "jpeg", "gif", "mp4"];
    if(!in_array($imageFileType, $allowed_types)) {
        $uploadOk = 0;
        echo "<script>alert('Formato de archivo no permitido.');</script>"; 
    }

    if ($uploadOk == 0) {
        return false;
    } else {
        if (move_uploaded_file($archivo["tmp_name"], $target_file)) {
            return $nombre_original;
        } else {
            echo "<script>alert('Error al subir el archivo.');</script>"; 
            return false;
        }
    }
}
?>