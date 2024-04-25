<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');
require_once("../Modelo/OpcionesSelect.php");
session_start();
$usuario = new Usuario("","", "", "", "");

$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}
$mensaje = null;
if (isset($_SESSION['mensaje']) && $_SESSION['mensaje']){
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido para editar las noticias. " . '<a href="../Vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Editar Noticia', $usuarioID)) {
    echo "Debes tener permiso para editar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
    exit();
}

$opciones = new OpcionesMostrar($conn);

// Obtener opciones de usuarios y roles
$noticias = $opciones->obtenerOpcionesNoticias("noticiasprincipales");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="../Vistas/script.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script defer src="../controlador/JavaScript/ValidacionEditVistaPrevia.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></head>
    <body>
    <div id="fondo"></div>
    <div id="navbar-container"class="pb-5"></div>
    
    <div class="container-fluid p-5 bg-primary text-white text-center" >
        <h1>Formulario Para Actualizar Vista Previa de NOTICIA</h1>
        <p>Seleccione la vista previa de una noticia para editarla.</p> 
    </div>
    
    <p class="text-center"><?php echo $mensaje ?></p>

    <div class="container text-center card">
        <form action="../Controlador/vistaPreviaEdit.php" class="text-black" method="POST" id="editForm" style="padding-top: 5%;">

            <div class="mb-3">
                <label for="idNoticiaVistaPrevia" class="form-label">Seleccione la vista previa a editar</label>
                <select id="idNoticiaVistaPrevia" name="idNoticiaVistaPrevia" class="form-select">
                    <option value=""></option>
                    <?php
                        foreach ($noticias as $noticia) {
                            echo "<option value='{$noticia['id']}'>{$noticia['titulo']}</option>";
                        }
                    ?>
                </select>
                <div class="invalid-feedback">Seleccione una vista previa válida.</div>
            </div>

            <div class="mb-3">
                <label for="TituloVistaPrevia" class="form-label">Nuevo Título:</label>
                <input type="text" class="form-control" id="TituloVistaPrevia" name="TituloVistaPrevia" value="">
                <div class="invalid-feedback">Titulo invalido, asegurese de que tenga minimo 5 caracteres y maximo 40 caracteres</div>
            </div>

            <div class="mb-3">
                <label for="textoVistaPrevia" class="form-label">Nueva Descripción de la Noticia:</label>
                <textarea class="form-control" id="textoVistaPrevia" name="textoVistaPrevia"></textarea>
                <div class="invalid-feedback">Descripcion invalida, debe contener maximo 120 caracteres y minimo 40</div>
            </div>

            <div class="mb-3">
                <label for="pathFoto" class="form-label">Seleccionar Foto 1: </label>
                <input type="file" class="form-control-file" name="PathFoto1" id="foto1" accept="image/*" required>
                <div class="invalid-feedback">Seleccione una foto válida.</div>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <footer style="padding-top: 10%">
        <div id="footer-container"></div>
    </footer>
</body>
</html>