<?php
require_once("../Modelo/Usuario.php");
require_once("../Modelo/perfil.php");
require_once('../controlador/IniciarSesionUsuario.php');
require_once('../controlador/Permisos.php');
require_once('../controlador/conexion_db.php');
require_once('../Modelo/MOD_Comentario.php');

$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}

if (!Permisos::tienePermiso('Eliminar Comentario', $usuarioID) || !Permisos::esRol('administrador', $usuarioID)) {
    echo "Error, no posee el permiso para eliminar comentario" . '<a href="../vistas/VIEW_VerDenuncias.php">Volver</a>';
    exit();
}

if (isset($_GET['comentarioId']) && !empty($_GET['comentarioId'])) {
        // Obtengo el ID del comentario con GET
        $comentarioId = $_GET['comentarioId'];

        // Validar el comentarioId
        if (!is_numeric($comentarioId) || $comentarioId <= 0) {
            echo 'ID de comentario no válido.';
            exit;
        }

        $coment = new Comentarios('', '', '', '');

        //  elimino el comentario
        if ($coment->EliminarComentario($comentarioId)) {
            $_SESSION['comentarioEliminado'] = '<div class="alert alert-success">
            <strong>Hecho!</strong> El comentario se ha eliminado.
            </div>';
            header('Location: ../Vistas/VIEW_VerDenuncias.php');
        } else {
            echo 'No se pudo eliminar el comentario.';
        }
    } else {
        echo 'ID de comentario no proporcionado.';
}


exit();


?>