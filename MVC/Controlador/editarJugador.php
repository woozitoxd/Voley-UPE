<?php
    include_once ('../Modelo/Jugador.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validación de Campos
        if (empty($_POST["nombre"]) || empty($_POST["apellido"]) || empty($_POST["edad"]) || empty($_POST["altura"]) || empty($_POST["id_posicion"]) || empty($_POST["id_equipo"]) || empty($_POST["pathFoto"])) {
            header('Location: ../Vistas/EditarJugador.php?modal=error');
            exit();
        }

        if (empty($_POST["nombreViejo"]) || empty($_POST["apellidoViejo"]) || empty($_POST["id_equipoViejo"])) {
            header('Location: ../Vistas/EditarJugador.php?modal=error');
            exit();
        }

        $nombreViejo = isset($_POST["nombreViejo"]) ? $_POST["nombreViejo"] : null;
        $apellidoViejo = isset($_POST["apellidoViejo"]) ? $_POST["apellidoViejo"] : null;
        $edadVieja = isset($_POST["edadViejo"]) ? $_POST["edadViejo"] : null;
        $id_equipoViejo = isset($_POST["id_equipoViejo"]) ? $_POST["id_equipoViejo"] : null;

        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : null;
        $edad = isset($_POST["edad"]) ? $_POST["edad"] : null;
        $altura = isset($_POST["altura"]) ? $_POST["altura"] : NULL;
        $id_equipo = isset($_POST["id_equipo"]) ? $_POST["id_equipo"] : null;
        $id_posicion = isset($_POST["id_posicion"]) ? $_POST["id_posicion"] : NULL;
        $pathFoto =  isset($_POST["pathFoto"]) ? $_POST["pathFoto"] : NULL;

        $jugadorViejo = new Jugador("", $nombreViejo, $apellidoViejo, $edadVieja, "", "", $id_equipoViejo, "");
        $jugadorNuevo = new Jugador("", $nombre, $apellido, $edad, $altura, $id_equipo, $id_posicion, $pathFoto);

        // Validar Jugadores
        $ValidarJugador = $jugadorNuevo->ValidarJugador($nombre, $apellido);
        $ValidarJugadorViejo = $jugadorViejo->ValidarJugador($nombreViejo, $apellidoViejo);

        // Conseguir ID
        $id = $jugadorViejo->ConseguirID($nombreViejo, $apellidoViejo, $edadVieja, $id_equipoViejo);

        if ($id==false) {
            echo 'No se encontró el jugador';
            header('Location: ../Vistas/EditarJugador.php?modal=error');
            exit();
        }if ($jugadorNuevo->editar($id)) {
            header('Location: ../Vistas/controlAdmin.php');
            exit();
        }

        if (!$ValidarJugador  && !$ValidarJugadorViejo) {
           
                header('Location: ../Vistas/EditarJugador.php?modal=error');
                exit();
        }
        
    }
?>
