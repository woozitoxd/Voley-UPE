<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once("../Modelo/Noticia.php");

session_start();
$usuario = new Usuario("","", "", "", "");

$usuarioID = $_SESSION['id']; // Asegúrate de que $_SESSION['usuario_id'] se establezca correctamente

if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido para editar las noticias.";
    exit();
}

if (!Permisos::tienePermiso('Editar Noticia', $usuarioID)) {
    // Verifica si el usuario tiene el permiso 'editar_contenido' usando el método tienePermiso de Permisos
    echo "Debes tener permiso para editar contenido.";
    exit();
}

// Si llega hasta aquí, el usuario tiene el rol y permisos necesarios para administrar contenido

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNoticia = isset($_POST['idNoticiaVistaPrevia']) ? $_POST['idNoticiaVistaPrevia'] : null;
    $nuevoTitulo = isset($_POST['TituloVistaPrevia']) ? $_POST['TituloVistaPrevia'] : null;
    $nuevaDescripcion = isset($_POST['textoVistaPrevia']) ? $_POST['textoVistaPrevia'] : null;
    $nuevaFoto1 = isset($_POST['PathFoto1']) ? $_POST['PathFoto1'] : null;

    // Validar que los campos no estén vacíos y cumplan con los rangos
    if (empty($idNoticia) || empty($nuevoTitulo) || empty($nuevaDescripcion)) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> Debes completar todos los campos.
        </div>';
        header('Location: ../vistas/editarVistaPrevia.php');
    } elseif (strlen($nuevoTitulo) < 10 || strlen($nuevoTitulo) > 40) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> El título debe tener entre 10 y 40 caracteres para actualizar la vista previa.
        </div>';
        header('Location: ../vistas/editarVistaPrevia.php');
    } elseif (strlen($nuevaDescripcion) < 40 || strlen($nuevaDescripcion) > 120) {
        $_SESSION['mensaje'] = '<div class="alert alert-danger">  
        <strong>Error!</strong> La descripción debe tener entre 40 y 120 caracteres.
        </div>';
        header('Location: ../vistas/editarVistaPrevia.php');
    } else {
        // Crear una instancia de la clase Noticia
        $noticia = new Noticia($idNoticia, $nuevoTitulo, $nuevaDescripcion, '', '', '');

        // Llamar al método actualizarNoticia() en la instancia
        $noticia->actVistaPreviaNoticias();
        $_SESSION['mensaje'] = '<div class="alert alert-success">
        <strong>Hecho!</strong> Noticia actualizada con éxito.
        </div>';
        header("Location: ../vistas/NoticiasGeneral.php");
    }
}

?>
