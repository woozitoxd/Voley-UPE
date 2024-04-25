<?php
    include_once ('../Modelo/Jugador.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';

        if (!empty($_POST["nombre"]) && !empty($_POST["apellido"])){
            echo "Debes completar todos los campos para eliminar al jugador deseado";
        }
        
        $jugador = new Jugador("","", "","","","","","");

        $resultado = $jugador->eliminarNombreYApellido($nombre, $apellido);
        if($resultado == true)
        {
            header('Location: ../Vistas/controlAdmin.php');
            exit();
        }
    }
?>
