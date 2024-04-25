<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');
require_once("../Modelo/OpcionesSelect.php");

session_start();
$usuario = new Usuario("","", "", "", "");
$mensaje = null;
$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
} 
if (isset($_SESSION['mensaje']) && $_SESSION['mensaje']){
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
if (!Permisos::esRol('administradorContenido', $usuarioID) || !Permisos::tienePermiso('Agregar Noticia', $usuarioID)) {
    // 
    echo "No eres administrador de contenido y/o no posees el permiso para agregar noticias. " . '<a href="../Vistas/index.php">Volver</a>';
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
    <script defer src="../controlador/JavaScript/scriptAgregarNoticia.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="fondo"></div>
    <div id="navbar-container" class="pb-3"></div>
    <div class="container-fluid p-3 bg-primary text-white text-center">
        <h1 class="display-4">Formulario Para AGREGAR NOTICIA</h1>
    </div>

    <p class="text-center"><?php echo $mensaje ?></p>

    <div class="container card mt-3">

        <form action="../Controlador/AgregarNoticia.php" method="POST" id="FormNoticia" class="text-black">
            <div class="form-group">
                <label for="nuevo_titulo">Título:</label>
                <input type="text" class="form-control" id="nuevo_titulo" name="nuevo_titulo" placeholder="Titulo Noticia" required>
                <div class="invalid-feedback">Titulo invalido, asegúrese de que tenga mínimo 5 caracteres y máximo 40 caracteres</div>
            </div>
            <div class="form-group">
                <label for="nuevo_texto">Descripción de la Noticia:</label>
                <textarea class="form-control" id="nuevo_texto" name="nuevo_texto" required></textarea>
                <div class="invalid-feedback">Descripcion invalida, debe contener máximo 1000 caracteres y mínimo 120</div>
            </div>
            <div class="form-group">
                <label for="pathFoto1">Seleccionar Foto 1:</label>
                <input type="file" class="form-control-file" name="PathFoto1" id="pathFoto1" accept="image/*" required>
                <div class="invalid-feedback">Campo vacío, no olvide seleccionar una imagen.</div>
            </div>
            <div class="form-group">
                <label for="pathFoto2">Seleccionar Foto 2:</label>
                <input type="file" class="form-control-file" name="PathFoto2" id="pathFoto2" accept="image/*" required>
                <div class="invalid-feedback">Campo vacío, no olvide seleccionar una imagen.</div>
            </div>
            <div class="form-group">
                <label for="idVistaPrevia">Seleccione la vista previa de la noticia:</label>
                <select id="idVistaPrevia" name="idVistaPrevia" class="form-control">
                    <option value=""></option>
                    <?php
                    foreach ($noticias as $noticia) {
                        echo "<option value='{$noticia['id']}'>{$noticia['titulo']}</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Noticia invalida. No olvide seleccionar la vista previa creada previamente.</div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <footer class="mt-5">
        <div id="footer-container"></div>
    </footer>

</body>
</html>