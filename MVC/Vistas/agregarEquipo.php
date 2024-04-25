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
        echo "Debes ser administrador para administrar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }
    if (!Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes tener permiso para editar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
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
    <script defer src="../controlador/JavaScript/ValidarEquipo.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="navbar-container"></div>
    
    <div class="mt-3">
        <div class="col">
            <h1 class="text-center">REGISTRAR EQUIPO</h1>
            <div class="container p-5 my-5 border">
                <h3>Nombre equipo:</h3>
                <form action="../controlador/agregarEquipo.php" method="post" id="crearEquipo">
                    <div class="form-group">
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
                        <div class="invalid-feedback">Nombre del equipo invalido. Utilice un formato válido (Minimo 4 caracteres).</div>
                    </div><br>
                    <button type="submit" class="btn btn-primary">Registrar Equipo</button>
                </form>
            </div>
        </div>
    </div>
    <footer >
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>
