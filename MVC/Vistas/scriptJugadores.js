$(document).ready(function() {
  // Cargar opciones de equipos al inicio
  cargarEquipos();

  // Adjuntar evento al cambio de equipo
  $('#equipos').change(function() {
    var equipoSeleccionado = $(this).val();
    cargarJugadores(equipoSeleccionado);
  });

  function cargarEquipos() {
    $.ajax({
      url: '../controlador/obtenerEquipos.php',
      method: 'POST',
      success: function(data) {
        $('#equipos').html(data);
        
        // Cargar jugadores para el primer equipo (si hay opciones)
        var equipoSeleccionado = $('#equipos').val();
        if (equipoSeleccionado) {
          cargarJugadores(equipoSeleccionado);
        }
      }
    });
  }

  function cargarJugadores(equipoId) {
    $.ajax({
      url: '../controlador/obtenerJugadores.php',
      method: 'POST',
      data: { equipoId: equipoId },
      success: function(data) {
        $('#jugadoresContainer').html(data);
      }
    });
  }
});