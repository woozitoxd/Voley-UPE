<?php
    include_once ('../Modelo/liga.php');

    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : '';
        if (empty($_POST["nombre"])) {
            echo "Debes completar todos los campos para eliminar la liga de forma exitosa";
            exit();
        }
         
        $ligaParaEliminar = new liga("","");
        $ValidarLiga=$ligaParaEliminar->ValidarNombreliga($nombre);
        $VerificarLiga=$ligaParaEliminar->verificarNombreLiga($nombre);
        
        if(!$VerificarLiga){
            echo'Verificacion Liga fallo';
            exit();

        }else if(!$ValidarLiga){
            echo'Validacion liga fallo';

        }else if($ValidarLiga && $VerificarLiga){
            $resultado = $ligaParaEliminar->eliminarLiga($nombre);
            if($resultado == true)
            {
                header('Location: ../Vistas/controlAdmin.php');
                exit();
            }
        } else{
            echo'error';
            exit();
        }
    }
?>