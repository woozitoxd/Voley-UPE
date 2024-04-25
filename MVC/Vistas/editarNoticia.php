<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');
require_once("../Modelo/OpcionesSelect.php");
session_start();
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
    echo "Debes ser administrador de contenido para editar las noticias.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Editar Noticia', $usuarioID)) {
    echo "Debes tener permiso para editar contenido.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}

$opciones = new OpcionesMostrar($conn);
// Obtener opciones de usuarios y roles
$noticias = $opciones->obtenerOpcionesNoticias("noticias");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script defer src="../controlador/javascript/ValidacionEditNoticia.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></head>
<body>

    <div id="fondo"></div>
    <div id="navbar-container" class="pb-5"></div>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Formulario Para Actualizar NOTICIA</h1>
    </div>
    <p class="text-center"><?php echo $mensaje ?></p>


    <!-- Formulario -->
    <div class="container text-center card">
        <form action="../Controlador/edicionNoticia.php" method="POST" class="text-black pt-5" id="edicionForm">
            <div class="mb-3">
                <label for="idNoticia" class="form-label">Seleccione la noticia a editar:</label>
                <select id="idNoticia" name="idNoticia" class="form-select">
                    <option value=""></option>
                    <?php
                        foreach ($noticias as $noticia) {
                            echo "<option value='{$noticia['id']}'>{$noticia['titulo']}</option>";
                        }
                    ?>
                </select>
                <div class="invalid-feedback">Noticia invalida, seleccione una noticia que corresponda.</div>
            </div>

            <div class="mb-3">
                <label for="nuevo_titulo" class="form-label">Nuevo Título:</label>
                <input type="text" class="form-control" id="nuevo_titulo" name="nuevo_titulo" value="">
                <div class="invalid-feedback">Titulo invalido, asegurese de que tenga minimo 5 caracteres y maximo 40 caracteres</div>

            </div>

            <div class="mb-3">
                <label for="nuevo_texto" class="form-label">Nueva Descripción de la Noticia:</label>
                <textarea class="form-control" id="nuevo_texto" name="nuevo_texto"></textarea>
                <div class="invalid-feedback">Descripcion invalida, debe contener maximo 1000 caracteres y minimo 20</div>

            </div>

            <div class="mb-3">
                <label for="PathFoto1" class="form-label">Seleccionar Foto:</label>
                <input type="file" class="form-control" name="PathFoto1" id="PathFoto1" accept="image/*" required>
                <div class="invalid-feedback">Campo vacío, no olvide seleccionar una imagen.</div>

            </div>

            <div class="mb-3">
                <label for="PathFoto2" class="form-label">Seleccionar Foto 2:</label>
                <input type="file" class="form-control" name="PathFoto2" id="PathFoto2" accept="image/*" required>
                <div class="invalid-feedback">Campo vacío, no olvide seleccionar una imagen.</div>

            </div>

            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <!-- Footer -->
    <footer style="padding-top: 10%">
        <div id="footer-container"></div>
    </footer>
</body>
</html>