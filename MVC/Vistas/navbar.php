<?php
    require_once("../Modelo/Usuario.php");
    require_once("../Controlador/Permisos.php");
    require_once("../Modelo/perfil.php");
    require_once("../controlador/iniciarSesionUsuario.php");

    $usuario_id = null;

    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuario_id = $_SESSION['id']; // 
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>navbar</title>
    <script defer src="script.js"></script>
    <script defer src="../controlador/JavaScript/scriptForm.js"></script>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <div class="fixed-top" id="cabecera">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    <img src="../Vistas/imagenes/estetica/voleyballworld.png" alt="voley logo" style="width:40px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item" id="inicio">
                            <a class="nav-link" href="index.php">Inicio</a>
                        </li>
                        <li class="nav-item" id="Equipo">
                            <a class="nav-link" href="equipo.html">Equipo</a>
                        </li>
                        <li class="nav-item" id="Noticias">
                            <a class="nav-link" href="NoticiasGeneral.php">Noticias</a>
                        </li>
                        <li class="nav-item" id="Partidos">
                            <a class="nav-link" href="partido.html">Partidos</a>
                        </li>
                        <?php
                        if (Permisos::tienePermiso('PanelControl_adm', $usuario_id)) {
                            echo '<li class="nav-item" id="Admin">
                                    <a class="nav-link" href="../Vistas/controlAdmin.php">Panel de Control</a>
                            </li>';
                        }
                        ?>
                    </ul>
                    
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        // Usuario ha iniciado sesión, muestra el botón "Cerrar Sesión" y menú desplegable
                        echo '<div class="d-flex align-items-center">
                                <button type="button" class="btn btn-danger mx-2" id="logout" ><a class="linkBoton" href="../controlador/cerrarSesion.php">Cerrar Sesión</a></button>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="usermenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        Perfil
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="usermenu">
                                        <li><a class="dropdown-item" href="VerPerfil.php">Ver Perfil</a></li>
                                        <li><a class="dropdown-item" href="EditarPerfil.php">Editar Perfil</a></li>
                                    </ul>
                                </div>
                            </div>';
                    } else {
                        // Usuario no ha iniciado sesión, muestra los botones "Iniciar Sesión" y "Registrarse"
                        echo '<div class="d-flex align-items-center">
                                <button type="button" class="btn btn-secondary me-2" id="registerGrande" data-bs-toggle="modal" data-bs-target="#myRegister" >Registrarse</button>
                                <button type="button" class="btn btn-primary" id="login" data-bs-toggle="modal" data-bs-target="#myModal" >Iniciar Sesión</button>
                            </div>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </div>

    <!--MODALES PARA REGISTRO E INICIO DE SESION -->

    <div class="modal fade" id="myRegister" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                  <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Registrar Usuario</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                  <!-- Modal body -->
                <form action="../controlador/registrarUser.php" method="post" id="registrarUsuario">
                  <div class="modal-body">
                        <label for="name_registro">Ingresar Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="name_registro" name="name_registro" required placeholder="Ingresar nombre">
                        <div class="invalid-feedback">Nombre inválido. Utilice un formato válido (Sin espacios y solo letras).</div>
                    </div>
    
                    <div class="modal-body">
                        <label for="email_registro">Ingresar Correo:</label>
                        <input type="email" class="form-control" id="email_registro" name='email_registro' autocomplete="email_registro" required placeholder="Ingresar email">
                        <div class="invalid-feedback">Correo inválido. Utilice un formato válido.</div>
                    </div>
    
                    <div class="modal-body">
                        <label for="passwordRegistro">Contraseña:</label>
                        <input type="password" required class="form-control" id="passwordRegistro" name="passwordRegistro" required placeholder="Contraseña">
                    </div>
    
                    <div class="modal-body">
                        <label for="fecha_Registro">Fecha de Nacimiento:</label>
                        <input type="date" required class="form-control" id="fecha_Registro" name="fecha_Registro">
                        <div class="invalid-feedback">Fecha de nacimiento inválida.</div>
                    </div>
    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="registrarme" name="registrarme">Registrarme</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                  <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Iniciar Sesion</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                  <!-- Modal body -->
                <form action="../controlador/iniciarSesionUsuario.php" method="post">
                        <div class="modal-body">
                            <label for="userName">Ingrese su Nombre de Usuario:</label>
                            <input type="text" class="form-control" id="userName" name="userName" autocomplete="email_registro" required placeholder="Ingrese su username">
                        </div>
                        <div class="modal-body">
                            <label for="correo">Ingresar Correo:</label>
                            <input type="correo" class="form-control" id="correo" required placeholder="Ingresar email" autocomplete="correo"  name="correo">
                        </div>

                        <div class="modal-body">
                            <label for="contraseña">Contraseña:</label>
                            <input type="password" required class="form-control" id="contraseña" placeholder="contraseña" name="contraseña">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="botonenviar">Enviar</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>