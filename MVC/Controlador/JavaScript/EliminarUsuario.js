var FormUsuario;

function inicio(){
    FormUsuario = document.getElementById('EliminarUsuarioForm');
    FormUsuario.addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (Validar()) {
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function Validar() {
    let mensajeCorreo = document.getElementById("email");
    mensajeCorreo.classList.remove("is-invalid");

    let CorreoUsuario = document.getElementById("email").value;
    let regularMail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    let contieneSoloNumeros = /^\d+$/;

    // Validaciones Correo
    
    if (!regularMail.test(CorreoUsuario)) {
        mensajeCorreo.classList.add("is-invalid");
        return false;
    }
    if (esCampoVacio(CorreoUsuario)) {
        mensajeCorreo.classList.add("is-invalid");
        console.log('Debes ingresar un correo.');
        return false;
    }
    if (contieneSoloNumeros.test(CorreoUsuario)) {
        mensajeCorreo.classList.add("is-invalid");
        console.log('El correo no puede consistir solo en números.');
        return false;
    }
    return true;
}

function esCampoVacio(CorreoUsuario) {
    return CorreoUsuario === "";
}

window.onload = inicio;
