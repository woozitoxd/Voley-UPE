<?php
    require_once('../controlador/conexion_db.php');

    class partido
    {
        private $id;
        private $fecha;
        private $puntosGanador;
        private $puntosPerdedor;
        private $equipo1;
        private $equipo2;
        private $ganador;
        private $perdedor;
        private $ubicacion;
        private $pathFoto;
        private $conexion;
        
        public function __construct($id,$equipo1,$equipo2,$fecha,$ganador,$perdedor, $puntosGanador,$puntosPerdedor,$ubicacion, $pathFoto)
        {
            $this->id= $id;
            $this->equipo1 = $equipo1;
            $this->equipo2 = $equipo2;
            $this->fecha = $fecha;
            $this->ganador = $ganador;
            $this->perdedor = $perdedor;
            $this->puntosGanador = $puntosGanador;
            $this->puntosPerdedor = $puntosPerdedor;
            $this->ubicacion = $ubicacion;
            $this->pathFoto = $pathFoto;

            try {
                // Utiliza la conexión centralizada
                $this->conexion = $GLOBALS['conn'];
            } catch (PDOException $e) {
                die("Error en la conexión de base de datos: " . $e->getMessage());
            }
        }

        public function Agregar()
        {
            $sql = "INSERT INTO partido(id_equipo1,id_equipo2,fecha,id_ganador,id_perdedor,puntos_ganador,puntos_perdedor,id_ubicacion, pathFoto) VALUES('$this->equipo1','$this->equipo2','$this->fecha','$this->ganador','$this->perdedor','$this->puntosGanador','$this->puntosPerdedor','$this->ubicacion', '$this->pathFoto')";
            if($this->conexion->query($sql))
            {
            return true;
            }
            else
            {
            echo "error en el query";
            return false;
            }    
        }

        public function eliminarPartido($fechaPartido, $Equipo1, $Equipo2)
        {
            $sql = "DELETE FROM partido WHERE fecha = '$fechaPartido' AND id_equipo1= '$Equipo1' AND id_equipo2= '$Equipo2'";
            return $this->conexion->query($sql);
        }

        public function editar($id) {
            $sql = "UPDATE partido SET id_equipo1= :equipo1, id_equipo2= :equipo2, fecha = :fecha, id_ganador = :ganador, id_perdedor = :perdedor, puntos_ganador = :puntosGanador, puntos_perdedor = :puntosPerdedor, id_ubicacion = :ubicacion, pathFoto= :pathFoto WHERE id = :id";
        
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fecha', $this->fecha, PDO::PARAM_STR);
            $stmt->bindParam(':equipo1', $this->equipo1, PDO::PARAM_STR);
            $stmt->bindParam(':equipo2', $this->equipo2, PDO::PARAM_STR);
            $stmt->bindParam(':ganador', $this->ganador, PDO::PARAM_STR);
            $stmt->bindParam(':perdedor', $this->perdedor, PDO::PARAM_STR);
            $stmt->bindParam(':puntosGanador', $this->puntosGanador, PDO::PARAM_STR);
            $stmt->bindParam(':puntosPerdedor', $this->puntosPerdedor, PDO::PARAM_STR);
            $stmt->bindParam(':ubicacion', $this->ubicacion, PDO::PARAM_STR);
            $stmt->bindParam(':pathFoto', $this->pathFoto, PDO::PARAM_STR);

            if ($stmt->execute()) {
                return "Partido actualizado con éxito.";
            } else {
                return "Error al actualizar: " . $stmt->errorInfo()[2];
            }
        } 

        public function ConseguirID($fecha, $equipo1, $equipo2) {
            $sql = "SELECT id FROM partido WHERE fecha = :fecha AND id_equipo1 = :equipo1 AND id_equipo2 = :equipo2";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
            $stmt->bindParam(':equipo1', $equipo1, PDO::PARAM_STR);
            $stmt->bindParam(':equipo2', $equipo2, PDO::PARAM_STR);
            
            $stmt->execute();
            
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['id'];
            } else {
                // Manejar el caso en el que no se encuentra el partido
                return null;
            }
        }
        public function validarEquipos($equipo1Recibido,$equipo2Recibido){
            if($equipo1Recibido === $equipo2Recibido){
                return false;
            }
                return true;
        }

        public function ValidarGanador($ganador,$perdedor){
            if($ganador === $perdedor){
                return false;
            }else{
                return true;
            }
        }
    }
?>