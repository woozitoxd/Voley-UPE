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
    <link rel="stylesheet" href="../Vistas/styles.css">
        <!--Scripts-->
    <script defer src="../Vistas/script.js"></script>
    <script defer src="../controlador/JavaScript/"></script>
    <script defer src="../Vistas/Modales.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Acciones de Usuario</title>
</head>
<body>
    <div id="navbar-container"></div>

    <div class="container mt-5">
        <h1 class='text-center'>ELIMINAR USUARIO</h1>
        <p class='text-center'>Ingresa el correo del usuario que deseas eliminar.</p>
        <div class="container p-5 my-5 border">
            <form action="../controlador/eliminarUsuario.php" method="post" id='EliminarUsuarioForm'>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo del Usuario</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="email" required>
                    <div class="invalid-feedback">Correo Usuario inválido. Asegurese de ingresar correctamente el correo.</div>
                </div>
                <button type="submit" class="btn btn-danger">Eliminar Usuario</button>
            </form>
        </div>
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
</body>
</html>
