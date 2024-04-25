<?php
    require_once("../Modelo/Usuario.php");
    include("../Controlador/Permisos.php");
    session_start();

    $usuario = new Usuario("","", "", "", "");
    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }
    if (!Permisos::esRol('administrador', $usuarioID)) {
        echo "Debes ser administrador para administrar contenido.";
        exit();
    }
    if (!Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes tener permiso para editar contenido.";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="stylesEquipo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="navbar-container"></div>
    <div class="container">
        <h1>Formulario de Eliminar de Jugador</h1>
        <form action="../controlador/eliminarJugador.php" method="post">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" required>
            </div><br>
            <button type="submit" class="btn btn-danger">Eliminar Jugador</button>
        </form>
    </div>
</body>
</html>
