<?php

require_once('../controlador/conexion_db.php');

class Equipo
{
    private $nombre;
    private $puntos;
    private $liga;
    private $conexion;

    public function __construct($nombre, $puntos, $liga)
    {
        $this->nombre = $nombre;
        $this->puntos = $puntos;
        $this->liga = $liga;

        // Utilizamos la conexión centralizada
        $this->conexion = $GLOBALS['conn'];
    }

    public function registrar()
    {
        $sql = "INSERT INTO equipo(nombre, puntos, id_liga) VALUES(:nombre, :puntos, :liga)";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':puntos', $this->puntos, PDO::PARAM_INT);
        $stmt->bindParam(':liga', $this->liga, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error en el query";
            return false;
        }
    }

    public function ValidarNombre($nombre) {
        
        if (trim($nombre) === '') {
            return false;
        }

        $palabras = explode(' ', $nombre);

        if (count($palabras) != 2) {   
           return false;
        }
        if (strlen($nombre) < 4 || strlen($nombre) > 15) {
            return false;
        }
        return true;
    }
    public function recuperarTodosLosEquipos()
    {
        $sql = "SELECT * FROM equipo";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        $equipos = array();
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $equipos[] = $fila;
        }
        return $equipos;
    }

    public function verificarNombreEquipo($nombre)
    {
        $sql = "SELECT COUNT(*) as total FROM equipo WHERE nombre = :nombre"; 
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

// Uso del ejemplo
$equipo = new Equipo("Nombre del Equipo", 0, 1);
$equipo->registrar();

// Recuperar todos los equipos
$equiposRecuperados = $equipo->recuperarTodosLosEquipos();
echo json_encode($equiposRecuperados);
?>