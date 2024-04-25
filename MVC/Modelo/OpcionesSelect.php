<?php

require_once('../controlador/conexion_db.php');
class OpcionesMostrar {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerOpciones($tabla) {
        try {
            $consultSQL = "SELECT id, nombre FROM $tabla";
            $stmt = $this->conn->prepare($consultSQL);
            $stmt->execute();
            $opciones = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $opciones;
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerOpcionesNoticias($tabla) {
        try {
            $consultSQL = "SELECT id, titulo FROM $tabla";
            $stmt = $this->conn->prepare($consultSQL);
            $stmt->execute();
            $opciones = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $opciones;
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
            return [];
        }
    }

    public function obtenerDenuncias()
    {
        try {
            $consultSQL = "SELECT RC.idReporte, R.descripcion as razones, C.idComentario, C.comentario as Comentarios, U.nombre as usuario
            FROM reportescomentarios RC
            JOIN razones R ON RC.idRazon = R.idRazon
            JOIN comentarios C ON RC.idComentario = C.idComentario
            JOIN usuario U ON RC.idUsuarioReporta = U.id";
                           
            $stmt = $this->conn->prepare($consultSQL);
            $stmt->execute();
            $denuncias = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $denuncias;
        } catch (PDOException $e) {
            echo "Error de consulta: " . $e->getMessage();
            return [];
        }
    }
}

?>