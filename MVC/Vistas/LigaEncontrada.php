<?php
    require_once("../Modelo/Usuario.php");
    include("../Modelo/liga.php");
    include("../Controlador/Permisos.php");
    session_start();

    $usuario = new Usuario("", "", "", "","");
    
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
    if(isset($_SESSION['LigaEncontrada'])) {
        $buscarLiga = $_SESSION['LigaEncontrada'];
        
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liga Encontrada!</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="alert alert-success">
    <strong>Encontrada!</strong>Liga existente</a>.
    </div>
    <div class="container p-5 my-5 bg-secundary text-black border" class="row">
        <div class="col-md-6">
            <h4 class='text-center'>Datos de la Liga</h4>
            <ul class="list-group">
                <li class="list-group-item list-group-item-action list-group-item-secondary"><strong>Nombre:</strong> <?php echo $buscarLiga['nombre']; ?></li>  
            </ul><br>
            <a href="../Vistas/controlAdmin.php" button type="button" class="btn btn-outline-primary">Volver</button></a>
            <a href="../Vistas/EditarLiga.php" button type="button" class="btn btn-outline-primary">Editar Liga</button></a>
            <a href="../Vistas/eliminarLiga.php" button type="button" class="btn btn-outline-primary">Eliminar Liga</button></a>
        </div>
    </div>  
    <footer >
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>

