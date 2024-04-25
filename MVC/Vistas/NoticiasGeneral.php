<?php

require_once("../Modelo/Usuario.php");
require_once("../Modelo/perfil.php");
require_once('../controlador/IniciarSesionUsuario.php');
require_once('../controlador/Permisos.php');
require_once('../controlador/conexion_db.php');

$idUSERxd = null;
$mensaje = null;
$error = null;

if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $idUSERxd = $_SESSION['id']; //
}
if (isset($_SESSION['mensaje']) && $_SESSION['mensaje']){
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}
if (isset($_SESSION['errorcomentar']) && $_SESSION['errorcomentar']){
    $error = $_SESSION['errorcomentar'];
    unset($_SESSION['errorcomentar']);
}

try {
    // Consulta para seleccionar datos de la tabla NoticiasPrincipales
    $sql = "SELECT id, titulo, descripcion, pathFoto FROM NoticiasPrincipales";
    $stmt = $conn->query($sql);

    if ($stmt) {
        // primero inicializo
        $noticiaPrincipal = null;
        $noticiasRestantes = [];

        // recorro los datos de cada fila
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // obtengo datos de cada fila
            $idNoticia = $row['id'];
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'];
            $pathFoto = $row['pathFoto'];

            // verifico si es la primer noticia (NoticiaPrincipal)
            if ($noticiaPrincipal === null) {
                $noticiaPrincipal = [
                    'id' => $idNoticia,
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'pathFoto' => $pathFoto
                ];
            } else {
                // Si no es la primera, se agrega a la lista de NoticiasRestantes
                $noticiasRestantes[] = [
                    'id' => $idNoticia,
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'pathFoto' => $pathFoto
                ];
            }
        }
    }
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
} finally {
    if ($stmt) {
        $stmt->closeCursor();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias - Club Voley UPE</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="stylesNoticia.css">
    <script defer src="scriptComentariosAJAX.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div id="fondo"></div>

<div class="container" id="navbar-container">
    <!-- Incluye la barra de navegación utilizando JavaScript -->
</div>

<div id="divGeneral">
<h1 class="text-white text-center"><?php echo $mensaje ?></h1>

<!-- Noticia Principal -->
<div class="noticia-principal">
    <p class="text-center"><?php echo $error ?></p>
    <a title="noticiaPrincipal" href="NoticiaEspecifica.php?id=<?php echo $noticiaPrincipal['id']; ?>">
        <img class="img-fluid" src="../Vistas/imagenes/noticias/<?php echo $noticiaPrincipal['pathFoto']; ?>" alt="NoticiaPrincipal">
    </a>
    <div class="texto-superpuesto">
        <h3><?php echo $noticiaPrincipal['titulo']; ?></h3>
        <p><?php echo $noticiaPrincipal['descripcion']; ?></p>
    </div>
</div>

<!-- Resto de las noticias -->
<div class="container mt-5 noticias-restantes">
    <div class="row">
        <?php
        foreach ($noticiasRestantes as $noticia) {
        ?>
            <div class="col-md-6">
                <div class="card mb-4">
                    <a title="noticia<?php echo $noticia['titulo']; ?>"
                        href="NoticiaEspecifica.php?id=<?php echo $noticia['id']; ?>">
                        <img class="imagen" src="../Vistas/imagenes/noticias/<?php echo $noticia['pathFoto']; ?>"
                            alt="VistaPrevia">
                    </a>
                    <div class="texto-superpuesto">
                        <h3><?php echo $noticia['titulo']; ?></h3>
                        <p><?php echo $noticia['descripcion']; ?></p>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

    <div class="container text-left">
        <?php
        if (Permisos::tienePermiso('Agregar Noticia', $idUSERxd)) {
            echo '<button class="btn btn-primary"><a class="nav-link text-white" href="../Vistas/VIEW_VistaPreviaAgregar.php">Agregar Noticias</a></button>';
        }
        if (Permisos::tienePermiso('Eliminar Noticia', $idUSERxd)) {
            echo '<button class="btn btn-primary"><a class="nav-link text-white" href="../Vistas/VIEW_EliminarNoticia.php">Eliminar Noticia</a></button>';
        }
        ?>
    </div>

    <!-- Sección de Comentarios -->
    <div id="comentarios" class="container mt-4 text-white">
        <h2 class="text-white text-center">Comentarios</h2>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Formulario para agregar comentarios -->
                <h3 class="text-center">Agregar Comentario</h3>
                <form action="../controlador/CON_Comentarios.php" method="post" id="comentarios-form">
                    <div class="form-group">
                        <label for="comentario">Comentario:</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4" placeholder="Escribe tu comentario" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Publicar Comentario</button>
                </form>

                <p class="text-center"><?php echo $error ?></p>
            </div>
        </div>

        <!-- Lista de Comentarios -->
        <div id="seccion-comentarios" class="row mt-4">
            <div class="col-md-8 mx-auto card">
                <h3 class="text-center">Comentarios Recientes</h3>
                <ul id="lista-comentarios" class="list-unstyled">
                    <!-- Los comentarios se ponen acá de forma dinámica con JavaScript usando AJAX -->
                </ul>
            </div>
            <div class="text-right">
            <?php
            if (Permisos::tienePermiso('Eliminar Comentario', $idUSERxd)) {
                echo '<button class="btn btn-danger"><a class="nav-link text-white" href="../Vistas/VIEW_VerDenuncias.php">Ver Denuncias</a></button>';
            }
            ?>
            </div>

        </div>
    </div>


    <!-- Modal de Denuncia -->
    <div class="modal fade" id="modalDenuncia" tabindex="-1" role="dialog" aria-labelledby="modalDenunciaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDenunciaLabel">Denunciar Comentario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="../controlador/CON_DenunciarCom.php" method="post">
                    <div class="modal-body">
                        <label for="listaRazones">Seleccione la razón de la denuncia:</label>
                        <select id="listaRazones" name="listaRazones" class="form-control">
                            <!-- Las opciones de razones se agregan con JavaScript -->
                        </select>
                        <input type="hidden" id="comentarioId" name="comentarioId"/>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">Enviar Denuncia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



    <footer class="text-center">
        <!-- Incluyo el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>

</body>
</html>