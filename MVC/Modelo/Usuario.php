<?php
require_once('../controlador/conexion_db.php');
require_once('../Modelo/perfil.php');

    class Usuario
    {
        private $id;
        private $nombre;
        private $correo;
        private $password;
        private $fechaNacimiento;
        private $conexion;

        public function __construct($id,$correo, $password, $fechaNacimiento, $nombre)
        {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->correo = $correo;
            $this->password = $password;
            $this->fechaNacimiento = $fechaNacimiento;

            try {
                // Utiliza la conexión centralizada
                $this->conexion = $GLOBALS['conn'];
            } catch (PDOException $e) {
                die("Error en la conexión de base de datos: " . $e->getMessage());
            }
        }
        public function obtenerIdRolUsuario()
        {
            $rolUsuario = "usuario";
            $sql = "SELECT id FROM roles WHERE nombre = :rolUsuario";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':rolUsuario', $rolUsuario);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
        public function registrar()
        {
    
            $verificarNombre = new perfilUser('','','',''); //Instancio un objeto de mi clase perfil (que traje del modelo perfil.php)
            // Validar que el correo no esté en uso
            if ($this->verificarCorreoExistente($this->correo)) {
                return "El correo ya está en uso.";
            }
    
            if($verificarNombre->verificarNombreExistente($this->nombre, $this->id)){ //Invoco al metodo para verificar si el nombre existe.
                return "El nombre ya está en uso."; //Si existe, devuelvo un mensaje de error en la pagina.
            }
    
            
    
            // Registro del usuario
            $sqlUsuario = "INSERT INTO usuario(fecha_nacimiento, nombre, email, password) VALUES (:fechaNacimiento, :nombre, :correo, :password)";
            $stmtUsuario = $this->conexion->prepare($sqlUsuario); //Preparo la consulta que me inserta un usuario
    
            if (!$stmtUsuario) {
                return "Error en la consulta SQL de usuario";
            }
    
            $stmtUsuario->bindParam(':fechaNacimiento', $this->fechaNacimiento, PDO::PARAM_STR);
            $stmtUsuario->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmtUsuario->bindParam(':correo', $this->correo, PDO::PARAM_STR);
            $stmtUsuario->bindParam(':password', $this->password, PDO::PARAM_STR);
    
            try {
                $this->conexion->beginTransaction();
    
                if ($stmtUsuario->execute()) {
                    // aca obtengo el ID del usuario recién registrado
                    $idUsuario = $this->conexion->lastInsertId();
    
                    // aca obtengo el ID del rol "usuario"
                    $idRolUsuario = $this->obtenerIdRolUsuario();
    
                    // asigno automáticamente el rol "usuario" al usuario registrado
                    $sqlAsignarRol = "INSERT INTO roles_usuarios(id_usuario, id_rol) VALUES (:idUsuario, :idRolUsuario)";
                    $stmtAsignarRol = $this->conexion->prepare($sqlAsignarRol);
                    $stmtAsignarRol->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                    $stmtAsignarRol->bindParam(':idRolUsuario', $idRolUsuario, PDO::PARAM_INT);
    
                    if ($stmtAsignarRol->execute()) {
                        $this->conexion->commit();  //Confirmo los cambios en la base de datos
                        header('Location: ../Vistas/index.php');
                        return true;
                    } else {
                        $this->conexion->rollBack();  //Deshago los cambios que realicé en la consulta para evitar que se actualice la bbdd
                        return "Error al asignar el rol al usuario";
                    }
                } else {
                    $this->conexion->rollBack();
                    return "Error al registrar el usuario";
                }
            } catch (PDOException $e) {
                $this->conexion->rollBack();
                return "Error en la transacción: " . $e->getMessage();
            }
        }

        public function registrarADM($nombre, $rol)
        {
            try {

                if (!$this->VerificarRol($nombre, $rol) ){
                    return 'ERROR: El usuario ya tiene este rol asignado.';
                    
                }
        
                // Iniciar transacción
                $this->conexion->beginTransaction();
        
                // Asignar automáticamente el rol al usuario registrado
                $sqlAsignarRol = "INSERT INTO roles_usuarios(id_rol, id_usuario) VALUES (:rol, :nombre)";
                $stmtAsignarRol = $this->conexion->prepare($sqlAsignarRol);
                $stmtAsignarRol->bindParam(':rol', $rol, PDO::PARAM_INT);
                $stmtAsignarRol->bindParam(':nombre', $nombre, PDO::PARAM_INT);
        
                if ($stmtAsignarRol->execute()) {
                    // Confirmar los cambios en la base de datos
                    $this->conexion->commit();
                    header('Location: ../Vistas/index.php');
                    return true;
                } else {
                    // Deshacer los cambios en caso de error
                    $this->conexion->rollBack();
                    return "Error al asignar el rol al usuario";
                }
            } catch (PDOException $e) {
                // Manejar excepciones y deshacer cambios en caso de error
                $this->conexion->rollBack();
                return "Error en la transacción: " . $e->getMessage();
            }
        }

        public function VerificarRol($nombre, $rol)
        {

                // Verificar si el usuario ya tiene asignado el rol
                $sqlVerificar = "SELECT COUNT(*) FROM roles_usuarios WHERE id_rol = :rol AND id_usuario = :nombre";
                $stmtVerificar = $this->conexion->prepare($sqlVerificar);
                $stmtVerificar->bindParam(':rol', $rol, PDO::PARAM_INT);
                $stmtVerificar->bindParam(':nombre', $nombre, PDO::PARAM_INT);
                $stmtVerificar->execute();
        
                $existeRegistro = $stmtVerificar->fetchColumn();
        
                if ($existeRegistro) {
                    // El usuario ya tiene asignado el rol
                    return false;
                }
                return true;
        }


        public function verificarCorreoExistente($correo)
        {
            $sql = "SELECT COUNT(*) as total FROM usuario WHERE email = :correo"; //Cuento el numero de registros donde la columna email sea igual a correo
            $stmt = $this->conexion->prepare($sql);

            if ($stmt) {
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                $stmt->execute();            
                $total = $stmt->fetchColumn(); //Con fetchColumn (metodo de PDO) verifico si ya existe el correo en la tabla

                return $total > 0; //devuelve true si el num total de filas es mayor que 0, quiere decir que ya existe el correo en la tabla. Si no, devuelve false
            } else {
                return false;
            }
        }
        public function validaRequerido($nombre, $correo, $fecha_nacimiento)
        {
                // Validar formato de correo electrónico
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return 'El formato del correo electrónico no es válido.';
            }

            $edadMinima = 16;   //Minimo 16 años para registrarse
            $edadMaxima = 100;  //Maximo 100 años para registrarse
            $fechaActual = new DateTime();
            $fechaNacimiento = new DateTime($fecha_nacimiento);
            $diferencia = $fechaNacimiento->diff($fechaActual);
            $edad = $diferencia->y;

            if ($edad < $edadMinima || $edad > $edadMaxima) {
                return 'Debes ser mayor de 16 años y menor de 100 años para registrarte.';
            }

            // valido que el campo no este vacio
            if (trim($nombre) === '') {
                return 'El campo nombre no puede estar vacío.';
            }

            // divido la cadena del input por cada espacio que encuentre, y lo guardo en la variable palabras
            $palabras = explode(' ', $nombre);

            // Valido que palabras sea distinto de 2, es decir, que no exista mas ni menos de 2 palabras
            if (count($palabras) != 1) {
                return 'El campo nombre debe contener al menos dos palabras. ';
            }

            foreach ($palabras as $palabra) {  //Valido el campo nombre para que las palabras no tengan numeros ni caracteres fuera del abecedario
                if (!preg_match('/^[a-zA-ZáéíóúüÁÉÍÓÚÜ]+$/', $palabra)) {
                    return 'Debe contener solo letras y tildes.';
                }

                $longitud = mb_strlen($nombre, 'UTF-8');
                if ($longitud < 4 || $longitud > 60) {  //Valido el rango de caracteres de las palabras, uso entre 4 y 60, es decir, el nombre debe tener almenos 4 caracteres
                    return 'Cada palabra debe tener entre 4 y 60 caracteres.';
                }
            }
            // Todas las validaciones pasaron
            return true; //Retorno verdadero porque el formato del campo nombre cumple las validaciones
        }
        public function eliminarPorCorreo($correoUsuario) {
            $sql = "DELETE FROM usuario WHERE email = '$correoUsuario'"; #Consulta para eliminar un registro de la tabla mediante su correo electronico
            return $this->conexion->query($sql);
        }
        public function buscarusuario($correo){
            if (empty($correo)) {
                echo "Error: El correo del usuario está vacío.";
                return false;
            }
            $sql = "SELECT  nombre, email, fecha_nacimiento FROM usuario WHERE email= :correo"; //Consulta para obtener datos de un usuario mediante su correo
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        
            $stmt->execute();
        
            if ($stmt->rowCount() > 0) { //Con rowCount verifico si la consulta me trajo algun registro
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);   //Con fetch obtengo la primera fila del conjunto
        
                $usuario = new Usuario("", "", "", "", "");
                $usuario->nombre = $fila["nombre"];
                $usuario->correo = $fila["email"];
                $usuario->fechaNacimiento = $fila["fecha_nacimiento"];  //Los datos que obtuve se los asigno al objeto
        
                return $usuario;  //Retorno el objeto usuario
            } else {
                return null;
            }
        }
        public function eliminarRolesUsuariosPorUsuario($correo) {
            try {
                $sql = "DELETE FROM roles_usuarios WHERE id_usuario = (SELECT id FROM usuario WHERE email = :correo)";
                $stmt = $this->conexion->prepare($sql);
                $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
                
                if ($stmt->execute()) {
                    return true;
                } else {
                    return "Error al eliminar roles de usuarios: " . $stmt->errorInfo()[2];
                }
            } catch (PDOException $e) {
                return "Error en la conexión de base de datos: " . $e->getMessage();
            }
        }
        public function editar($id) {
            $sql = "UPDATE usuario SET fecha_nacimiento = :fechaNacimiento, nombre = :nombre, email = :correo, password = :password WHERE id = :id";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':fechaNacimiento', $this->fechaNacimiento, PDO::PARAM_STR);
            $stmt->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $this->correo, PDO::PARAM_STR);
            $stmt->bindParam(':password', $this->password, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                echo "Usuario actualizado con éxito.";
                return true;
            } else {
                echo "Error al actualizar: " . $stmt->errorInfo()[2];
                return false;
            }
        } 
        public function ConseguirID($correo){
            $sql = "SELECT id FROM usuario WHERE email = :correo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($result !== false) {
                    $id = $result['id'];
                    return $id;
                } else {
                    echo"No se encontraron resultados.";
                }
            } else {
                echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
                return false;   
            }
        }
    }
?>
    



