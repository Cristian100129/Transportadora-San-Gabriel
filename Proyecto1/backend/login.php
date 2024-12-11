<?php
require_once "./conexion.php"; // Incluir el archivo de conexión
session_start(); // Iniciar la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        // Consulta a la base de datos para obtener la información del usuario
        $stmt = $conn->prepare("SELECT id, username, password FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            // El usuario existe y la contraseña es correcta
            // Guardar el ID del usuario y el nombre de usuario en la sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            $_SESSION['email'] = $usuario['email'];
            // Redirije al usuario a welcome
            header("Location: ../welcome.php"); 
            exit();
        } else {
            // El usuario no existe o la contraseña es incorrecta
            echo "<script>
            alert('Correo electrónico o contraseña incorrectos.'); 
            window.location.href='../login.php'; 
            </script>";
    exit(); 
        }

    } catch(PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
    }
}
?>