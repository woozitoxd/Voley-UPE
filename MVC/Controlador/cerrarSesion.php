<?php
session_start();
session_destroy(); // Cierra la sesion
header('Location: ../Vistas/index.php'); // Redirige a la pag de inicio 
exit();
?>