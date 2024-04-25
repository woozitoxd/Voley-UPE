<?php

require_once('../controlador/conexion_db.php');

class perfilUser
{
    private $nombre;
    private $correo;
    private $password;
    private $fechaNacimiento;
    private $conexion;

    public function __construct($correo, $password, $fechaNacimiento, $nombre)
    {
        $this->nombre = $nombre;
        $this->correo = $correo;
        $this->password = $password;
        $this->fechaNacimiento = $fechaNacimiento;
        
        $this->conexion = $GLOBALS['conn'];

    }

    public function consultar($nombre, $correo, $password) {
        $sql = "SELECT id, nombre, email, fecha_nacimiento, password FROM usuario WHERE nombre = :nombre AND email = :correo";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    
        $stmt->execute();
    
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($usuario && password_verify($password, $usuario['password'])) { //Funcion password_verify para verificar si la contraseña coincide con la almacenada en la BBDD
            unset($usuario['password']); // Unset de la contraseña para no almacenarla en la sesion
            return $usuario;
        } else {
            return null;
        }
    }


    public function editarPerfil($idUser)
    {

    // Verificar si el correo ya existe
    if ($this->verificarCorreo($this->correo, $idUser)) {
        return "El correo ya está en uso.";
    }

    if($this->verificarNombreExistente($this->nombre, $idUser)){
        return "El nombre de usuario ya existe.";
    }

        $sql = "UPDATE usuario SET nombre = :editNombre, email = :correoEdit, fecha_nacimiento = :fechaEdit WHERE ID = :idUser";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':editNombre', $this->nombre, PDO::PARAM_STR);
        $stmt->bindParam(':correoEdit', $this->correo, PDO::PARAM_STR);
        $stmt->bindParam(':fechaEdit', $this->fechaNacimiento, PDO::PARAM_STR);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        

        if ($stmt->execute()) {
            return true;
        } else {
            return "Error al actualizar: " . $stmt->errorInfo()[2];
        }
    }

    public function verificarNombreExistente($nombre, $idUser)
    {
        // Consulta para verificar si el nombre ya existe, excluyendo el nombre actual del usuario
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE nombre = :nombre AND ID != :idUser";
        $stmt = $this->conexion->prepare($sql);
        if($stmt){
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            
            $total = $stmt->fetchColumn();
    
            // Si el total es mayor a 0, significa que el nombre ingresado ya existe
            return $total > 0;
        }else{
            return false;
        }

    }

    private function verificarCorreo($correo, $idUser)
    {
        // Consulta para verificar si el correo ya existe, excluyendo el correo actual del usuario
        $sql = "SELECT COUNT(*) as total FROM usuario WHERE email = :correo AND ID != :idUser";
        $stmt = $this->conexion->prepare($sql);

        if($stmt){
            $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->execute();
            
            $total = $stmt->fetchColumn();
        
            // Si el total es mayor a 0, significa que el correo ingresado ya existe
            return $total > 0;
        }else{
            return false;
        }

    }

    public function validaRequerido($nombre, $correo, $fecha_nacimiento)
    {

              // Validar formato de correo electrónico
            if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
                return 'El formato del correo electrónico no es válido.';
            }
    
    
            // Validar si la fecha de nacimiento es menor de 16 años
            $edadMinima = 16;
            $edadMaxima = 100;
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
        if (count($palabras) != 1){
            return 'El campo nombre debe contener al menos una palabras. ';
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

    public function verificarContraseña($usuarioID, $contraseña) { //Recibo por parametro el ID del usuario y la contraseña ingresada
        $sql = "SELECT password FROM usuario WHERE id = :usuarioID";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':usuarioID', $usuarioID, PDO::PARAM_INT);
        $stmt->execute();

        $hashContraseña = $stmt->fetchColumn();
        if(!password_verify($contraseña, $hashContraseña)){
            return false; //Verifico que la contraseña sea coincidente con la existente en la BBDD con passwrod_verifiy
        }
    
        return true; 
    }

    public function actualizarContraseña($idUser, $hashedPassword) {

        try {
            // consulta para cambiar la contraseña en la base de datos
            $sql = "UPDATE usuario SET password = :hashedPassword WHERE id = :idUser";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
    
            return true; // devuelvo verdadero
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
}
?>