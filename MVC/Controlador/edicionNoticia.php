<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once("../Modelo/Noticia.php");
require_once("../controlador/conexion_db.php");
session_start();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNoticia = isset($_POST['idNoticia']) ? $_POST['idNoticia'] : null;
    $nuevoTitulo = isset($_POST['nuevo_titulo']) ? $_POST['nuevo_titulo'] : null;
    $nuevaDescripcion = isset($_POST['nuevo_texto']) ? $_POST['nuevo_texto'] : null;
    $nuevaFoto1 = isset($_POST['PathFoto1']) ? $_POST['PathFoto1'] : null;
    $nuevaFoto2 = isset($_POST['PathFoto2']) ? $_POST['PathFoto2'] : null;

    // Validar que los campos no estén vacíos
    if (empty($idNoticia) || empty($nuevoTitulo) || empty($nuevaDescripcion)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> Debes completar todos los campos.
        </div>';
        header('Location: ../vistas/editarNoticia.php');
    } elseif (strlen($nuevoTitulo) < 5 || strlen($nuevoTitulo) > 40) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> El título debe tener entre 5 y 40 caracteres para actualizar la noticia.
        </div>';
        header('Location: ../vistas/editarNoticia.php');
    } elseif (strlen($nuevaDescripcion) > 1000) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> La descripción no puede exceder los 1000 caracteres.
        </div>';
        header('Location: ../vistas/editarNoticia.php');
    } else {
        $noticia = new Noticia($idNoticia, $nuevoTitulo, $nuevaDescripcion, $nuevaFoto1, $nuevaFoto2, '');
        $noticia->actualizarNoticia();
        $_SESSION['mensaje'] = '<div class="alert alert-success">  
        <strong>Actualizado!</strong> La noticia fue actualizada exitosamente.
        </div>';
        header("Location: ../vistas/editarNoticia.php");
    }
}
?>
