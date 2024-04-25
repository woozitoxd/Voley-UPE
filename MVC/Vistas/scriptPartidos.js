$(document).ready(function() {

      $.ajax({
        url: '../controlador/obtenerPartidos.php',
        method: 'POST',
        success: function(data) {
          $('#PartidosContainer').html(data); 
        }
      });
    });


   