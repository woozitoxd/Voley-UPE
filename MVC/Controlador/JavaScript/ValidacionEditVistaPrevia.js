function edicionVistaPrevia() {
    document.getElementById("editForm").addEventListener("submit", enviarFormulario);

}

function enviarFormulario(event) {

    if (validarFormulario()) {
        console.log('El formulario se envió de manera exitosa');
    } else {
        console.log('Error');
        event.preventDefault();
    }
}

function validarFormulario() {

    let mensajeIdNoticiaVistaPrevia = document.getElementById("idNoticiaVistaPrevia");
    mensajeIdNoticiaVistaPrevia.classList.remove("is-invalid");

    let mensajeTituloVistaPrevia = document.getElementById("TituloVistaPrevia");
    mensajeTituloVistaPrevia.classList.remove("is-invalid");

    let mensajeTextoVistaPrevia = document.getElementById("textoVistaPrevia");
    mensajeTextoVistaPrevia.classList.remove("is-invalid");

    let mensajeFoto1 = document.getElementById("foto1");
    mensajeFoto1.classList.remove("is-invalid");

    let inputIdNoticiaVistaPrevia = mensajeIdNoticiaVistaPrevia.value;
    let inputTituloVistaPrevia = mensajeTituloVistaPrevia.value;
    let inputTextoVistaPrevia = mensajeTextoVistaPrevia.value;
    let inputFoto1 = mensajeFoto1.value;

    // Validación del campo de selección
    if (inputIdNoticiaVistaPrevia === '') {
        mensajeIdNoticiaVistaPrevia.classList.add("is-invalid");
        console.log('Seleccione una vista previa válida.');
        return false;
    }

    // Validación del título
    if (inputTituloVistaPrevia === '' || inputTituloVistaPrevia.length < 5 || inputTituloVistaPrevia.length > 40) {
        mensajeTituloVistaPrevia.classList.add("is-invalid");
        console.log('Título inválido.');
        return false;
    }

    // Validación de la descripción
    if (inputTextoVistaPrevia === '' || inputTextoVistaPrevia.length < 40 || inputTextoVistaPrevia.length > 120) {
        mensajeTextoVistaPrevia.classList.add("is-invalid");
        console.log('Descripción inválida.');
        return false;
    }

    // Validación de la foto
    if (inputFoto1 === '') {
        mensajeFoto1.classList.add("is-invalid");
        console.log('Seleccione una foto válida.');
        return false;
    }
    
    return true;
}

window.onload = edicionVistaPrevia;