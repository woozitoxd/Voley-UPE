<?php
    session_start();
    include("../Modelo/Usuario.php");
    include("../Controlador/Permisos.php");

    $usuario = new Usuario("","", "", "", "");
    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }    
    if (!Permisos::esRol('administrador', $usuarioID)) {
        echo "Debes ser administrador para administrar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }
    if (!Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes tener permiso para editar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }
    if (isset($_SESSION['UsuarioEncontrado'])) {
        $resultado = $_SESSION['UsuarioEncontrado']; 
    } else {
        $resultado = null;
        echo "Usuario no encontrado en la sesión.";
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios existentes</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="../Vistas/css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container p-5 my-5 bg-secundary text-black border" class="row">
        <div class="col-md-6">
            <h4 class='text-center'>Datos Personales</h4>
            <ul class="list-group">

            <?php if (isset($resultado['nombre']) && isset($resultado['email']) && isset($resultado['fechaNacimiento'])) { ?>
                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Nombre:</strong> <?php echo $resultado['nombre']; ?></li>
                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Mail:</strong> <?php echo $resultado['email']; ?></li>
                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Fecha de nacimiento:</strong> <?php echo $resultado['fechaNacimiento']; ?></li>
            <?php } else { ?>
                <li class="list-group-item list-group-item-action list-group-item-secondary">Datos de usuario no disponibles.</li><br>
            <?php } ?>
            <a href="../Vistas/controlAdmin.php" button type="button" class="btn btn-outline-primary">Volver</button></a>
        </div>
    </div>
</body>
</html>