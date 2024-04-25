<?php
    require_once('../controlador/conexion_db.php');
    class Jugador
    {
        private $id;
        private $nombre;
        private $apellido;
        private $edad;
        private $altura;
        private $id_posicion;
        private $id_equipo;
        private $pathFoto;
        private $conexion;
        public function __construct($id,$nombre, $apellido, $edad, $altura, $id_posicion, $id_equipo, $pathFoto)
        {
            $this->id=$id;
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->edad = $edad;
            $this->altura = $altura;
            $this->id_posicion = $id_posicion;
            $this->id_equipo = $id_equipo;
            $this->pathFoto = $pathFoto;
        
            try {
                // Utiliza la conexión centralizada
                $this->conexion = $GLOBALS['conn'];
            } catch (PDOException $e) {
                die("Error en la conexión de base de datos: " . $e->getMessage());
            }
        } 
        public function registrar()
        {
            $sql = "INSERT INTO jugador (nombre, apellido, edad, altura, id_posicion, id_equipo, pathFoto) 
                    VALUES (:nombre, :apellido, :edad, :altura, :id_posicion, :id_equipo, :pathFoto)";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(':edad', $this->edad, PDO::PARAM_INT);
            $stmt->bindParam(':altura', $this->altura, PDO::PARAM_STR);
            $stmt->bindParam(':id_posicion', $this->id_posicion, PDO::PARAM_INT);
            $stmt->bindParam(':id_equipo', $this->id_equipo, PDO::PARAM_INT);
            $stmt->bindParam(':pathFoto', $this->pathFoto, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                return true;
            } else {
                echo "Error en el query: " . $stmt->error;
                return false;
            }
        }
        public function eliminarNombreYApellido($nombreJugador, $apellidoJugador)
        {
            $sql = "DELETE FROM jugador WHERE nombre = :nombre AND apellido = :apellido";
        
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombreJugador, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellidoJugador, PDO::PARAM_STR);
        
            return $stmt->execute();
        }
        public function buscar($nombreJugador, $apellidoJugador, $edadJugador, $idequipo)
        {
            $sql = "SELECT * FROM jugador WHERE nombre=:nombre AND apellido=:apellido AND edad=:edad AND id_equipo=:idequipo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombreJugador, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellidoJugador, PDO::PARAM_STR);
            $stmt->bindParam(':edad', $edadJugador, PDO::PARAM_INT);
            $stmt->bindParam(':idequipo', $idequipo, PDO::PARAM_INT);
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) {
                // Devuelve un array asociativo en lugar de un objeto Jugador
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        }
        public function recuperarTodosLosJugadores()
        {
            $sql = "SELECT * FROM jugador";
            $stmt = $this->conexion->query($sql);
        
            $jugadores = array();
            while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $jugadores[] = $fila;
            }
        
            echo json_encode($jugadores);
        }
        public function editar($id) {
            $sql = "UPDATE jugador SET nombre=:nuevo_nombre, apellido=:nuevo_apellido, 
            edad=:nueva_edad, altura=:nueva_altura, pathFoto=:nueva_pathFoto, 
            id_equipo=:nuevo_id_equipo, id_posicion=:nuevo_id_posicion  WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':nuevo_nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':nuevo_apellido', $this->apellido, PDO::PARAM_STR);
            $stmt->bindParam(':nueva_edad', $this->edad, PDO::PARAM_INT);
            $stmt->bindParam(':nueva_altura', $this->altura, PDO::PARAM_STR);
            $stmt->bindParam(':nueva_pathFoto', $this->pathFoto, PDO::PARAM_STR);
            $stmt->bindParam(':nuevo_id_equipo', $this->id_equipo, PDO::PARAM_INT);
            $stmt->bindParam(':nuevo_id_posicion', $this->id_posicion, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                return"Usuario actualizado con éxito.";
               // return true;
            } else {
                echo "Error al actualizar: " . $stmt->errorInfo()[2];
                return false;
            }
        } 
        public function ConseguirID($nombreJugador, $apellidoJugador, $edadJugador, $idequipo){
            $sql = "SELECT id FROM jugador WHERE nombre=:nombre AND apellido=:apellido AND edad=:edad AND id_equipo=:idequipo";
            $stmt = $this->conexion->prepare($sql);
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombreJugador, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellidoJugador, PDO::PARAM_STR);
            $stmt->bindParam(':edad', $edadJugador, PDO::PARAM_INT);
            $stmt->bindParam(':idequipo', $idequipo, PDO::PARAM_INT);
        
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result !== false) {
                    $id = $result['id'];
                    return $id;
                } else {
                    return "No se encontraron resultados.";
                    
                }
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
                return false;
            }
        }

        public function ValidarJugador($nombre, $apellido){
            if (trim($nombre) === '' || trim($apellido) === '') {
                return 'Debe completar el nombre y el apellido';
            }
        
            $palabrasNombre = explode(' ', $nombre);
            $palabrasApellido = explode(' ', $apellido);
        
            if (count($palabrasNombre) != 1 || count($palabrasApellido) != 1) {
                return 'El campo nombre y apellido deben contener una palabra.';
            }
        
            foreach ($palabrasNombre as $palabra) {
                if (!preg_match('/^[a-zA-ZáéíóúüÁÉÍÓÚÜ]+$/', $palabra)) {
                    return 'Debe contener solo letras y tildes en el nombre.';
                }
        
                $longitud = mb_strlen($nombre, 'UTF-8');
                if ($longitud < 4 || $longitud > 30) {
                    return 'El nombre debe tener entre 4 y 30 caracteres.';
                }
            }
        
            foreach ($palabrasApellido as $palabra) {
                if (!preg_match('/^[a-zA-ZáéíóúüÁÉÍÓÚÜ]+$/', $palabra)) {
                    return 'Debe contener solo letras y tildes en el apellido.';
                }
        
                $longitud = mb_strlen($apellido, 'UTF-8');
                if ($longitud < 4 || $longitud > 30) {
                    return 'El apellido debe tener entre 4 y 30 caracteres.';
                }
            }
            return true;
        }
    }
?>