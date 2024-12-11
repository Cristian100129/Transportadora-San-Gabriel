<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $presentacion_id = $_GET["id"];

    try {
        $conn->beginTransaction();

        try {
            $stmt = $conn->prepare("DELETE FROM programacion WHERE presentacion_id = :presentacion_id");
            $stmt->bindParam(':presentacion_id', $presentacion_id);
            $stmt->execute();
            $stmt = $conn->prepare("DELETE FROM presentaciones WHERE id = :presentacion_id");
            $stmt->bindParam(':presentacion_id', $presentacion_id);
            $stmt->execute();
            $conn->commit();
            echo "<script>alert('Presentación eliminada correctamente.'); window.location.href='../welcome.php';</script>";
            exit();

        } catch (PDOException $e) {
            $conn->rollBack();
            echo "<script>alert('Error al eliminar la presentación: " . $e->getMessage() . "'); window.location.href='../welcome.php?error=1';</script>";
            exit();
        }

    } catch (PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='../welcome.php?error=1';</script>";
        exit();
    }
}
?>