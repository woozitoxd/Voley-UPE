<?php
require_once('../modelo/Usuario.php');
require_once('../controlador/Permisos.php');
session_start();

$usuarioID = null;
if (isset($_SESSION['usuario']) && $_SESSION['usuario']) {
    $usuarioID = $_SESSION['id'];
}

if (!Permisos::tienePermiso('Editar Perfil', $usuarioID)) {
    echo'Debes tener permiso para editar el perfil' . '<a href="../Vistas/cambiarContrasenia.php">Volver</a>';
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $viejaPassword = isset($_POST["viejaPassword"]) ? $_POST["viejaPassword"] : "";
    $nuevaPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : "";
    $confirmarPassword = isset($_POST["passwordconfirmada"]) ? $_POST["passwordconfirmada"] : "";


    if (empty($viejaPassword) || empty($nuevaPassword) || empty($confirmarPassword)) {
        echo "Debes completar todos los campos."  . '<a href="../Vistas/cambiarContrasenia.php">Volver</a>';
        exit();
    }

    if ($nuevaPassword != $confirmarPassword) {
        echo "La nueva contraseña y la confirmación no coinciden." . '<a href="../Vistas/cambiarContrasenia.php">Volver</a>';
        exit();
    }

    if (!$usuarioID) {
        echo "Error: No se pudo obtener el ID del usuario." . '<a href="../Vistas/cambiarContrasenia.php">Volver</a>';
        exit();
    }

    $usuario = new perfilUser('', '', '', ''); 
    $contraseñaCorrecta = $usuario->verificarContraseña($usuarioID, $viejaPassword); //Le paso por parametro a la funcion el ID y la contraseña

    if (!$contraseñaCorrecta) {
        $_SESSION['actualizacionPerfil'] = '<div class="alert alert-warning">
        <strong>Error!</strong> La contraseña actual ingresada es incorrecta.
        </div>';
        header('Location: ../Vistas/cambiarContrasenia.php');
        exit();
    }

    $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);


    $actualizacionExitosa = $usuario->actualizarContraseña($usuarioID, $hashedPassword); //Si llegue a este punto, intento el cambio de contraseña

    if ($actualizacionExitosa) {
        $_SESSION['actualizacionPerfil'] = '<div class="alert alert-success">
        <strong>Hecho!</strong> Contraseña actualizada correctamente.
        </div>';
        header('Location: ../Vistas/cambiarContrasenia.php');

        exit();
    } else {
        echo "Error al actualizar la contraseña.";
        exit();
    }
} else {
    echo "Error: Método de solicitud no válido.";
    exit();
}
?>
