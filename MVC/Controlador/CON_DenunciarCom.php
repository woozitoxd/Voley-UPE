<?php
require_once('../Modelo/MOD_Comentario.php');
require_once('../Controlador/iniciarSesionUsuario.php');
require_once('../controlador/Permisos.php');

$usuarioID = $_SESSION['id'];

if (!Permisos::tienePermiso('Denunciar Comentario', $usuarioID) || !Permisos::esRol('usuario', $usuarioID)) {
        $_SESSION['errorcomentar'] = '<div class="alert alert-danger">
        <strong>Error!</strong> Debes tener permiso para poder denunciar.
    </div>';
        header('Location: ../Vistas/NoticiasGeneral.php');
    exit();
    }


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idDenuncia = isset($_POST['listaRazones']) ? $_POST['listaRazones'] : null;
    $idComentario = isset($_POST['comentarioId']) ? $_POST['comentarioId'] : null;
    echo($idComentario);
    //exit();
    $usuarioID = $_SESSION['id'];
    $ComentObj = new Comentarios("", "", "", "");
    $resultado = $ComentObj->ReportarComentario($idDenuncia, $idComentario, $usuarioID); //Metodo para denunciar un comentario
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