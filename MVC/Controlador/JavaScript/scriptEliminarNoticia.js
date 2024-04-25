function eliminarNoticia() {
    document.getElementById("EliminarNoticiaForm").addEventListener("submit", sendForm);
}

function sendForm(event) {
    if (validarFormulario()) {
        console.log('El formulario se envió de manera exitosa');
    } else {
        console.log('Error');
        event.preventDefault();
    }
}

function validarFormulario() {

    let mensajeNoticia = document.getElementById("idNoticia");
    mensajeNoticia.classList.remove("is-invalid");
  

    let selectNoticia = mensajeNoticia.value;

    // Validación de las fotos
    if (selectNoticia === '' ) {
        mensajeNoticia.classList.add("is-invalid");
        console.log('No selecciono una noticia existente');
        return false;
    }

    return true;
}

window.onload = eliminarNoticia;