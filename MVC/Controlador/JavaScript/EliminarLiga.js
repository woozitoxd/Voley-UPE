var FormLiga

function inicio() {
     FormLiga=document.getElementById('EliminarLigaForm').addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (Validar()) {
        limpiarForm();
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function Validar() {
    
    var mensajeLigaNombre = document.getElementById('nombre');
    mensajeLigaNombre.classList.remove("is-invalid");

    var NombreLiga = document.getElementById('nombre').value;
    
    if (NombreLiga.trim() === "") {
        console.log('Debes ingresar un nombre.');
        mensajeLigaNombre.classList.add("is-invalid");
        return false;
    }
   
    var regex = /^[A-Za-z]+\s[A-Za-z0-9]+$/;
    if (!regex.test(NombreLiga)) {
        console.log('Formato de nombre de liga inválido.');
        mensajeLigaNombre.classList.add("is-invalid");
        return false;
    }
    // Validar la cantidad de palabras
    var palabra = NombreLiga.split(/\s+/);
    if (palabra.length !== 2) {
        console.log('Debes ingresar un nombre con exactamente un espacio.');
        mensajeLigaNombre.classList.add("is-invalid");
        return false;
    }if(!Contiene4Caracteres(NombreLiga)){
        mensajeLigaNombre.add("is-invalid");                             //minimo 4 caracteres
        return false;
    }
    return true;
}

function Contiene4Caracteres(NombreLiga) {
    let Caracteres = NombreLiga.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}


window.onload = inicio;