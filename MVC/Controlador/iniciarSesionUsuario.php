<?php
require_once('../Modelo/perfil.php');
session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar que se enviaron datos y que no estén vacíos
    if (isset($_POST["correo"]) && isset($_POST["userName"]) && isset($_POST["contraseña"]) && !empty($_POST["correo"]) && !empty($_POST["contraseña"])) {
        $nombre = $_POST["userName"];
        $correo = $_POST["correo"];
        $password = $_POST["contraseña"];
        
        
        // consulta para verificar si el usuario y la contraseña coinciden
        $usuario = new perfilUser("", "", "", "");
        $resultado = $usuario->consultar($nombre, $correo, $password);

        
        if ($resultado != null) {
            $_SESSION['id'] = $resultado['id']; //
            $_SESSION['usuario'] = $correo;
            $_SESSION['password'] = $password;

            header('Location: ../Vistas/index.php');
        
        }else{
            echo'NO REGISTRADO';
            header('Location: ../Vistas/index.php'); 
        exit();
        }
    }
}
?>


