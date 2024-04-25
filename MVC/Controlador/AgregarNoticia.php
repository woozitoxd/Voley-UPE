<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once("../Modelo/Noticia.php");

session_start();
$usuario = new Usuario("","", "", "", "");

$usuarioID = null;
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
} 


if (!Permisos::tienePermiso('Agregar Noticia', $usuarioID) || !Permisos::esRol('administradorContenido', $usuarioID)) {
    $_SESSION['errorcomentar'] = '<div class="alert alert-danger">
    <strong>Error!</strong> Debes ser administrador de contenido y tener permiso para realizar esta accion.
</div>';
    header('Location: ../Vistas/NoticiasGeneral.php');
exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoTitulo = isset($_POST['nuevo_titulo']) ? $_POST['nuevo_titulo'] : null;
    $nuevaDescripcion = isset($_POST['nuevo_texto']) ? $_POST['nuevo_texto'] : null;
    $nuevaFoto1 = isset($_POST['PathFoto1']) ? $_POST['PathFoto1'] : null;
    $nuevaFoto2 = isset($_POST['PathFoto2']) ? $_POST['PathFoto2'] : null;
    $idVistaPrevia = isset($_POST['idVistaPrevia']) ? $_POST['idVistaPrevia'] : null;

    // Valido que los campos no estén vacíos
    if (empty($nuevoTitulo) || empty($nuevaDescripcion) || empty($idVistaPrevia)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> Debes completar todos los campos.
        </div>';
        header('Location: ../vistas/VIEW_AgregarNoticia.php');
    } elseif (strlen($nuevoTitulo) < 5 || strlen($nuevoTitulo) > 40) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> El título debe tener entre 5 y 40 caracteres.
        </div>';
        header('Location: ../vistas/VIEW_AgregarNoticia.php');
    } elseif (strlen($nuevaDescripcion) > 1000) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> La descripción no puede exceder los 1000 caracteres.
        </div>';
        header('Location: ../vistas/VIEW_AgregarNoticia.php');
    } else {
        $noticia = new Noticia("", $nuevoTitulo, $nuevaDescripcion, $nuevaFoto1, $nuevaFoto2, $idVistaPrevia);
        $noticia->agregarNoticia();
        $_SESSION['mensaje'] = '<div class="alert alert-success">  
        <strong>Éxito!</strong> La noticia fue agregada exitosamente.
        </div>';
        header('Location: ../vistas/noticiasgeneral.php');
    }
}

?>