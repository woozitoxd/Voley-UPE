<?php
    require_once('../controlador/conexion_db.php');
    class ubicacion
    {
        private $nombre;
        private $conexion;
        public function __construct($nombre)
        {
            $this->nombre = $nombre;
            // nombreservidor, nombreUsuario, contraseña, nombreDeLaBBDD.
            try {
                // Utiliza la conexión centralizada
                $this->conexion = $GLOBALS['conn'];
            } catch (PDOException $e) {
                die("Error en la conexión de base de datos: " . $e->getMessage());
            }
        }
    }
?>