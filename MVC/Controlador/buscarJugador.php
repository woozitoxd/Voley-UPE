<?php
    include_once('../Modelo/Jugador.php');
    require_once('../controlador/iniciarSesionUsuario.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar campos obligatorios
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        $apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : '';
        $edad = isset($_POST["edad"]) ? $_POST["edad"] : '';
        $id_equipo = isset($_POST["id_equipo"]) ? $_POST["id_equipo"] : '';

        if (empty($nombre) || empty($apellido) || empty($edad) || empty($id_equipo)) {
            echo "Error: Todos los campos son obligatorios.";
            header('Location: ../Vistas/controlAdmin.php?modal=error');
            exit();
        }
        $jugador = new Jugador("","", "", "", "", "", "", "");
        $jugadorEncontrado = $jugador->buscar($nombre, $apellido, $edad, $id_equipo);
        // Imprimir información de la variable para debug
        var_dump($jugadorEncontrado);

        if ($jugadorEncontrado) {
            session_start();
            $_SESSION['jugadorEncontrado'] = $jugadorEncontrado;
            header('Location: ../Vistas/jugadorEncontrado.php');
            exit(); // Asegúrate de salir después de la redirección
        } else {
            echo "Error: No se encontró un jugador con los datos proporcionados.";
            header('Location: ../Vistas/controlAdmin.php?modal=error');
            exit();
        }
    }
?>