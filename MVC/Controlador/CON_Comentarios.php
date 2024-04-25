<?php
require_once('../Modelo/MOD_Comentario.php');
require_once('../Controlador/iniciarSesionUsuario.php');
require_once('../controlador/Permisos.php');

$usuarioID = $_SESSION['id'];

if (!Permisos::tienePermiso('Comentar', $usuarioID) || !Permisos::esRol('usuario', $usuarioID)) {
        $_SESSION['errorcomentar'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> Debes ser un usuario registrado y tener permiso para comentar.
        </div>';
        header('Location: ../Vistas/NoticiasGeneral.php'); //Si el usuario intento comentar y no tiene permiso, se muestra un msj de error
    exit();
    }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $coment = $_POST["comentario"];
    $nombreUsuario = $_SESSION['nombre'];

    $ComentObj = new Comentarios("", "", "", "");
    $resultado = $ComentObj->AgregarComentario($usuarioID, $coment); //Metodo para agregar comentarios

    if ($resultado === true) {
        header('Location: ../Vistas/noticiasgeneral.php');
        exit();
    } else {
        echo $resultado;
    }
} else {
    echo "Faltan campos en la solicitud.";
}
?>