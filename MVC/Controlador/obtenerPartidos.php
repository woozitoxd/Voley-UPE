<?php
// Conexión a la base de datos
require_once('../controlador/conexion_db.php'); // Asegúrate de que la ruta sea correcta

try {
    // Consulta para obtener los partidos
    $sql = "SELECT id_equipo1, id_equipo2, fecha, id_ubicacion, pathFoto FROM partido";
    $stmt = $GLOBALS['conn']->query($sql);

    // Generar el HTML de los partidos
    $partidosHTML = "<div class='row'>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $partidosHTML .= "<div class='col-md-6 mb-4'>";
        $partidosHTML .= "<div class='card'>";
        $partidosHTML .= "<img src='../Vistas/imagenes/estetica/{$row['pathFoto']}' class='card-img-top' alt='Partido'>";
        $partidosHTML .= "<div class='card-body'>";
        $partidosHTML .= "<h5 class='card-title'>{$row['id_equipo1']} vs {$row['id_equipo2']}</h5>";
        $partidosHTML .= "<p class='card-text'>Fecha: {$row['fecha']}</p>";
        $partidosHTML .= "<p class='card-text'>Ubicación: {$row['id_ubicacion']}</p>";
        $partidosHTML .= "</div>";
        $partidosHTML .= "</div>";
        $partidosHTML .= "</div>";
    }

    $partidosHTML .= "</div>";

    echo $partidosHTML;
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

?>

<?php
// ...
