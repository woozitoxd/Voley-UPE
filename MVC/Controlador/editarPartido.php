<?php
      include_once ('../Modelo/partido.php');
      include_once ('../Modelo/ubicacion.php');
  
      if($_SERVER["REQUEST_METHOD"] == "POST") 
      {
        
        $fechaRecibida = isset($_POST["fechaEditar"]) ? $_POST["fechaEditar"] : '';
        $equipo1RecibidoViejo = isset($_POST["equipo1Editar"]) ? $_POST["equipo1Editar"] : '';
        $equipo2RecibidoViejo = isset($_POST["equipo2Editar"]) ? $_POST["equipo2Editar"] : '';
                                     //Verifico
        if (!empty($_POST["fechaEditar"]) && !empty($_POST["equipo1Editar"]) && !empty($_POST["equipo2Editar"])){
            echo "Debes completar todos los campos";
        }
                //Nuevos Datos
          $fechaRecibida = isset($_POST["fecha"]) ? $_POST["fecha"] : '';
          $puntosGanador = isset($_POST["puntosGanador"]) ? $_POST["puntosGanador"] : '';
          $puntosPerdedor = isset($_POST["puntosPerdedor"]) ? $_POST["puntosPerdedor"] : '';
          $equipo1RecibidoNUevo = isset($_POST["equipo1"]) ? $_POST["equipo1"] : '';
          $equipo2RecibidoNuevo = isset($_POST["equipo2"]) ? $_POST["equipo2"] : '';
          $equipoGanadorNuevo= isset($_POST["equipoGanador"]) ? $_POST["equipoGanador"] : '';
          $equipoPerdedorNuevo= isset($_POST["equipoPerdedor"]) ? $_POST["equipoPerdedor"] : '';
          $ubicacionRecibida= isset($_POST["ubicacion"]) ? $_POST["ubicacion"] : '';
          $pathFoto = isset($_POST["pathFoto"]) ? $_POST["pathFoto"] : '';
      
        $PartidoViejo=new partido("","","","","","","","","","");
        $partidoNuevo = new partido("","$equipo1RecibidoNuevo","$equipo2RecibidoNuevo","$fechaRecibida","$equipoGanador","$equipoPerdedorNuevo","$puntosGanadorNuevo","$puntosPerdedor","$ubicacionRecibida","$pathFoto");
        
        $ValidarPartidoViejo=$PartidoViejo->validarEquipos($equipo1RecibidoViejo,$equipo2RecibidoViejo);

        $ValidarPartido=$partidoNuevo->validarEquipos($equipo1RecibidoNuevo,$equipo2RecibidoNuevo);
        $ValidarResultado=$partidoNuevo->ValidarGanador($equipoGanadorNuevo,$equipoPerdedorNuevo);
      
        $id = $PartidoViejo->ConseguirID($fechaRecibida,$equipo1Recibido,$equipo2Recibido);

        if($ValidarPartido && $ValidarResultado && $ValidarPartidoViejo){

            if ($partidoNuevo->editar($id)) {
                header('Location: ../Vistas/controlAdmin.php');
                exit();
            } 
        }else {
            echo "Error al editar el Partido";
            header('Location: ../Vistas/EditarPartido.php?modal=error');
            exit();
        }
    }
?>