$(document).ready(function() {
    cargarEquipos();
    cargarUbicacion();
    cargarPartido();

    function cargarEquipos() {
        $.ajax({
          url: '../controlador/obtenerEquipos.php',
          method: 'POST',
          success: function(data) {
            $('#Equipo1AgregarJugado').html(data); //agregarJugador

            $('#PartidoEquipo1').html(data); //AgregarPartido
            $('#PartidoEquipo2').html(data);

            // Vistas/editarJugador
            $('#id_equipoViejo').html(data);
            $('#NuevoEquipoJugador').html(data);

            $('#equipo1').html(data);//EditarPartido
            $('#equipo2Editar').html(data);
            $('#equipo2Nuevo').html(data);
            $('#equipo1Nuevo').html(data); 

            $('#id_equipoBuscar').html(data); //controlAdmin BuscarJugador
            $('#EliminarEquipo1').html(data); // control admin EliminarPartido
            $('#EliminarEquipo2').html(data);
            
          }
        });
    }
      
    function cargarUbicacion() {
        $.ajax({
          url: '../controlador/ObtenerUbicacion.php',
          method: 'POST',
          success: function(data) {
            $('#ubicacionPartido').html(data); //AgregarPartido
            $('#ubicacionNueva').html(data); //EditarPartido
          }
        });
    }

    function cargarPartido(){
        $.ajax({
            url: '../controlador/obtenerPartidos.php',
            method: 'POST',
            success: function(data) {
              $('#PartidosContainer').html(data); 
            }
        });
    }

});
