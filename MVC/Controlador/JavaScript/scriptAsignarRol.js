function asignarRol() {
    document.getElementById("asignarRolForm").addEventListener("submit", sendForm);
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

    let mensajeUsuario = document.getElementById("idUsuario");
    mensajeUsuario.classList.remove("is-invalid");

    let mensajeRol = document.getElementById("idRol");
    mensajeRol.classList.remove("is-invalid");
  

    let selectUsuario = mensajeUsuario.value;
    let selectRol = mensajeRol.value;

    // Validación de las fotos
    if (selectUsuario === '' ) {
        mensajeUsuario.classList.add("is-invalid");
        console.log('No selecciono un usuario existente');
        return false;
    }

    if (selectRol === '' ) {
        mensajeRol.classList.add("is-invalid");
        console.log('No selecciono un rol existente');
        return false;
    }
    return true;
}

window.onload = asignarRol;