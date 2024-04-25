var FormLiga

function inicio() {
     FormLiga=document.getElementById('EditarLigaForm').addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (ValidarNombreViejo() && ValidarNombreNuevo()) {
        limpiarForm();
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function ValidarNombreViejo() {
    
    var mensajeLigaNombreViejo = document.getElementById('nombreViejo');
    mensajeLigaNombreViejo.classList.remove("is-invalid");

    var NombreLigaVieja = document.getElementById('nombreViejo').value;
    // Validar que el campo no esté vacío
    if (NombreLigaVieja.trim() === "") {
        console.log('Debes ingresar un nombre.');
        mensajeLigaNombreViejo.classList.add("is-invalid");
        return false;
    }
    // Validar el formato del nombre
    var regex = /^[A-Za-z]+\s[A-Za-z0-9]+$/;
    if (!regex.test(NombreLigaVieja)) {
        console.log('Formato de nombre de liga inválido.');
        mensajeLigaNombreViejo.classList.add("is-invalid");
        return false;
    }
    // Validar la cantidad de palabras
    var palabra = NombreLigaVieja.split(/\s+/);
    if (palabra.length !== 2) {
        console.log('Debes ingresar un nombre con exactamente un espacio.');
        mensajeLigaNombreViejo.classList.add("is-invalid");
        return false;
    }if(!Contiene4Caracteres(NombreLigaVieja)){
        mensajeLigaNombreViejo.add("is-invalid");                             //minimo 4 caracteres
        return false;
    }
    return true;
}

function Contiene4Caracteres(NombreLigaVieja) {
    let Caracteres = NombreLigaVieja.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}

function ValidarNombreNuevo() {
    
    var mensajeLigaNombreNuevo = document.getElementById('nombreNuevo');
    mensajeLigaNombreNuevo.classList.remove("is-invalid");

    var LigaNombreNuevo = document.getElementById('nombreNuevo').value;
    // Validar que el campo no esté vacío
    if ( LigaNombreNuevo.trim() === "") {
        console.log('Debes ingresar un nombre.');
        mensajeLigaNombreNuevo.classList.add("is-invalid");
        return false;
    }
    // Validar el formato del nombre
    var regex = /^[A-Za-z]+\s[A-Za-z0-9]+$/;
    if (!regex.test(LigaNombreNuevo)) {
        console.log('Formato de nombre de liga inválido.');
        mensajeLigaNombreNuevo.classList.add("is-invalid");
        return false;
    }
    // Validar la cantidad de palabras
    var palabra = LigaNombreNuevo.split(/\s+/);
    if (palabra.length !== 2) {
        console.log('Debes ingresar un nombre con exactamente un espacio.');
        mensajeLigaNombreNuevo.classList.add("is-invalid");
        return false;
    }if(!Contiene4Caracteres(LigaNombreNuevo)){
        mensajeLigaNombreNuevo.add("is-invalid");                      
        return false;
    }
    return true;
}

function Contiene4Caracteres(LigaNombreNuevo) {
    let Caracteres = LigaNombreNuevo.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}

window.onload = inicio;