<?php
    require_once("../Modelo/Usuario.php");
    require_once("../Controlador/Permisos.php");
    session_start();
    $usuario = new Usuario("","", "", "", "");
    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }   
    if (!Permisos::esRol('administrador', $usuarioID) || !Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes ser administrador para ver el panel de control. " . '<a href="../Vistas/index.php">Volver</a>';
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
    <script defer src="../controlador/JavaScript/EliminarPartido.js"></script>
    <script src="../controlador/JavaScript/BuscarJugador.js"></script>
    <script defer src="../Vistas/Modales.js"></script>
        <!--Estilos-->
    <link rel="stylesheet" href="styles.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">ADMINISTRADOR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Usuarios
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="VIEW_RegistrarADM.php">Asignar Rol</a></li>
                        <li><a class="dropdown-item" href="buscarUsuario.php">Buscar Usuario</a></li>
                        <li><a class="dropdown-item" href="editarUsuario.php">Editar Usuario</a></li>
                        <li><a class="dropdown-item" href="eliminarUsuario.php">Eliminar Usuario</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Jugadores
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="../Vistas/agregarJugador.php">Agregar Jugador</a></li>
                        <li><a class="dropdown-item" href="eliminarJugador.php">Eliminar Jugador</a></li>
                        <li><a class="dropdown-item" href="EditarJugador.php">Editar Jugador</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        Partido
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="agregarPartido.php">Agregar Partido</a></li>
                        <li><a class="dropdown-item" href="EditarPartido.php">Editar Partido</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="agregarEquipo.php">Agregar Equipo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="crearLiga.html">Crear Liga</a>
                </li>
                <?php if (Permisos::tienePermiso('PanelControl_adm', $usuarioID)): ?>
                    <li class="nav-item" id="Admin">
                        <a class="nav-link" href="../Vistas/controlAdmin.php">Panel de Control</a>
                    </li>
                <?php endif; ?>
                <?php if (Permisos::tienePermiso('Editar Noticia', $usuarioID)): ?>
                    <li class="nav-item" id="Adminxd">
                        <a class="nav-link" href="../Vistas/editarNoticia.php">Editar Noticia</a>
                    </li>
                <?php endif; ?>
                <?php if (Permisos::tienePermiso('Editar Noticia', $usuarioID)): ?>
                    <li class="nav-item" id="Adminxd">
                        <a class="nav-link" href="../Vistas/editarVistaPrevia.php">Editar Vista Previa de Noticias</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Salir</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
     <div class="container mt-5">
        <div class="row">
            <div class="col-sm-4 border">
                <h4 class="text-center">Buscar jugador</h4>
                <form action="../controlador/buscarJugador.php" method="post" id="BuscarJugadorForm">
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" required>
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
                        <label for="id_equipoBuscar">Equipo:</label>
                        <select class="form-control" name="id_equipo" id="id_equipoBuscar" required>
                           
                        </select>
                    </div><br>
                    <button type="submit" class="btn btn-outline-warning">Buscar Jugador</button><br>
                </form> <br>  
            </div>

            <br><div class="col-sm-4"></div><br>

            <br><div class="col-sm-4 border">
                    <h4 class="text-center">Eliminar Partido</h4>
                    <form action="../controlador/EliminarPartido.php" method="post" id="EliminarPartidoForm">
                        
                        <div class="form-group">
                            <label for="fecha">Ingrese la fecha del partido:</label>
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div> 

                        <div class="form-group">
                            <label for="EliminarEquipo1">Seleccione el primer equipo:</label>
                            <select class="form-control" name="equipo1" id="EliminarEquipo1" required>
                               
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="EliminarEquipo2">Seleccione el segundo equipo:</label>
                            <select class="form-control" name="equipo2" id="EliminarEquipo2" required>
                               
                            </select>
                        </div><br>
                        <button type="submit" class="btn btn-outline-warning">Eliminar Partido</button><br>
                    </form> 
               </div>
         </div>
     </div>
        
        <div class="container mt-5">
            <div class="row">                   
                    <div class="col-sm-4 border">
                        <h1>Buscar Liga</h1>
                        <form action="../controlador/buscarLiga.php" method="POST" id="BuscarLigaForm">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Ingresa el nombre de la liga que deseas buscar</label>
                                <input type="text" class="form-control" id="nombre" name="NombreLiga" placeholder="sur 2025" id='nombre' required>
                                <div class="invalid-feedback">Nombre Invalido. Error al ingresar los datos</div>
                            </div>
                            <button type="submit" id="btnBucsar" class="btn btn-outline-warning">Buscar Liga</button>
                        </form><br>
                    </div>
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







