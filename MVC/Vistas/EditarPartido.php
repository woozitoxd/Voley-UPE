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
    <title>Editar Partido</title>
        <!--scripts-->
    <script defer src="script.js"></script>
    <script defer src=../Vistas/CargarDatos.js></script>
    <script defer src="../Vistas/Modales.js"></script>
        <!--Estilos-->
    <link rel="stylesheet" href="styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="navbar-container"></div><br><br>
    <div class="container-fluid p-5 bg-secondary text-white text-center">
        <h1 class="text-center">EDITAR PARTIDO</h1>
        <p>Ingrese los datos del partido que deseea editar</p> 
    </div><br>
    <div class="container">
            <form action="../controlador/editarPartido.php" method="post" id="EditarPartidoForm">
                <div class="form-group">
                    <label for="fechaEditar">Ingreese la fecha del partido:</label>
                    <input type="date" class="form-control" name="fechaEditar" id="fechaEditar" required>
                </div> 

                <div class="form-group">
                    <label for="equipo1Editar" >Seleccione el primer equipo:</label>
                    <select class="form-control" name="equipo1Editar" id="equipo1" id="equipo1Editar" required>
                       
                    </select>
                </div>

                <div class="form-group">
                    <label for="equipo2Editar">Seleccione el segundo equipo:</label>
                    <select class="form-control" name="equipo2Editar" id="equipo2Editar" required>
                          
                    </select>
                </div><br>
                <h4 class="text-center">Ingrese los NUEVOS datos del partido:</h4>
                <div class="form-group">
                    <label for="fechaNueva">Ingrese la fecha del partido:</label>
                    <input type="date" class="form-control" name="fecha" id="fechaNueva" required>
                </div>  

                <div class="form-group">
                    <label for="ubicacionNueva">Ingreese la ubicación:</label>
                    <select class="form-control" name="ubicacion" id="ubicacionNueva" required>
                   
                    </select>
                </div>

                <div class="form-group">
                    <label for="equipo1Nuevo">Seleccione el primer equipo:</label>
                    <select class="form-control" name="equipo1" id="equipo1Nuevo" required>
                      
                    </select>
                </div>

                <div class="form-group">
                    <label for="equipo2Nuevo">Seleccione el segundo equipo:</label>
                    <select class="form-control" name="equipo2" id="equipo2Nuevo" required>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label for="apellido">Ingrese puntos del primer equipo:</label>
                    <input type="number" class="form-control" name="puntosGanador" required>
                </div>
            
                <div class="form-group">
                    <label for="number">Ingrese puntos del segundo equipo:</label>
                    <input type="number" class="form-control" name="puntosPerdedor" required>
                </div><br>
                
                <div class="form-group">
                    <label>Seleccione el EQUIPO GANADOR:</label>
                    <input type="number" class="form-control" name="equipoGanador" required>
                </div>

                <div class="form-group">
                    <label>Seleccione el EQUIPO PERDEDOR:</label>
                    <input type="number" class="form-control" name="equipoPerdedor" required>
                </div><BR>
                <div class="form-group">
                    <label for="pathFoto">Seleccionar Foto:</label>
                    <input type="file" class="form-control-file" name="pathFoto" accept="image/*" required>
                </div><br>
                <button type="submit" class="btn btn-outline-warning">Editar Partido</button><br>
                <br><a href="../Vistas/controlAdmin.php" button type="button" class="btn btn-outline-primary">Volver</button></a>
         </form> 
         <div class="modal fade" id="ErrorPartido" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="errorModalLabel">Error al ingresar la informacion</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Accion Denegada. Verificar el correcto cargado de datos.
                                No puede ingresar dos veces el mismo equipo.
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