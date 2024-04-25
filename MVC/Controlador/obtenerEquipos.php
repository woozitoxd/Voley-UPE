<?php
require_once('../controlador/conexion_db.php'); // Incluye el archivo de conexión

try {
    $conn = $GLOBALS['conn'];

    $sql = "SELECT id, nombre FROM equipo";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $equipos = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Utilizamos fetchAll para obtener todas las filas

    foreach ($equipos as $equipo) {
        echo "<option value='" . $equipo['id'] . "'>" . $equipo['nombre'] . "</option>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


