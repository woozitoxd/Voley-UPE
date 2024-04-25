function agregarVistaPrevia() {
    console.log('Hola');
    document.getElementById("VistaPreviaForm").addEventListener("submit", sendForm);
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

    let mensajeTitulo = document.getElementById("nuevo_titulo");
    mensajeTitulo.classList.remove("is-invalid");
  
    let mensajeDescripcion = document.getElementById("nuevo_texto");
    mensajeDescripcion.classList.remove("is-invalid");
  
    let mensajeFoto1 = document.getElementById("PathFoto1");
    mensajeFoto1.classList.remove("is-invalid");

    let inputTitulo = mensajeTitulo.value;
    let inputDescripcion = mensajeDescripcion.value;
    let inputFoto1 = mensajeFoto1.value;

    // Validación del título
    if (inputTitulo === '' || inputTitulo.length < 5 || inputTitulo.length > 40) {
        mensajeTitulo.classList.add("is-invalid");
        console.log('Titulo inválido');
        return false;
    }

    // Validación de la descripción
    if (inputDescripcion === '' || inputDescripcion.length < 20 || inputDescripcion.length > 120) {
        mensajeDescripcion.classList.add("is-invalid");
        console.log('Descripción inválida');
        return false;
    }

    // Validación de las fotos
    if (inputFoto1 === '' ) {
        mensajeFoto1.classList.add("is-invalid");
        console.log('Fotos inválidas');
        return false;
    }

    return true;
}

window.onload = agregarVistaPrevia;