function inicio() {
    var FormLiga=document.getElementById('CrearLigaForm').addEventListener('submit', sendForm);
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
    
    var mensajeLiga = document.getElementById('NombreLiga');
    mensajeLiga.classList.remove("is-invalid");

    var NombreLigaNueva = document.getElementById('NombreLiga').value;
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

window.onload = inicio;