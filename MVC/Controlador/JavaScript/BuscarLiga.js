var FormBuscar

function inicio() {
    FormBuscar=document.getElementById('BuscarLigaForm').addEventListener('submit', sendForm);
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
    FormLiga.reset();
} 

function Validar() {
    
    var mensajeLiga = document.getElementById('nombre');
    mensajeLiga.classList.remove("is-invalid");

    var NombreLigaNueva = document.getElementById('nombre').value;
    // Validar que el campo no esté vacío
    if (NombreLigaNueva.trim() === "") {
        console.log('Debes ingresar un nombre.');
        mensajeLiga.classList.add("is-invalid");
        return false;
    }

    // Validar el formato del nombre
    var regex = /^[A-Za-z]+\s[A-Za-z0-9]+$/;
    if (!regex.test(NombreLigaNueva)) {
        console.log('Formato de nombre de liga inválido.');
        mensajeLiga.classList.add("is-invalid");
        return false;
    }if(!Contiene4Caracteres(NombreLigaNueva)){
        mensajeApellido.classList.add("is-invalid");                             //minimo 4 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    // Validar la cantidad de palabras
    var palabra = NombreLigaNueva.split(/\s+/);
    if (palabra.length !== 2) {
        console.log('Debes ingresar un nombre con exactamente un espacio.');
        mensajeLiga.classList.add("is-invalid");
        return false;
    }
    return true;
}
function Contiene4Caracteres(NombreLigaNueva) {
    let Caracteres = NombreLigaNueva.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}
window.onload = inicio;