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
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
    <script defer src="../Vistas/Modales.js"></script>
    <script defer src="../controlador/JavaScript/EditarUsuario.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Acciones de Usuario</title>
</head>
<body> 
    <div id="navbar-container"></div>
    <div class="container-fluid p-5 bg-secondary text-white text-center">
        <h1 class="text-center">EDITAR USUARIO</h1>
        <p>Ingrese los datos del Usuario que desea editar</p> 
    </div><br>
    <div class="container">
        <form action="../controlador/editarUsuario.php" class="text-black" method="POST" id="EditarUsuarioForm">
                <div class="form-group">
                    <label for="emailViejo">Correo Electrónico del usuario a Editar:</label>
                    <input type="email" class="form-control" name="emailViejo" id="emailViejo"required>
                    <div class="invalid-feedback">Email Invalido. Error al ingresar los datos</div>
                </div>
                <div class="container">
                    <h1>Nuevos Datos del Usuario</h1>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" required>
                            <div class="invalid-feedback">Nombre Invalido. Error al ingresar los datos</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo Electrónico:</label>
                            <input type="email" class="form-control" name="email" id="email" autocomplete="email" required>
                            <div class="invalid-feedback">Email Invalido. Asegurese de tener el formato requerido</div>
                        </div>
                        <div class="form-group">
                            <label for="contraseña">Contraseña:</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="fecha_edad">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" name="fecha_edad" id='fecha_edad' required>
                            <div class="invalid-feedback">Fecha invalida. Debe ser mayor de 16 años.</div>
                        </div><br>
                        <button type="submit" class="btn btn-primary">Gardar los nuevos datos</button>        
                </div>
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
        <footer >
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>