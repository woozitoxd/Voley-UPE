window.onload = function () {
    // Agrega un evento de clic al botón "Eliminar Comentario"
    var eliminarComentarioBtns = document.querySelectorAll('.eliminar-comentario');

    eliminarComentarioBtns.forEach(function (btn) {
        btn.addEventListener("click", function () {
            // Obtén el ID del comentario desde el atributo data-comentario-id
            var comentarioId = this.getAttribute('data-comentario-id');

            // Actualiza el valor del campo oculto
            document.getElementById('comentarioIdEliminar').value = comentarioId;

            // Muestra el modal de confirmación
            /*var modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminar'));
            modalEliminar.show();*/
        });
    });

    // Agrega un evento de clic al botón "Eliminar" en el modal
    var eliminarBtn = document.getElementById("eliminarBtn");

    if (eliminarBtn) {
        eliminarBtn.addEventListener("click", function () {
            // Obtén el ID del comentario desde el campo oculto
            var comentarioId = document.getElementById('comentarioIdEliminar').value;
            console.log(comentarioId);
            // Redirige a tu archivo PHP de eliminación con el ID del comentario
            window.location.href = '../controlador/CON_EliminarComentario.php?comentarioId=' + comentarioId;
        });
    }
}