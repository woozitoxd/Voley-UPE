<?php
    include_once ('../Modelo/partido.php');
    include_once ('../Modelo/ubicacion.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") 
    { 
        $fechaRecibida = isset($_POST["fecha"]) ? $_POST["fecha"] : '';
        $puntosGanador = isset($_POST["puntosGanador"]) ? $_POST["puntosGanador"] : '' ;
        $puntosPerdedor = isset($_POST["puntosPerdedor"]) ? $_POST["puntosPerdedor"] : '';
        $equipo1Recibido = isset($_POST["equipo1"]) ? $_POST["equipo1"] : '';
        $equipo2Recibido = isset($_POST["equipo2"]) ? $_POST["equipo2"] : '';
        $equipoGanador= isset($_POST["equipoGanador"]) ? $_POST["equipoGanador"] : '';
        $equipoPerdedor= isset($_POST["equipoPerdedor"]) ? $_POST["equipoPerdedor"] : '';
        $ubicacionRecibida= isset($_POST["ubicacion"]) ? $_POST["ubicacion"] : '';
        $pathFoto = isset($_POST["pathFoto"]) ? $_POST["pathFoto"] : '';

        if(empty($fechaRecibida) || empty($puntosGanador) || empty($puntosPerdedor) || empty($equipo1Recibido) || empty($equipo2Recibido) || empty($equipoGanador) || empty($equipoPerdedor) || empty($ubicacionRecibida) || empty($pathFoto)){
            echo "Por favor complete todos los campos para el correcto registro del partido";
        }

        $partidoNuevo = new partido("","$equipo1Recibido","$equipo2Recibido","$fechaRecibida","$equipoGanador","$equipoPerdedor","$puntosGanador","$puntosPerdedor","$ubicacionRecibida","$pathFoto");
        $ValidarPartido=$partidoNuevo->validarEquipos($equipo1Recibido,$equipo2Recibido);
        $ValidarResultado=$partidoNuevo->ValidarGanador($equipoGanador,$equipoPerdedor);

        if($ValidarPartido && $ValidarResultado){
            $resultado = $partidoNuevo->agregar();
            if($resultado == true)
            {
                header('Location: ../Vistas/controlAdmin.php');
                exit();
            }
            else
            {
                echo "Error en la carga";
                header('Location: ../Vistas/AgregarPartido.php?modal=error');
            }   
        }else{
            echo "Error: No se encontró un jugador con los datos proporcionados.";
            header('Location: ../Vistas/AgregarPartido.php?modal=error');
        }
    }
?>