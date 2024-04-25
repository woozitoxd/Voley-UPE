<?php
    require_once('../Modelo/Usuario.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = isset($_POST["name_registro"]) ? $_POST["name_registro"] : NULL;
        $correo = isset($_POST["email_registro"]) ? $_POST["email_registro"] : NULL;
        $password = isset($_POST["passwordRegistro"]) ? $_POST["passwordRegistro"] : NULL;
        $fecha_nacimiento = isset($_POST["fecha_Registro"]) ? $_POST["fecha_Registro"] : NULL;

        
        if (empty($_POST["name_registro"]) || empty($_POST["email_registro"]) || empty($_POST["passwordRegistro"]) || empty($_POST["fecha_Registro"])) {
            echo "Por favor, completa todos los campos para registrar el nuevo usuario de forma exitosa.";
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $usuario = new Usuario("",$correo, $hashedPassword, $fecha_nacimiento, $nombre);
        $resultado = $usuario->validaRequerido($nombre, $correo, $fecha_nacimiento);

        if ($resultado !== true) {
            echo 'Error: ' . $resultado;
            return false;

        } else {
            $resultado = $usuario->registrar(); // Intenta registrar el usuario

            if ($resultado === true) {

                header('Location: ../Vistas/index.php');
                exit();
            } else {
                echo $resultado;
            }
        }
    }
?>