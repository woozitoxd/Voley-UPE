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


if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido para agregar noticias." . '<a href="../vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Agregar Noticia', $usuarioID)) {
    echo "Debes tener permiso para administrar contenido.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevoTitulo = isset($_POST['nuevo_titulo']) ? $_POST['nuevo_titulo'] : null;
    $nuevaDescripcion = isset($_POST['nuevo_texto']) ? $_POST['nuevo_texto'] : null;
    $nuevaFoto1 = isset($_POST['PathFoto1']) ? $_POST['PathFoto1'] : null;

    // Validaciones
    if (empty($nuevaDescripcion) || empty($nuevoTitulo) || empty($nuevaFoto1)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error:</strong> Debes completar todos los campos para agregar la vista previa de la noticia.
        </div>';
        header('Location: ../vistas/VIEW_VistaPreviaAgregar.php');
        exit();
    }

    if (strlen($nuevoTitulo) > 40 || strlen($nuevoTitulo) < 5 || strlen($nuevaDescripcion) > 120 || strlen($nuevaDescripcion) < 10) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error:</strong> El rango de campos no cumple con los requisitos (mínimo 5 y 60 caracteres para título y descripción, respectivamente; máximo 40 para título y 120 para descripción).
        </div>';
        header('Location: ../vistas/VIEW_VistaPreviaAgregar.php');
        exit();
    }

    // Si pasa las validaciones, proceder con la inserción
    $noticia = new Noticia('', $nuevoTitulo, $nuevaDescripcion, $nuevaFoto1, '', '');
    $noticia->agregarVistaPrevia();

    $_SESSION['mensaje'] = '<div class="alert alert-success">  
    <strong>Éxito:</strong> Vista previa de la noticia agregada con éxito.
    </div>';
    header('Location: ../vistas/VIEW_AgregarNoticia.php');
    exit();
}

?>