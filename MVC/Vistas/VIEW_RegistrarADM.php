<?php
    require_once("../Modelo/Usuario.php");
    include("../Controlador/Permisos.php");
    require_once("../Modelo/OpcionesSelect.php");
    require_once('../controlador/conexion_db.php');
    session_start();

    $usuario = new Usuario("", "", "", "", "");
    $usuarioID = null;
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']) {
        $usuarioID = $_SESSION['id'];
    }
    if (!Permisos::esRol('administrador', $usuarioID) || !Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes ser administrador para administrar contenido. " . '<a href="../Vistas/index.php">Volver</a>';
        exit();
    }

    $opciones = new OpcionesMostrar($conn);
    $usuarios = $opciones->obtenerOpciones("Usuario");
    $roles = $opciones->obtenerOpciones("roles");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script defer src="../controlador/JavaScript/scriptAsignarRol.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="fondo"></div>

    <div id="navbar-container" ></div>
    <h1 class="mb-4 card"> ASIGNAR ROL</h1>

    <div class="container card" >

        <form action="../controlador/CON_asignarADM.php" id="asignarRolForm" method="POST">
            <div class="mb-3">
                <label for="idUsuario" class="form-label">Seleccione el usuario</label>
                <select id="idUsuario" name="idUsuario" class="form-select" required>
                    <option value=""></option>
                    <?php
                    foreach ($usuarios as $usuario) {
                        echo "<option value='{$usuario['id']}'>{$usuario['nombre']}</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Campo vacio. Seleccione un usuario por favor.</div>

            </div>

            <div class="mb-3">
                <label for="idRol" class="form-label">Seleccione el rol que desea asignar</label>
                <select id="idRol" name="idRol" class="form-select" required>
                    <option value=""></option>
                    <?php
                    foreach ($roles as $rol) {
                        echo "<option value='{$rol['id']}'>{$rol['nombre']}</option>";
                    }
                    ?>
                </select>
                <div class="invalid-feedback">Campo vacio. Seleccione un rol por favor.</div>

            </div>

            <button type="submit" class="btn btn-primary">Asignar Rol</button>
        </form>
    </div>
    
    <footer >
      <div id="footer-container"></div>
    </footer>
</body>
</html>
