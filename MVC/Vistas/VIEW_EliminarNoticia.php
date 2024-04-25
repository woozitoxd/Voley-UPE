<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');
require_once('../Modelo/OpcionesSelect.php');
session_start();
$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}    
if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido para editar las noticias. " . '<a href="../Vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Eliminar Noticia', $usuarioID)) {
    echo "Debes tener permiso para editar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
    exit();
}

$opciones = new OpcionesMostrar($conn);
$usuarios = $opciones->obtenerOpcionesNoticias("noticiasprincipales");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="../Vistas/script.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script defer src="../controlador/JavaScript/scriptEliminarNoticia.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></head>
<body>

    <div id="fondo"></div>
        <!-- Incluyo la barra de navegación utilizando JavaScript -->
    <div id="navbar-container"></div>
    
    <div class="container-fluid p-5 bg-primary text-white text-center" style="padding-top: 10%;">
      <h1>Formulario Para Eliminar NOTICIA</h1>
    </div>
    <div class="container text-center card" >
        <form action="../Controlador/CON_EliminarNoticia.php" id="EliminarNoticiaForm" method="post">

            <div class="mb-3">
                <label for="idNoticia" class="form-label">SELECCIONE LA NOTICIA QUE DESEA ELIMINAR</label>
                <select id="idNoticia" name="idNoticia" class="form-select">
                    <option value=""></option>
                    <?php
                    foreach ($usuarios as $usuario) {
                        echo "<option value='{$usuario['id']}'>{$usuario['titulo']}</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Debe seleccionar una de las noticias existentes.</div>

            </div>

            <button type="submit" class="btn btn-primary">Confirmar Eliminacion</button>
        </form>
    </div> 

    <footer style="padding-top: 10%">
      <div id="footer-container"></div>
    </footer>
</body>
</html>