$(document).ready(function(){

    // Obtener parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const modalParam = urlParams.get('modal');

    // Activar el modal si el parámetro es 'success'
    if(modalParam === 'exito') {
        $('#solicitudExitosa').modal('show');
    }
    if(modalParam === 'error') {
        $('#errorModal').modal('show');
        $('#ErrorPartido').modal('show');
    }
    
});
