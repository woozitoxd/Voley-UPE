<?php
    include_once ('../Modelo/Usuario.php');
    require_once ('../controlador/Permisos.php');
    require_once ('../controlador/iniciarSesionUsuario.php');
    $usuarioID = null; 
    if (isset($_SESSION['usuario']) && $_SESSION['usuario']){
        $usuarioID = $_SESSION['id']; //
    }

    if (!Permisos::esRol('administrador', $usuarioID)) {
        echo "Debes ser administrador para administrar. ". '<a href="../vistas/index.php">Volver</a>';
        exit();
    }
    if (!Permisos::tienePermiso('PanelControl_adm', $usuarioID)) {
        echo "Debes tener permiso para editar contenido. ". '<a href="../vistas/index.php">Volver</a>';
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correoViejo = isset($_POST["emailViejo"]) ? $_POST["emailViejo"] : null;
        $correoNuevo = isset($_POST["email"]) ? $_POST["email"] : null;
        if (empty($_POST["emailViejo"]) && empty($_POST["email"])){
            echo "Debes completar todos los campos para lograr un registro exitoso";
            exit();
        }

        $nombre = $_POST["nombre"];
        $password = $_POST["contraseña"];
        $fecha_edad = $_POST["fecha_edad"];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $usuarioViejo = new Usuario("", "", "", "", "");
        $usuario = new Usuario("", $correoNuevo, $hashedPassword, $fecha_edad, $nombre);
        $id = $usuarioViejo->ConseguirID($correoViejo);

        if(!$id){
            echo'No se encontro el correo del usuario';
            header('Location: ../Vistas/editarUsuario.php?modal=error');
            exit();
        }
        $Validar=$usuario->editar($id);

        if($Validar==true) {
            header('Location: ../Vistas/controlAdmin.php');
            exit();
        } else {
            echo "Error al editar el usuario";
            header('Location: ../Vistas/editarUsuario.php?modal=error');
            exit();
        }
    }
?>