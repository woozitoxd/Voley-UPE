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
             <!--Scripts-->
    <script defer src="script.js"></script>
    <script defer src="../Vistas/CargarDatos.js"></script>
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
    <div id="navbar-container"></div>

    <div class="container">
        <h1>Formulario de Registro de Jugador</h1>
        <form action="../controlador/agregarJugador.php" method="post" id='AgregarJugadorForm'>
            <div class="form-group">
                <label for="nombreJugador">Nombre:</label>
                <input type="text" class="form-control" name="nombre" id="nombreJugador" required>
                <div class="invalid-feedback">Nombre inválido. Debe ser una palabra con minimo 3 caracteres</div>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido:</label>
                <input type="text" class="form-control" name="apellido" id="apellido" required>
                <div class="invalid-feedback">Apellido inválido. Debe contener una palabra con minimo 4 caracteres</div>
            </div>
            <div class="form-group">
                <label for="edad">Edad:</label>
                <input type="number" class="form-control" name="edad" id="edad" required>
                <div class="invalid-feedback">Edad inválida. Debe tener al menos 17 años</div>
            </div>
            <div class="form-group">
                <label for="altura">Altura:</label>
                <input type="number" class="form-control" name="altura" step="0.01" id="altura" required>
                <div class="invalid-feedback">Altura inválida. Ingrese su altura verdadera</div>
            </div>
            <div class="form-group">
                <label for="id_posicion">Posición:</label>
                <select class="form-control" name="id_posicion" id="id_posicion" required>
                    <option value="1">Punta</option>
                    <option value="2">Libero</option>
                    <option value="3">Central</option>
                    <option value="4">Armador</option>
                    <option value="5">Opuesto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Equipo1AgregarJugador">Equipo:</label>
                <select class="form-control" name="id_equipo" id="Equipo1AgregarJugado" required>
                  
                </select>
            </div>
            <div class="form-group">
                <br><label for="pathFoto">Seleccionar Foto:</label>
                <input type="file" class="form-control-file" name="pathFoto" accept="image/*" required>
            </div><br>
            <button type="submit" class="btn btn-primary">Registrar Jugador</button>
        </form>

        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error al intentar agregar jugador.</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p>Accion Denegada. Verificar el correcto cargado de datos.</p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
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
