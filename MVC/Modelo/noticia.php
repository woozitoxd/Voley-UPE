<?php
require_once('../controlador/conexion_db.php');

class Noticia
{
    private $id;
    private $titulo;
    private $descripcion;
    private $pathFoto1;
    private $pathFoto2;
    private $idNoticiaPrincipal;
    private $conexion;
    
    public function __construct($id, $titulo, $descripcion, $pathFoto1, $pathFoto2, $idNoticiaPrincipal)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descripcion = $descripcion;
        $this->pathFoto1 = $pathFoto1;
        $this->pathFoto2 = $pathFoto2;
        $this->idNoticiaPrincipal = $idNoticiaPrincipal;

        try {
            // Utiliza la conexión centralizada
            $this->conexion = $GLOBALS['conn'];
        } catch (PDOException $e) {
            die("Error en la conexión de base de datos: " . $e->getMessage());
        }
    }
    
    public function agregarNoticia()
    {
        // Verificar si el último campo ya existe
        $sqlVerificacion = "SELECT COUNT(*) FROM noticias WHERE IdNoticiaPrincipal = ?";
        $stmtVerificacion = $this->conexion->prepare($sqlVerificacion);
        $stmtVerificacion->execute([$this->idNoticiaPrincipal]);
        $existeRegistro = $stmtVerificacion->fetchColumn();
    
        if ($existeRegistro > 0) {
            echo "Error: Ya existe un registro con el mismo valor en el último campo.";
            return;
        }
    
        // Si no existe, proceder con la inserción
        $sqlInsercion = "INSERT INTO noticias (Titulo, Descripcion, PathFoto1, PathFoto2, IdNoticiaPrincipal) VALUES (?, ?, ?, ?, ?)";
        $stmtInsercion = $this->conexion->prepare($sqlInsercion);
        $stmtInsercion->execute([$this->titulo, $this->descripcion, $this->pathFoto1, $this->pathFoto2, $this->idNoticiaPrincipal]);
    }

    public function agregarVistaPrevia()
    {
        $sql = "INSERT INTO noticiasprincipales (Titulo, Descripcion, PathFoto) VALUES (?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$this->titulo, $this->descripcion, $this->pathFoto1]);
    }

    public function actualizarNoticia()
    {
        $sql = "UPDATE noticias SET Titulo = :titulo, Descripcion = :descripcion, PathFoto1 = :PathFoto1, PathFoto2 = :PathFoto2 WHERE ID = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->bindParam(':PathFoto1', $this->pathFoto1, PDO::PARAM_STR);
        $stmt->bindParam(':PathFoto2', $this->pathFoto2, PDO::PARAM_STR);

        
        if ($stmt->execute()) {
            echo "Noticia actualizada con éxito.";
        } else {
            echo "Error al actualizar la noticia: " . $stmt->errorInfo()[2];
        }
    }

    public function actVistaPreviaNoticias()
    {
        $sql = "UPDATE noticiasprincipales SET Titulo = :titulo, Descripcion = :descripcion WHERE ID = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':titulo', $this->titulo, PDO::PARAM_STR);
        $stmt->bindParam(':descripcion', $this->descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
           // header ('Location: ../Vistas/NoticiasGeneral.php');
          //  echo "Vista previa de la noticia actualizada con éxito.";
        } else {
            echo "Error al actualizar la noticia: " . $stmt->errorInfo()[2];
        }
    }
    
    public function eliminarNoticia()
    {
        try {
            // Inicia una transacción
            $this->conexion->beginTransaction(); //Utilizo beginTransaction para considerar que lo siguiente a esta linea, forma parte de una unica transaccion
        
            $stmtDeleteNoticias = $this->conexion->prepare("DELETE FROM noticias WHERE IdNoticiaPrincipal = :id");
            $stmtDeleteNoticias->bindParam(':id', $this->id, PDO::PARAM_INT); //Primera consulta, elimina el registro de noticias donde la FK sea igual al ID que se selecciono
            $stmtDeleteNoticias->execute(); 
            //La segunda consulta elimina el registro de la tabla NoticiasPrincipales donde el ID sea el que se seleccionó
            $stmtDeleteNoticiasPrincipales = $this->conexion->prepare("DELETE FROM noticiasprincipales WHERE ID = :id");
            $stmtDeleteNoticiasPrincipales->bindParam(':id', $this->id, PDO::PARAM_INT);
        
            if ($stmtDeleteNoticiasPrincipales->execute()) {
                $this->conexion->commit(); //Si ambas consultas fueron exitosas, entonces hago un commit para terminar el bloque de transaccion y confirmar los cambios en la BBDD
                //echo "Noticia eliminada con exito.";
            } else {
                $this->conexion->rollBack(); // usando rollback vuelvo al estado de la base antes de que inicio la transaccion (si es que hubo errores)
                echo "Error al eliminar la noticia: " . $stmtDeleteNoticiasPrincipales->errorInfo()[2];
            }
        } catch (PDOException $e) {
            // Si ocurre un error de tipo excepcion, realiza un rollback para deshacer los cambios igualmente.
            $this->conexion->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
?>