<?php
    include_once ('../Modelo/Usuario.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = isset($_POST["email"]) ? $_POST["email"] : '';    

        if (empty($_POST["email"])) {
            echo "Debes completar todos los campos para eliminar al usuario de forma exitosa";
            header('Location: ../Vistas/eliminarUsuario.php?modal=error');
            exit();
        }

        $usuario = new Usuario("","","","","");
        $ValidarCorreoExistente = $usuario->buscarusuario("$correo");

        if ($ValidarCorreoExistente === null) {
            echo 'Error en la solicitud de eliminación, usuario inexistente';
            header('Location: ../Vistas/eliminarUsuario.php?modal=error');
            exit();
        }
        // Intentar eliminar roles de usuarios por correo
        $resultadoRoles = $usuario->eliminarRolesUsuariosPorUsuario($correo);

        // Verificar si hubo un error al eliminar roles
        if ($resultadoRoles !== true) {
            echo 'Error al eliminar roles de usuarios: ' . $resultadoRoles;
            header('Location: ../Vistas/eliminarUsuario.php?modal=error');
            exit();
        }

        $resultado = $usuario->eliminarPorCorreo($correo);

        if ($resultado == true) {
            header('Location: ../Vistas/controlAdmin.php');
            exit();
        } else {
            echo 'Error en la solicitud de eliminación';
            header('Location: ../Vistas/eliminarUsuario.php?modal=error');
            exit();
        }
    }
?>
