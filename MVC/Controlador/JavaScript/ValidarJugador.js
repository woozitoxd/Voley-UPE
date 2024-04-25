var FormJugador;

function inicio(){
    FormJugador = document.getElementById('AgregarJugadorForm');
    FormJugador.addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (ValidarNombre() && ValidarApellido()) {
        limpiarForm();
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function limpiarForm() {
    FormJugador.reset();
} 

function ValidarNombre() {

    let mensajeNombre = document.getElementById("nombreJugador");
    mensajeNombre.classList.remove("is-invalid");

    let nombreJugador = document.getElementById("nombreJugador");
    let JugadorNombre = nombreJugador.value.trim();

    let mensajeEdad = document.getElementById("edad");
    mensajeEdad.classList.remove("is-invalid");

    let edadJugador = document.getElementById("edad");
    let Jugadoredad = edadJugador.value.trim();

            //Validaciones Nombre
    if (esCampoVacio(JugadorNombre)) {
        console.log('Debes ingresar un nombre.');
        mensajeNombre.classList.add("is-invalid");      //Nombre vacio
        return false;
    }
    if (!esUnicoNombre(JugadorNombre)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');  //que sea una sola palabra
        mensajeNombre.classList.add("is-invalid");
        return false;
    }
    if (!contieneSoloLetras(JugadorNombre)) {
        mensajeNombre.classList.add("is-invalid");                              //Solamente letras
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene3Caracteres(JugadorNombre)){
        mensajeNombre.classList.add("is-invalid");                             //minimo 3 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!EdadPermitida(Jugadoredad)){
        mensajeEdad.classList.add("is-invalid");                             //minimo 3 caracteres
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

function Contiene3Caracteres(EquipoNombre) {
    let Caracteres = EquipoNombre.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 3;
    }
    return false;
}
function EdadPermitida(Jugadoredad ){
    if (Jugadoredad  < 17 || Jugadoredad  > 50) {
        return false;
    }
    return true; 
}

//////////////////////////////////////////////////// Validar Apellido

function ValidarApellido() {

    let mensajeApellido = document.getElementById("apellido");
    mensajeApellido.classList.remove("is-invalid");
    
    let ApellidoJugador = document.getElementById("apellido");
    let JugadorApellido = ApellidoJugador.value.trim();

    let mensajeAltura = document.getElementById("altura");
    mensajeAltura.classList.remove("is-invalid");
    let valorAltura = parseFloat(document.getElementById("altura").value);


            //Validaciones 
    if (esCampoVacio(JugadorApellido)) {
        console.log('Debes ingresar un nombre.');
        mensajeApellido.classList.add("is-invalid");      //Nombre vacio
        return false;
    }
    if (!esUnicoNombre(JugadorApellido)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');  //que sea una sola palabra
        mensajeApellido.classList.add("is-invalid");
        return false;
    }
    if (!contieneSoloLetras(JugadorApellido)) {
        mensajeApellido.classList.add("is-invalid");                              //Solamente letras
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene4Caracteres(JugadorApellido)){
        mensajeApellido.classList.add("is-invalid");                             //minimo 4 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!validarAltura(valorAltura)){
        mensajeAltura.classList.add("is-invalid");
        console.log('La altura debe ser un número válido y menor a 3 metros.');
        return false;
    }
    return true;
}

function esCampoVacio(JugadorApellido) {
    return JugadorApellido === "";
}

function esUnicoNombre(JugadorApellido) {
    let palabra = JugadorApellido.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(JugadorApellido) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(JugadorApellido);
}

function Contiene3Caracteres(JugadorApellido) {
    let Caracteres = JugadorApellido.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}

function validarAltura(valorAltura) {
    if (isNaN(valorAltura) || valorAltura < 0 || valorAltura >= 300) {
        return false;
    }
    return true;
}

window.onload = inicio;