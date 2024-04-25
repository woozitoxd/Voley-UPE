function inicio(){
    var FormAgregarEquipo=document.getElementById('crearEquipo').addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (Validar()) {
        limpiarForm();
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function limpiarForm() {
    FormAgregarEquipo.reset();
} 


function Validar() {

    let mensajeNombre = document.getElementById("nombre");
    mensajeNombre.classList.remove("is-invalid");

    let nombreEquipo = document.getElementById("nombre");
    let EquipoNombre = nombreEquipo.value.trim();

    if (esCampoVacio(EquipoNombre)) {
        console.log('Debes ingresar un nombre.');
        mensajeNombre.classList.add("is-invalid");
        return false;
    }

    if (!esUnicoNombre(EquipoNombre)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');
        mensajeNombre.classList.add("is-invalid");
        return false;
    }

    if (!contieneSoloLetras(EquipoNombre)) {
        mensajeNombre.classList.add("is-invalid");
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene4Caracteres(EquipoNombre)){
        mensajeNombre.classList.add("is-invalid");
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;

    }
    return true;
}

function esCampoVacio(EquipoNombre) {
    return EquipoNombre === "";
}

function esUnicoNombre(EquipoNombre) {
    let palabra = EquipoNombre.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(EquipoNombre) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(EquipoNombre);
}

function Contiene4Caracteres(EquipoNombre) {
    let Caracteres = EquipoNombre.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}


window.onload = inicio;