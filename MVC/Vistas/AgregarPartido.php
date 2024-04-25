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
    <title>Agregar Partido</title>
        <!--Scripts-->
    <script defer src="../Vistas/CargarDatos.js"></script>
    <script defer src="script.js"></script>
    <script defer src="../Vistas/Modales.js"></script>
        <!--Estilos-->
    <link rel="stylesheet" href="../Vistas/styles.css">    
    <link rel="stylesheet" href="stylesEquipo.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="navbar-container"></div>
    <div class="container">
        <h1>Formulario agregar partido</h1>
        <form action="../controlador/agregarPartido.php" class="text-black" method="post" id="AgregarPartidoForm">
           
            <div class="form-group">
                <label for="fechaPartido">Ingrese la fecha del partido:</label>
                <input type="date" class="form-control" name="fecha" id="fechaPartido" required>
            </div>  

            <div class="form-group">
                <label for="ubicacionPartido">Ingrese la ubicación:</label>
                 <select class="form-control" name="ubicacion" id="ubicacionPartido" required>
                   
                 </select>
            </div>

            <div class="form-group">
                <label for="PartidoEquipo1">Seleccione el primer equipo:</label>
                <select class="form-control" name="equipo1" id="PartidoEquipo1" required>
           
                </select>
            </div>

            <div class="form-group">
                <label for="PartidoEquipo2">Seleccione el segundo equipo:</label>
                <select class="form-control" name="equipo2" id="PartidoEquipo2" required>
                  
                </select>
            </div>

            <div class="form-group">
                <label for="PuntosEquipo1">Ingrese puntos del primer equipo:</label>
                <input type="number" class="form-control" name="puntosGanador" id="PuntosEquipo1" required>
            </div>
          
            <div class="form-group">
                <label for="PuntosEquipo2">Ingrese puntos del segundo equipo:</label>
                <input type="number" class="form-control" name="puntosPerdedor" id="PuntosEquipo2" required>
            </div><br>
            
            <div class="form-group">
                <label for="PartidoEquipoGanador">Ingrese el EQUIPO GANADOR:</label>
                <input type="number" class="form-control" name="equipoGanador" id="PartidoEquipoGanador" required>
            </div>


            <div class="form-group">
                <label for="PartidoEquipoPerdedor">Ingrese el EQUIPO PERDEDOR:</label>
                <input type="number" class="form-control" name="equipoPerdedor" id="PartidoEquipoPerdedor" required>
            </div>
        
            <div class="form-group">
                <label for="pathFoto">Seleccionar Foto:</label>
                <input type="file" class="form-control-file" name="pathFoto" id="pathFoto" accept="image/*" required>
            </div><br>
            <button type="submit" class="btn btn-primary">Agregar Partido</button>
        </form>
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Error al intentar Registrar un nuevo partido..</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <p>Accion Denegada. Verificar la correcta carga de los datos.
                        Recuerde que no se debe poner 2 equipos iguales en un partido.
                    </p>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cerrarModal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>