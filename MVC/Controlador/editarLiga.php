<?php
   include_once('../Modelo/liga.php');
   session_start();

   $buscarLiga = $_SESSION['LigaEncontrada'];
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = isset($_POST["NombreLiga"]) ? $_POST['NombreLiga'] : null;
        $NombreViejo = isset($_POST['NombreLiga2']) ? $_POST['NombreLiga2'] : null;
       
        $NuevaLiga = new liga("","");
        $ligaVieja=new liga("","");
       
        if (empty($nombre) || empty($NombreViejo)) {
           echo "Debes completar el nombre de la liga para actualizar.";
           exit();
        }

        $ValidarNombreLigaVieja=$ligaVieja->ValidarNombreliga($NombreViejo);
        $ValidarNombreLigaNueva=$NuevaLiga->ValidarNombreliga($nombre);
        $id=$ligaVieja->ConseguirID($NombreViejo);
        
        if($ValidarNombreLigaVieja && $ValidarNombreLigaNueva && $id){
            if ($NuevaLiga->editar($id,$nombre) === 'Liga actualizada con éxito.') 
            {
                header('Location: ../Vistas/EditarLiga.php?modal=exito');
            }

        }else {
            echo "Error: No se encontró un jugador con los datos proporcionados.";
            header('Location: ../Vistas/EditarLiga.php?modal=error');
       }
   }
?>