<?php
    require_once('../controlador/conexion_db.php');
    class liga
    {
        private $id;
        private $nombre;
        private $conexion;
        
        public function __construct($id,$nombre)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            // nombreservidor, nombreUsuario, contraseña, nombreDeLaBBDD.
            try {
                // Utiliza la conexión centralizada
                $this->conexion = $GLOBALS['conn'];
            } catch (PDOException $e) {
                die("Error en la conexión de base de datos: " . $e->getMessage());
            }
        }
        public function registrarliga()
        {
            if (empty($this->nombre)) {
                echo "Error: El nombre de la liga está vacío.";
                return false;
            }
            $sql = "INSERT INTO liga (nombre) VALUES (:nombre)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error en el query: " . $stmt->error;
                $stmt->close();
                return false;
            }
        }
        
        public function editar($id, $nombre) {
            $sql = "UPDATE liga SET nombre = :NombreLiga WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':NombreLiga', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return "Liga actualizada con éxito.";
            } else {
                return "Error al actualizar: " . $stmt->errorInfo()[2];
            }
        }
        public function ConseguirID($nombre){
            $sql = "SELECT id FROM liga WHERE nombre = :nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result !== false) {
                    $id = $result['id'];
                    return $id;
                } else {
                    return "No se encontraron resultados.";
                }
            } else {
                return "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
            }
        } 
        public function eliminarLiga($nombre){
            $sql = "DELETE FROM liga WHERE nombre = '$nombre'";
            return $this->conexion->query($sql);
        }
        public function buscarLiga($nombre){
            if (empty($nombre)) {
                    echo "Error: El nombre de la liga está vacío.";
                    return false;
                }
            
            $sql = "SELECT * FROM liga WHERE nombre=:nombre";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            
                if ($stmt->execute()) {
                    // Devuelve el resultado (puede ser un array asociativo con los datos de la liga)
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                } else {
                    echo "Error en el query: " . $stmt->error;
                    return false;
                }
        }
        
        public function ValidarNombreliga($nombre){
            if (trim($nombre) === '') {
    
                return false;
            }
            $palabras = explode(' ', $nombre);
    
            if (count($palabras) != 2) {
               
               return false;
            }
            return true;
        }

        public function verificarNombreLiga($nombre)
        {
            $sql = "SELECT COUNT(*) as total FROM liga WHERE nombre = :nombre"; 
            $stmt = $this->conexion->prepare($sql);
    
            if ($stmt) {
                $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
                $stmt->execute();            
                $total = $stmt->fetchColumn(); //Con fetchColumn (metodo de PDO) verifico si ya existe el correo en la tabla
    
                return $total > 0; //devuelve true si el num total de filas es mayor que 0, quiere decir que ya existe el correo en la tabla. Si no, devuelve false
            } else {
                return false;
            }
        }
    }
?>