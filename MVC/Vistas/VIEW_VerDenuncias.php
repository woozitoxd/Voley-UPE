<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once('../controlador/conexion_db.php');
require_once('../Modelo/OpcionesSelect.php');
session_start();
$usuarioID = null; 
if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
    $usuarioID = $_SESSION['id']; //
}

$mensaje = null;
if(isset($_SESSION['comentarioEliminado']) && $_SESSION['comentarioEliminado']){
    $mensaje = $_SESSION['comentarioEliminado'];
    unset($_SESSION['comentarioEliminado']);

}
if (!Permisos::esRol('administradorContenido', $usuarioID)) {
    // 
    echo "Debes ser administrador de contenido visualizar las denuncias " . '<a href="../vistas/index.php">Volver</a>';
    exit();
}

if (!Permisos::tienePermiso('Eliminar Comentario', $usuarioID)) {
    echo "Debes tener permiso para eliminar el comentario.". '<a href="../vistas/index.php">Volver</a>';
    exit();
}

$obtenerDenuncias = new OpcionesMostrar($conn);
$denuncias = $obtenerDenuncias->obtenerDenuncias();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="../Vistas/script.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script defer src="../Vistas/scriptEliminarComentario.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"></head>
    <body>

<div id="fondo"></div>
<!-- Incluyo la barra de navegación utilizando JavaScript -->
<div id="navbar-container" style="padding-bottom: 5%;"></div>

<div class="container-fluid p-3 bg-primary text-white text-center">
    <h1 class="mb-4">DENUNCIAS EXISTENTES</h1>
</div>

<div class="container">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Denuncia Nro.</th>
                    <th scope="col">Razón</th>
                    <th scope="col">Comentario</th>
                    <th scope="col">Usuario Denunciante</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Suponiendo que $denuncias es el resultado de la función obtenerDenunciasComentarios
                if (isset($denuncias) && is_array($denuncias)) {
                    foreach ($denuncias as $denuncia) {
                        ?>
                        <tr>
                            <th scope="row"><?= $denuncia['idReporte'] ?></th>
                            <td><?= $denuncia['razones'] ?></td>
                            <td><?= $denuncia['Comentarios'] ?></td>
                            <td><?= $denuncia['usuario'] ?></td>
                            <td>
                                <button type="button" class="btn btn-danger eliminar-comentario" data-bs-toggle="modal" data-bs-target="#modalEliminar" data-comentario-id="<?= $denuncia['idComentario'] ?>">Eliminar Comentario</button>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // Puedes mostrar un mensaje indicando que no hay denuncias disponibles
                    ?>
                    <tr>
                        <td colspan="5">No hay denuncias disponibles.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<p><?php echo $mensaje?></p>

<!-- Modal de Confirmación para Eliminar Comentario -->
<form action="../Controlador/CON_EliminarComentario.php" method="post" id="formEliminarComentario">
    <input type="hidden" id="comentarioIdEliminar" name="comentarioIdEliminar" />

    <!-- Modal de Confirmación para Eliminar Comentario -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEliminarLabel">Eliminar Comentario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Está seguro de que desea eliminar este comentario?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="eliminarBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<footer style="padding-top: 10%">
    <div id="footer-container"></div>
</footer>
</body>

</html>