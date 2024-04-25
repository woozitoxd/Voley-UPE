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
    if(isset($_SESSION['LigaEncontrada'])) {
        // Obtener el objeto de la persona encontrada desde la sesión
        $buscarLiga = $_SESSION['LigaEncontrada']; 
    };
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Liga</title>
        <!--Scripts-->
    <script defer src="script.js"></script>
    <script defer src="../controlador/JavaScript/EditarLiga.js"></script>
    <script defer src="../Vistas/Modales.js"></script>
        <!--Estilos-->
    <link rel="stylesheet" href="stylesEquipo.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="navbar-container" style="padding-bottom: 10%;"></div>
        <div class="container">
            <div class="container p-5 my-5 border">
                <h1>Cambiar Nombre de la liga </h1>
                <form action="../controlador/editarLiga.php" method="POST">
                    <div class="mb-3">
                        <label for="nombreViejo" class="form-label">Actual nombre</label>
                        <input type="nombre" class="form-control" id="nombreViejo" name="NombreLiga2" placeholder= <?php echo $buscarLiga['nombre'];?> required>
                        <div class="invalid-feedback">Nombre de liga inválido. Debe contener al menos dos palabras</div>
                    </div>
                    <div class="mb-3">
                        <label for="nombreNuevo" id="EditarLigaForm" class="form-label">Ingresa el nuevo nombre: </label>
                        <input type="nombre" class="form-control" id="nombreNuevo" name="NombreLiga" placeholder= <?php echo $buscarLiga['nombre'];?> required>
                        <div class="invalid-feedback">Nombre de liga inválido. Debe contener al menos dos palabras</div>
                    </div>
                    <button type="submit" class="btn btn-outline-warning">Cambiar Nombre</button>
                </form>
            </div>
            <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Ha ocurrido un error.</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Accion Denegada. Verificar la correcta carga de los datos.
                            </p>
                        </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="solicitudExitosa" tabindex="-1" aria-labelledby="solicitudExitosaLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="solicitudExitosaLabel">Proceso realizado con exito!</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>¡Accion exitosa!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="cerrarSolicitudExitosa">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> 

        <footer >
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>