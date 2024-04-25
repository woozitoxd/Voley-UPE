function edicionNoticia() {
    document.getElementById("edicionForm").addEventListener("submit", sendForm);
}

function sendForm(event) {
    if (validarFormulario()) {
        console.log('El formulario se envió de manera exitosa');
    } else {
        console.log('Error al enviar el formulario.');
        event.preventDefault();
    }
}

function validarFormulario() {

    let mensajeSelect = document.getElementById("idNoticia");
    mensajeSelect.classList.remove("is-invalid");

    let mensajeTitulo = document.getElementById("nuevo_titulo");
    mensajeTitulo.classList.remove("is-invalid");
  
    let mensajeDescripcion = document.getElementById("nuevo_texto");
    mensajeDescripcion.classList.remove("is-invalid");
  
    let mensajeFoto1 = document.getElementById("PathFoto1");
    mensajeFoto1.classList.remove("is-invalid");

    let mensajeFoto2 = document.getElementById("PathFoto2");
    mensajeFoto2.classList.remove("is-invalid");

    let inputSelect = mensajeSelect.value;
    let inputTitulo = mensajeTitulo.value;
    let inputDescripcion = mensajeDescripcion.value;
    let inputFoto1 = mensajeFoto1.value;
    let inputFoto2 = mensajeFoto2.value;
    
    if ( inputSelect === ''){
        mensajeSelect.classList.add("is-invalid");
        console.log("No selecciono una noticia para editar");
        return false;
    }

    // Validación del título
    if (inputTitulo === '' || inputTitulo.length < 5 || inputTitulo.length > 40) {
        mensajeTitulo.classList.add("is-invalid");
        console.log('Titulo inválido');
        return false;
    }

    // Validación de la descripción
    if (inputDescripcion === '' || inputDescripcion.length < 120 || inputDescripcion.length > 1000) {
        mensajeDescripcion.classList.add("is-invalid");
        console.log('Descripción inválida');
        return false;
    }

    // Validación de las fotos
    if (inputFoto1 === '' || inputFoto2 === '') {
        mensajeFoto1.classList.add("is-invalid");
        mensajeFoto2.classList.add("is-invalid");
        console.log('Fotos inválidas');
        return false;
    }

    return true;
}

window.onload = edicionNoticia;