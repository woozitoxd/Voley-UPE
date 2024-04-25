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
    if (isset($_SESSION['errorsesion']) && $_SESSION['errorsesion']){
        $error = $_SESSION['errorsesion'];
        unset($_SESSION['errorsesion']);
    }

    // Consulta para obtener las noticias principales (incluyendo las imágenes del carrusel)
    $sql = "SELECT id, titulo, pathFoto FROM NoticiasPrincipales";
    $stmt = $conn->query($sql);

    if ($stmt) {
        $noticiasPrincipales = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
    }

    // Consulta para obtener las noticias debajo del carrusel
    $sql = "SELECT id, titulo, descripcion, pathFoto FROM NoticiasPrincipales";
    $stmt = $conn->query($sql);

    $noticiaPrincipal = null;
    $noticiasRestantes = [];

    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $idNoticia = $row['id'];
            $titulo = $row['titulo'];
            $descripcion = $row['descripcion'] ?? ''; // Asegúrate de que 'descripcion' exista en la tabla
            $pathFoto = $row['pathFoto'];

            if ($noticiaPrincipal === null) {
                $noticiaPrincipal = [
                    'id' => $idNoticia,
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'pathFoto' => $pathFoto
                ];
            } else {
                $noticiasRestantes[] = [
                    'id' => $idNoticia,
                    'titulo' => $titulo,
                    'descripcion' => $descripcion,
                    'pathFoto' => $pathFoto
                ];
            }
        }
        $stmt->closeCursor();
    }
    $conexionPDO = null; // Cierra la conexión PDO
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Voley UPE</title>
    <script defer src="script.js"></script>
    <script defer src="../controlador/JavaScript/scriptForm.js"></script>
    <link rel="stylesheet" href="../Vistas/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="fondo"></div>
        <!-- Incluyo la barra de navegación utilizando JavaScript -->
    <div id="navbar-container"></div>

    <!-- Carrusel de Fotos -->

    <div id="CarruselFotos">
    <div id="demo" class="carousel slide carrusel" data-bs-ride="carousel">
        <div class="carousel-indicators text-center">
            <?php
            // Genera indicadores dinámicamente
            foreach ($noticiasPrincipales as $index => $noticia) {
                echo '<button type="button" data-bs-target="#demo" data-bs-slide-to="' . $index . '" class="' . ($index === 0 ? 'active' : '') . '"></button>';
            }
            ?>
        </div>

        <div class="carousel-inner text-center text-white">
            <?php
            // Genera elementos del carrusel dinámicamente
            foreach ($noticiasPrincipales as $index => $noticia) {
                echo '<div class="carousel-item' . ($index === 0 ? ' active' : '') . ' text-center">';
                echo '<img src="../Vistas/imagenes/noticias/' . $noticia['pathFoto'] . '" alt="" class="d-block w-100 mx-auto">';
                echo '<div class="carousel-caption">';
                echo '<h3>' . $noticia['titulo'] . '</h3>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>

        <button class="carousel-control-prev btn btn-secondary" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next btn btn-primary" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
    
    </div>

        <!-- Apartado de Noticias -->
        <div class="container mt-5">
        <h3 class="font-weight-bold text-white">Noticias Recientes</h3>

        <div class="row">
                <?php
                    foreach ($noticiasRestantes as $noticia) {
                ?>
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <a title="noticia<?php echo $noticia['titulo']; ?>" href="NoticiaEspecifica.php?id=<?php echo $noticia['id']; ?>"> <!--De los datos que obtuve, los muestro en pantalla -->
                                            <img class="imagen" src="../Vistas/imagenes/noticias/<?php echo $noticia['pathFoto']; ?>" alt="imagen_noticia">
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
    
            <!-- Botón "Ver más" -->
            <div class="ver-mas">
                <a href="noticias.php">Ver más</a>
            </div>
        </div>

        <footer>
            <!-- Incluyo el footer utilizando JavaScript -->
            <div id="footer-container"></div>
        </footer>
</body>
</html>