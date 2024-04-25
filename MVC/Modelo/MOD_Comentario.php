<?php
require_once('../controlador/conexion_db.php');

class Comentarios
{
    
    private $IDusuario;
    private $IDcomentaro;
    private $description;
    private $NombreUSuario;
    private $conexion;

    public function __construct($IDusuario, $IDcomentaro, $description, $NombreUSuario)
    {
        $this->IDusuario = $IDusuario;
        $this->IDcomentaro = $IDcomentaro;
        $this->description = $description;
        $this->NombreUSuario = $NombreUSuario;
        
        try {
            // Utiliza la conexión centralizada
            $this->conexion = $GLOBALS['conn'];
        } catch (PDOException $e) {
            die("Error en la conexión de base de datos: " . $e->getMessage());
        }
    }

    public function AgregarComentario($UsuarioID, $descripcion)
    {
        try {
            $sql = "INSERT INTO Comentarios (UsuarioID, Comentario, fechaPublicacion) VALUES (:UsuarioID, :Descripcion, CURRENT_TIMESTAMP)";
            $stmt = $this->conexion->prepare($sql);
    
            if ($stmt) {
                $stmt->bindParam(':UsuarioID', $UsuarioID, PDO::PARAM_INT);
                $stmt->bindParam(':Descripcion', $descripcion, PDO::PARAM_STR);
    
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function ReportarComentario($idDenuncia, $idComentario, $usuarioID)
    {
        try {
            $sql = "INSERT INTO reportescomentarios (idComentario, idUsuarioReporta, idRazon, fechaReporte) VALUES (:idComentario, :usuarioID, :idDenuncia, CURRENT_TIMESTAMP)";
            $stmt = $this->conexion->prepare($sql);
    
            if ($stmt !== false) {
                $stmt->bindParam(':idComentario', $idComentario, PDO::PARAM_INT);
                $stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
                $stmt->bindParam(':idDenuncia', $idDenuncia, PDO::PARAM_STR);
    
                if ($stmt->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function EliminarComentario($comentarioID)
    {
        try {
            $this->conexion->beginTransaction();
        
            // elimino los registros de la tabla 'reportescomentarios'
            $stmt1 = $this->conexion->prepare("DELETE FROM reportescomentarios WHERE idComentario = :comentarioId");
            $stmt1->bindParam(':comentarioId', $comentarioID, PDO::PARAM_INT);
            $stmt1->execute();
        
            // luego, elimino los registros de la tabla 'comentarios'
            $stmt2 = $this->conexion->prepare("DELETE FROM comentarios WHERE idComentario = :comentarioId");
            $stmt2->bindParam(':comentarioId', $comentarioID, PDO::PARAM_INT);
            $stmt2->execute();
        
            // realizo un commit para guardar los cambios
            $this->conexion->commit();
        

            return true; 
        } catch (PDOException $e) {
            // Si ocurre una excepcion, deshago los cambios con rollback
            $this->conexion->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
}
?>