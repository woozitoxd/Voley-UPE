<?php
    include_once ('../Modelo/equipo.php');

    if($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nombre =  isset($_POST["nombre"]) ? $_POST["nombre"] : Null;
        if (empty($nombre)) {
            echo "Error: Complete el nombre del equipo.";
            exit();
        }
        
        $equipo = new equipo($nombre,0,1);
        $EquipoExistente=$equipo->verificarNombreEquipo($nombre);
        $ValidarNombre=$equipo->ValidarNombre($nombre);

        if(!$ValidarNombre){
            header('Location: ../Vistas/agregarEquipo.php');
            exit();
        }
        if($ValidarNombre && $EquipoExistente){
            $EquipoNuevo=$equipo->registrar();
            if($EquipoNuevo){
                header('Location:../Vistas/controlAdmin.php');
                exit();
            }
        }else{
            echo "Error en la carga";
        }
    }
?>
