<?php
require_once "./conexion.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hashear la contraseña
    $role = 'admin'; // Establecer el rol como admin

    try {
        // Verificar si el usuario ya existe
        $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            // El usuario ya existe, mostrar una alerta
            echo "<script>alert('El usuario o correo electrónico ya está registrado.');</script>"; 
        } else {
            $conn->beginTransaction(); 

            try {
                // El usuario no existe, insertar los datos
                $stmt = $conn->prepare("INSERT INTO usuarios (username, email, password, role) VALUES (:username, :email, :password, :role)");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':role', $role);
                $stmt->execute();

                // Confirmar la transacción si la inserción fue exitosa
                $conn->commit();
                header("Location: ../login.php"); 
                exit();

            } catch(PDOException $e) {
                // Revertir la transacción en caso de error
                $conn->rollBack();
                echo "<script>alert('Error al crear el usuario: " . $e->getMessage() . "');</script>"; 
            }
        }

    } catch(PDOException $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "');</script>"; 
    }
}
?>