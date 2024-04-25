<?php
    include_once ('../Modelo/liga.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = isset($_POST["NombreLiga"]) ? $_POST["NombreLiga"] : '';

        if (empty($nombre)) {
            echo "Error: Complete el nombre de la liga.";
            header('Location: ../Vistas/controlAdmin.php?modal=error');
            exit();
        }
       
        $Liga = new liga ('',"");
        $buscarLiga= $Liga->buscarLiga($nombre);

        var_dump($buscarLiga);

        if ($buscarLiga) {
            session_start();
            $_SESSION['LigaEncontrada'] = $buscarLiga;
            header('Location: ../Vistas/LigaEncontrada.php');
            exit(); // Asegúrate de salir después de la redirección
        } else {
            echo "Error: No se encontró una liga con los datos proporcionados.";
            header('Location: ../Vistas/controlAdmin.php?modal=error');
            exit();
        }     
    }
?>