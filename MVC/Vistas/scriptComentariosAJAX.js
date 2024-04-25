window.onload = function () {
    let url = '../controlador/ObtenerComentarios.php';
    fetch(url)
        .then(function (response) {
            if (!response.ok) {
                throw new Error('Error en la llamada a la API. Estado: ' + response.status);
            }
            return response.json();
        })
        .then(function (comentariosxd) {
            let listaComentarios = document.querySelector("#lista-comentarios");

            if (comentariosxd.length === 0) {
                console.log('No se encontraron comentarios.');
                return;
            }

            comentariosxd.forEach(function (coment) {
                let articulo = document.createElement("li");

                let nombreElemento = document.createElement("strong");
                nombreElemento.innerText = coment.nombre;

                let fechaElemento = document.createElement("p");
                fechaElemento.innerText = coment.fechaPublicacion + ': ';

                let descripcionElemento = document.createElement("span");
                descripcionElemento.innerHTML = coment.Comentario + ' ';

                let denunciaButton = document.createElement("button");
                denunciaButton.type = "button";
                denunciaButton.className = "btn btn-sm btn-outline-danger";
                denunciaButton.name = "report";
                
                // icono de Font Awesome xd
                let icon = document.createElement("i");
                icon.className = "fas fa-flag"; //Icono de bandera
                
                denunciaButton.appendChild(icon);
                denunciaButton.setAttribute("data-comentario-id", coment.idComentario);

                articulo.appendChild(nombreElemento);
                articulo.appendChild(fechaElemento);
                articulo.appendChild(descripcionElemento);
                articulo.appendChild(denunciaButton);

                listaComentarios.appendChild(articulo);

                // Agregar evento al botón de denuncia
                denunciaButton.addEventListener("click", function () {
                    let comentarioId = this.getAttribute("data-comentario-id");
                    console.log(comentarioId);
                    cargarRazonesDenuncia(comentarioId);
                });
            });
        })
        .catch(function (error) {
            console.error('Error en la llamada AJAX:', error);
        });

        function cargarRazonesDenuncia(comentarioId) {
            // Lógica para obtener razones desde la base de datos (usando AJAX)
            fetch('../controlador/CON_ObtenerRazones.php')
                .then(response => response.json())
                .then(razones => {
                    console.log('Razones:', razones);
        
                    let listaRazones = document.getElementById('listaRazones');
                    listaRazones.innerHTML = '';
                    // Agregar razones al modal
                    razones.forEach(razon => {
                        let option = document.createElement('option');
                        option.value = razon.idRazon;
                        option.text = razon.descripcion;
                        listaRazones.appendChild(option);
                    });
        
                    // Establecer el valor del campo oculto comentarioId
                    document.getElementById('comentarioId').value = comentarioId;
        
                    // Mostrar el modal
                    $('#modalDenuncia').modal('show');
                })
                .catch(error => console.error('Error obteniendo razones de denuncia:', error));
        }
}


