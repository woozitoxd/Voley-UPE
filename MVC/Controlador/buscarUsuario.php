<?php
   include_once ('../Modelo/Usuario.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $correo = isset($_POST["email"]) ? $_POST["email"]: NULL ;
        if (empty($correo)) {
            echo "Error: Complete el correo para poder buscar al usuario.";
            exit();
        }
        $usuario = new Usuario("", "","","","");
        $resultado = $usuario->buscarusuario($correo);
        var_dump($resultado);
           
       if($resultado){
            session_start();
            $_SESSION['UsuarioEncontrado'] = $resultado;
            header('Location: ../Vistas/usuarioEncontrado.php');
            exit();     
        }else{
            echo "Error: No se encontró un jugador con los datos proporcionados.";
            header('Location: ../Vistas/buscarUsuario.php?modal=error');
            exit(); 
       };
    }
?>