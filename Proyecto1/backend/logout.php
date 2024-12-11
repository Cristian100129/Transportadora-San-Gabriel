<?php
session_start();
session_destroy(); 
header("Location: ../index.php"); // Redirigir a la página principal 
exit();
?>