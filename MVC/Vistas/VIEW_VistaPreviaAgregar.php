<?php
    require_once("../Modelo/Usuario.php");
    require_once("../Controlador/Permisos.php");
    require_once('../Modelo/noticia.php');
    session_start();

    $usuario = new Usuario("","", "", "", "");
    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }
    $error = null;
    if (isset($_SESSION['mensaje']) && $_SESSION['mensaje']){
        $error = $_SESSION['mensaje'];
        unset($_SESSION['mensaje']);
    }
    $errorVistaPrev = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $errorVistaPrev = $_SESSION['id']; //
    }

    if (!Permisos::esRol('administradorContenido', $usuarioID)) {
        // 
        echo "Debes ser administrador de contenido para agregar noticias. "  . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }

    if (!Permisos::tienePermiso('Agregar Noticia', $usuarioID)) {
        echo "Debes tener permiso para realizar esta accion. " . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="../Vistas/script.js"></script>
    <script defer src="../controlador/JavaScript/scriptAgregarVistaPrevia.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></head>
<body>
    <div id="fondo"></div>
    <div id="navbar-container" class="pb-3"></div>
    <div class="container-fluid p-5 bg-primary text-white text-center">
        <h1>Formulario Para AGREGAR VISTA PREVIA de noticia</h1>
    </div>
    <p><?php echo $error ?></p>

    <div class="container card">
        <form action="../Controlador/agregarVistaPreviaNT.php" id="VistaPreviaForm" method="POST">
            <div class="mb-3">
                <label for="nuevo_titulo" class="form-label text-black">Título:</label>
                <input type="text" class="form-control" id="nuevo_titulo" name="nuevo_titulo" required>
                <div class="invalid-feedback">Titulo invalido, asegurese de que tenga minimo 5 caracteres y maximo 40 caracteres</div>
            </div>
            <div class="mb-3">
                <label for="nuevo_texto" class="form-label text-black">Descripción de la Noticia:</label>
                <textarea class="form-control" id="nuevo_texto" name="nuevo_texto" required></textarea>
                <div class="invalid-feedback">Descripcion invalida, debe contener maximo 120 caracteres y minimo 40</div>
            </div>
            <div class="mb-3">
                <label for="PathFoto1" class="form-label text-black">Seleccionar Foto 1:</label>
                <input type="file" class="form-control" id="PathFoto1" name="PathFoto1" accept="image/*" required>
                <div class="invalid-feedback">Por favor, selecciona una foto válida.</div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    

    <footer class="pt-5">
        <div id="footer-container"></div>
    </footer>
</body>

</html>