<?php
    require_once('../controlador/conexion_db.php'); // Incluye el archivo de conexión
    try {
        $conn = $GLOBALS['conn'];

        $sql = "SELECT id, nombre FROM ubicacion";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $ubicaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Utilizamos fetchAll para obtener todas las filas

        foreach ($ubicaciones as $ubicacion) {
            echo "<option value='" . $ubicacion['id'] . "'>" . $ubicacion['nombre'] . "</option>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>


