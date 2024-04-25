<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once("../Modelo/Noticia.php");
require_once("../controlador/conexion_db.php");
session_start();
$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}    
if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido para editar las noticias.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Eliminar Noticia', $usuarioID)) {
    echo "Debes tener permiso para editar contenido.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $idNoticia = isset($_POST['idNoticia']) ? $_POST['idNoticia'] : null;

    if (empty($idNoticia)) {
        echo "Debes seleccionar una noticia para poder eliminarla noticia.";
    } else {
        $noticia = new Noticia($idNoticia, '', '', '', '', '');

        $noticia->eliminarNoticia(); //Metodo para eliminar una noticia

        echo "Noticia eliminada con exito";
        $_SESSION['mensaje'] = '<div class="alert alert-warning">
        <strong>Actualizado!</strong> Noticia eliminada con éxito.
        </div>';

        header("Location: ../vistas/NoticiasGeneral.php");

    }
}
?>
