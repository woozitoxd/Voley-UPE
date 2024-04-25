<?php
require_once ('../Modelo/Usuario.php');
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');

session_start();
$usuarioID = null;

if (isset($_SESSION['usuario']) && $_SESSION['usuario']) {
    $usuarioID = $_SESSION['id'];
}

if (!Permisos::esRol('administrador', $usuarioID) || !Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
    echo "Debes ser administrador para administrar contenido." . '<a href="../vistas/ControlAdmin.php">Volver</a>';

    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = isset($_POST["idUsuario"]) ? $_POST["idUsuario"] : NULL;
    $rol = isset($_POST["idRol"]) ? $_POST["idRol"] : NULL;

    // Validar campos no configurados como NULL
    if ($nombre === NULL || $rol === NULL) {
        echo "Debes completar todos los campos para asignar un rol.";
        echo '<a href="../vistas/VIEW_RegistrarADM.php">Volver</a>';
        exit();
    }

    $usuario = new Usuario("", "", "", "", "");
    $resultado = $usuario->registrarADM($nombre, $rol);

    if ($resultado === true) {
        // Redirección después del registro (asegúrate de que no haya salida previa)
        header('Location: ../Vistas/controlAdmin.php');
        exit();
    } else {
        // Manejo de errores: mostrar mensaje de error
        echo $resultado . '<a href="../vistas/VIEW_RegistrarADM.php">Volver</a>';
;
    }
}
?>