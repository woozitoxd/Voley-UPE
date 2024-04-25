<?php
require_once("../Modelo/Usuario.php");
require_once("../Controlador/Permisos.php");
require_once("../Controlador/iniciarSesionUsuario.php");
require_once('../controlador/conexion_db.php');

$idNoticiaPrincipal = isset($_GET['id']) ? $_GET['id'] : null;

if ($idNoticiaPrincipal === null) {
    header("Location: noticias.php");
    exit;
}

// Inicializar las variables
$titulo = "";
$parrafo = "";
$nombreImagen = "";
$nombreImagen2 = "";

$sql = "SELECT Noticias.Titulo, Noticias.Descripcion, Noticias.PathFoto1, Noticias.PathFoto2 
        FROM Noticias 
        WHERE Noticias.IdNoticiaPrincipal = :idNoticiaPrincipal";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':idNoticiaPrincipal', $idNoticiaPrincipal, PDO::PARAM_INT);

try {
    $stmt->execute();

    $noticia = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($noticia) {
        // Si se encontraron resultados, asignar los valores
        $titulo = $noticia['Titulo'];
        $parrafo = $noticia['Descripcion'];
        $nombreImagen = $noticia['PathFoto1'];
        $nombreImagen2 = $noticia['PathFoto2'];
    } else if($titulo === '' || $parrafo === ''){
        // Si no se encontraron resultados, manejo el error
       $titulo = "<div class=card>La noticia ya existe. " . '<a href="../Vistas/View_AgregarNoticia.php">Volver a Agregar Noticia</a></div> <br>' . '<p class="text-red">ERROR 789: Se creó una vista previa de una noticia existente.</p>';
       $parrafo = "Detalle: Esta página indica que se intentó crear una noticia seleccionando una VistaPrevia de una noticia que ya existe y tiene asignada su vista previa en la BBDD." . '<br>' . "Volver y seleccionar la vista previa correspondiente.";

    }
} catch (PDOException $e) {
    echo "Error de consulta: " . $e->getMessage();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Título de la Noticia</title>
    <script defer src="script.js"></script>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="styleNoticia.css">
    <link rel="stylesheet" href="stylesLink.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div id="fondo"></div>
    <!-- Incluye la barra de navegación utilizando JavaScript -->
    <div id="navbar-container" class="pb-3"></div>

    <div class="container noticia-container">
        <!-- Muestra en la página lo que traje de la base de datos -->
        <img class="noticia-img img-fluid" src="../Vistas/imagenes/noticias/<?php echo $nombreImagen; ?>"
            alt="noticiaPrincipal">
        <h1 class="text-white"><?php echo $titulo; ?></h1>
        <p class="noticia-text text-white"><?php echo $parrafo; ?></p>
        <img class="noticia-img img-fluid" src="../Vistas/imagenes/noticias/<?php echo $nombreImagen2; ?>"
            alt="VistaPreviasNoticias">
    </div>

    <footer>
        <!-- Incluye el footer utilizando JavaScript -->
        <div id="footer-container"></div>
    </footer>
</body>
</html>