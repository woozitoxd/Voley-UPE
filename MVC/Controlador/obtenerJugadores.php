<?php
require_once('../controlador/conexion_db.php'); // Incluye el archivo de conexión

try {
    $conn = $GLOBALS['conn'];

    if (isset($_POST['equipoId'])) {
        $equipoId = $_POST['equipoId'];

        // Consulta para obtener los jugadores del equipo seleccionado
        $sql = "SELECT nombre, apellido, edad, altura, pathFoto FROM jugador WHERE id_equipo = :equipoId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':equipoId', $equipoId, PDO::PARAM_INT);
        $stmt->execute();

        $jugadoresHTML = "<div class='row'>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $jugadoresHTML .= "<div class='col-md-4'>";
            $jugadoresHTML .= "<img class='Fichasimg' src='../Vistas/imagenes/jugadores/{$row['pathFoto']}' alt='{$row['nombre']}'/>";
            $jugadoresHTML .= "</div>";

            $jugadoresHTML .= "<div class='col-md-8'>";
            $jugadoresHTML .= "<div class='txtF'>";
            $jugadoresHTML .= "<p>{$row['nombre']}<br><span>{$row['apellido']}</span></p>";
            $jugadoresHTML .= "<p>Edad: {$row['edad']}</p>";
            $jugadoresHTML .= "<p>Altura: {$row['altura']} mts</p>";
            $jugadoresHTML .= "</div>";
            $jugadoresHTML .= "</div>";
        }

        $jugadoresHTML .= "</div>";

        echo $jugadoresHTML;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
