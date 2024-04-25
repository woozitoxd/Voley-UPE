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
    <title>Buscar Usuario</title>
     <!--sCRIPTS-->
    <script defer src="script.js"></script>
    <script defer src="../controlador/JavaScript/BuscarUsuario.js"></script>
    <script defer src="../Vistas/Modales.js"></script>
        <!--Estilos-->
    <link rel="stylesheet" href="stylesEquipo.css">
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="navbar-container" style="padding-bottom: 10%;"></div>
    <div class="container">
        <div class="container p-5 my-5 border">
            <h1>BUSCAR USUARIO</h1>
            <p class="text-center">Ingresa el correo del usuario que deseas buscar.</p>
            <form action="../controlador/buscarUsuario.php" method="POST" id="BuscarUsuarioForm">
                <div class="mb-3">
                    <label for="email" class="form-label">Correo del Usuario</label>
                    <input type="email" class="form-control" id="email" name="email" id="email" placeholder="example@gmail.com" required>
                    <div class="invalid-feedback">Correo inválido. Error de formato</div>
                </div>
                <button type="submit" class="btn btn-outline-warning">Buscar</button>
            </form>
        </div> 
    </div>
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error al intentar buscar usuario.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p>Al parecer esta buscando un usuario que no esta registrado. 
                        Por favor asegurese de ingresar correctamente los datos.</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
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