<?php
require_once "conexion.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_presentacion = $_POST["id_presentacion"];
    $usuario_id = $_SESSION['user_id']; 

    try {
        $stmt = $conn->prepare("SELECT * FROM reproductor_videos_presentaciones WHERE id = :id_presentacion AND usuario_id = :usuario_id"); 
        $stmt->bindParam(':id_presentacion', $id_presentacion);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $presentacion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$presentacion) {
            echo "<script>alert('No tienes permiso para editar esta presentación.'); window.location.href='../welcome_update.php?error=1';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error al obtener la presentación: " . $e->getMessage() . "'); window.location.href='../welcome_update.php?error=1';</script>";
        exit();
    }

    $titulo = $_POST["titulo"];
    $texto_banner = $_POST["texto_banner"];
    $duracion = $_POST["duracion"];
    $hora_inicio = $_POST["hora_inicio"];
    $dia_semana = $_POST["dia_semana"];

    $ruta_video = $_POST["ruta_video_actual"]; 
    $ruta_imagen = $_POST["ruta_imagen_actual"]; 

    // ... (código para el manejo de archivos - subirArchivo) ...

    try {
        $conn->beginTransaction();
        try {
            // Actualizar la presentación (sin el campo 'tipo')
            $stmt = $conn->prepare("UPDATE reproductor_videos_presentaciones SET 
                titulo = :titulo, 
                ruta_video = :ruta_video, 
                ruta_imagen = :ruta_imagen, 
                texto_banner = :texto_banner, 
                duracion = :duracion 
                WHERE id = :id_presentacion");

            $stmt->bindParam(':id_presentacion', $id_presentacion);
            $stmt->bindParam(':titulo', $titulo);
            $stmt->bindParam(':ruta_video', $ruta_video);
            $stmt->bindParam(':ruta_imagen', $ruta_imagen);
            $stmt->bindParam(':texto_banner', $texto_banner);
            $stmt->bindParam(':duracion', $duracion);
            $stmt->execute();

            // Eliminar la programación anterior
            $stmt = $conn->prepare("DELETE FROM reproductor_videos_programacion WHERE presentacion_id = :id_presentacion");
            $stmt->bindParam(':id_presentacion', $id_presentacion);
            $stmt->execute();

            // Insertar la nueva programación
            $stmt = $conn->prepare("INSERT INTO reproductor_videos_programacion (presentacion_id, hora_inicio, dia_semana) 
                                    VALUES (:id_presentacion, :hora_inicio, :dia_semana)");
            $stmt->bindParam(':id_presentacion', $id_presentacion);
            $stmt->bindParam(':hora_inicio', $hora_inicio);
            $stmt->bindParam(':dia_semana', $dia_semana);
            $stmt->execute();

            $conn->commit();
            echo "<script>alert('Presentación actualizada correctamente.'); window.location.href='../welcome_update.php';</script>"; 
            exit();

        } catch (PDOException $e) {
            $conn->rollBack();
            echo "<script>alert('Error al actualizar la presentación: " . $e->getMessage() . "'); window.location.href='../welcome_update.php?error=1';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='../welcome_update.php?error=1';</script>";
        exit();
    }
}

// ... (función subirArchivo) ...

// Obtener la información de la presentación a editar
if (isset($_GET["id"])) {
    $id_presentacion = $_GET["id"];
    $usuario_id = $_SESSION['user_id']; 

    try {
        $stmt = $conn->prepare("SELECT * FROM reproductor_videos_presentaciones WHERE id = :id_presentacion AND usuario_id = :usuario_id"); 
        $stmt->bindParam(':id_presentacion', $id_presentacion);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        $presentacion = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$presentacion) {
            echo "<script>alert('No tienes permiso para editar esta presentación.'); window.location.href='../welcome_update.php?error=1';</script>";
            exit();
        }

        // Obtener la programación
        $stmt = $conn->prepare("SELECT * FROM reproductor_videos_programacion WHERE presentacion_id = :id_presentacion");
        $stmt->bindParam(':id_presentacion', $id_presentacion);
        $stmt->execute();
        $programacion = $stmt->fetch(PDO::FETCH_ASSOC); 

    } catch (PDOException $e) {
        echo "<script>alert('Error al obtener la presentación: " . $e->getMessage() . "'); window.location.href='../welcome_update.php?error=1';</script>";
        exit();
    }
} else {
    echo "<script>alert('ID de presentación no válido.'); window.location.href='../welcome_update.php?error=1';</script>";
    exit();
}
?>