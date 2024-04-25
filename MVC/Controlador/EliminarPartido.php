<?php
    include_once ('../Modelo/partido.php');
    include_once ('../Modelo/ubicacion.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $fechaRecibida = isset($_POST["fecha"]) ? $_POST["fecha"] : '';
        $equipo1Recibido = isset($_POST["equipo1"]) ? $_POST["equipo1"] : '';
        $equipo2Recibido = isset($_POST["equipo2"]) ? $_POST["equipo2"] : '';

        if (!empty($_POST["fecha"]) && !empty($_POST["equipo1"])&& !empty($_POST["equipo2"])){
            echo "Debes completar todos los campos para eliminar el partido de forma exitosa";
        }
    
        $partidoAeliminar = new partido ("","","","","","","","","","");
        $ResultadoEquipos=$partidoAeliminar->validarEquipos($equipo1Recibido,$equipo2Recibido);
        $resultado = $partidoAeliminar->eliminarPartido($fechaRecibida,$equipo1Recibido,$equipo2Recibido);
       if($resultado == true && $ResultadoEquipos ==true)
       {
            header('Location: ../Vistas/controlAdmin.php');
            exit();
       }else
       {
            echo "Error en la carga";
            header('Location: ../Vistas/controlAdmin.php?modal=error');
            exit();
        }    
    }
?>