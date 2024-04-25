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
    <title>Club Voley UPE</title>
        <!--Scripts-->
    <script defer src="script.js"></script>
    <script src="../controlador/JavaScript/EliminarLiga.js"></script>
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
        <h1>ELIMINAR LIGA</h1>
        <div class="container p-5 my-5 border">
            <form action="../controlador/eliminarLiga.php" method="post" id="EliminarLigaForm">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                    <div class="invalid-feedback">Nombre Invalido.Debe contener al menos un espacio y mas de 3 caracteres la palabra</div>
                </div><br>
                <button type="submit" class="btn btn-danger">Eliminar Liga</button>
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
