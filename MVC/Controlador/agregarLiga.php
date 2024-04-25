<?php
    include_once ('../Modelo/liga.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $nombre = isset($_POST["liga"]) ? $_POST["liga"] : NULL;
        if (empty($nombre)) {
            echo "Error: Complete el nombre del equuipo.";
            exit();
        }

        $objliga = new liga("",$nombre);
        $ResultadoLiga=$objliga->ValidarNombreliga($nombre);
        $VerificarExisteLiga=$objliga->verificarNombreLiga($nombre);
        if($ResultadoLiga && !$VerificarExisteLiga){
            $resultado = $objliga->registrarliga();
            if ($resultado == true)
            {
                header('Location: ../Vistas/controlAdmin.php');
                exit();
            }else{
                echo'error en la qry';
            }

        } else{
            header('Location: ../Vistas/crearLiga.html');
        }
    }
?>
