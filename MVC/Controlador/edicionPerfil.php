<?php
require_once("../Modelo/perfil.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/IniciarSesionUsuario.php');

$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}


if (!Permisos::tienePermiso('Editar Perfil', $usuarioID)) {
    echo'Debes tener permiso para editar el perfil';
    //header('Location: ../Vistas/index.php'); //No dejo que el usuario entre a la seccion de edicion de perfil
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = isset($_POST['editNombre']) ? $_POST['editNombre'] : null;
    $email = isset($_POST['editCorreo']) ? $_POST['editCorreo'] : null;
    $fechaNacido = isset($_POST['editFecha']) ? $_POST['editFecha'] : null;

    $editCompleto = new perfilUser($email, "", $fechaNacido, $nombre);
    
    if (empty($nombre) || empty($email) || empty($fechaNacido)) {
        echo "Debes completar todos los campos para actualizar. " ;
        
    }
    /////////////////////////////////////////////
    $resultado = $editCompleto->validaRequerido($nombre, $email, $fechaNacido);
    if($resultado !== true) {
        echo 'ERROR: ' . $resultado . '<a href="../Vistas/EditarPerfil.php"> Volver</a>';
        return false;
    }
    ////////////////////////////////////////////
    $validar = $editCompleto->editarPerfil($usuarioID);
    if ($validar !== true){
        echo 'ERROR: ' . $validar;
        return false;
    }else{
        $_SESSION['actualizacionPerfil'] = '<div class="alert alert-success">
        <strong>Actualizado!</strong> Perfil actualizado con éxito.
        </div>';
        header('Location: ../Vistas/VerPerfil.php');
    }
}

?>