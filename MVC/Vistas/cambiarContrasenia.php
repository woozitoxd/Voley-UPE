<?php
    require_once("../Modelo/Usuario.php");
    require_once("../Modelo/perfil.php");
    require_once('../controlador/IniciarSesionUsuario.php');
    require_once('../controlador/Permisos.php');

    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }
    $mensaje = null;
    if (isset($_SESSION['actualizacionPerfil']) && $_SESSION['actualizacionPerfil']){
        $mensaje = $_SESSION['actualizacionPerfil'];
        unset($_SESSION['actualizacionPerfil']);
    }
    if (!Permisos::tienePermiso('Editar Perfil', $usuarioID)) {
        echo "Debes tener permiso para editar el perfil " . '<a href="../Vistas/index.php">Volver</a>';
        //header('Location: ../Vistas/index.php'); //No dejo que el usuario entre a la seccion de edicion de perfil
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edicion Perfil Usuario</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script defer src=".js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="fondo"></div>
    <!-- Incluyo la barra de navegación utilizando JavaScript -->
    <div id="navbar-container"></div>
    <div class="container mt-3 card">
            <form action="../controlador/CON_CambiarContrasenia.php" class="text-black" id="edicionPerfil" method="post">

                <div class="mb-3 mt-3">
                    <label for="viejaPassword">Contraseña Actual:</label>
                    <input type="password" class="form-control" id="viejaPassword" name="viejaPassword">
                </div>
                <div class="mb-3 mt-3">
                    <label for="newPassword">Contraseña nueva:</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>                <div class="mb-3 mt-3">
                    <label for="passwordconfirmada">Confirmar contraseña:</label>
                    <input type="password" class="form-control" id="passwordconfirmada" name="passwordconfirmada">
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><a class="linkBoton" href="../Vistas/VerPerfil.php">Cancelar</a></button>
                <button type="submit" class="btn btn-primary" id="Guardar" name="Guardar">Guardar Cambios</button>
            </form>
    </div> 

    <div class="container mt-3">
        <p class="lead"><?php echo $mensaje; ?></p>
    </div>

    <footer >
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>