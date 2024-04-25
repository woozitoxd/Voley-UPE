<?php
    include_once ('../Modelo/Jugador.php');

        if($_SERVER["REQUEST_METHOD"] == "POST") 
        {
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
            $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : NULL;
            $edad = isset($_POST["edad"]) ? $_POST["edad"] : NULL;
            $altura = isset($_POST["altura"]) ? $_POST["altura"] : NULL;
            $id_posicion = isset($_POST["id_posicion"]) ? $_POST["id_posicion"] : NULL;
            $id_equipo =  isset($_POST["id_equipo"]) ? $_POST["id_equipo"] : NULL; 
            $pathFoto =  isset($_POST["pathFoto"]) ? $_POST["pathFoto"] : NULL;

            if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["edad"])&& !empty($_POST["altura"])&& !empty($_POST["id_posicion"])&& !empty($_POST["id_equipo"])&& !empty($_POST["pathFoto"])){
                echo "Debes completar todos los campos para lograr un registro exitoso";
            }

            echo "Nombre: " . $nombre . "<br>";
            echo "Apellido: " . $apellido . "<br>";
            echo "Edad: " . $edad . "<br>";
            echo "Altura: " . $altura . "<br>";
            echo "ID de Posición: " . $id_posicion . "<br>";
            echo "ID de Equipo: " . $id_equipo . "<br>";
            echo "Ruta de la Foto: " . $pathFoto . "<br>";

            $jugador = new Jugador("",$nombre, $apellido,$edad,$altura,$id_posicion,$id_equipo,$pathFoto);
            $ValidarJugador=$jugador->ValidarJugador($nombre,$apellido);

            if ($ValidarJugador !== true) {
                echo "Error: No se encontró un jugador con los datos proporcionados.";
                header('Location: ../Vistas/agregarJugador.php?modal=error');
            }else{
                $resultado = $jugador->registrar();
                if($resultado){
                    header('Location: ../Vistas/controlAdmin.php');
                    exit();
                }
            };
        }
?>