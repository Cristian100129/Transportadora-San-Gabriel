<?php
require_once "conexion.php"; 
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtiene los datos del formulario
    $userId = $_SESSION['user_id']; 
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"]; 

    // Hashea la nueva contraseña si se proporciona
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    try {
        // Prepara la consulta SQL para actualizar los datos del usuario
        $sql = "UPDATE usuarios SET username = :username, email = :email";
        if (!empty($password)) {
            $sql .= ", password = :password"; 
        }
        $sql .= " WHERE id = :userId";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        if (!empty($password)) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':userId', $userId);

        // Ejecuta la consulta
        $stmt->execute();

        // Actualiza el nombre de usuario en la sesión si se modificó
        $_SESSION['username'] = $username;
        echo "<script>
        alert('Datos actualizados correctamente.'); 
        window.location.href='../welcome.php';
        </script>";
exit();
      

    } catch(PDOException $e) {
        echo "<script>alert('Error al actualizar los datos: " . $e->getMessage() . "');</script>";
    }
}
?>