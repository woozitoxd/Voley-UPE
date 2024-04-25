var FormJugador;

function inicio(){
    FormJugador = document.getElementById('EditarJugadorForm');
    FormJugador.addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (ValidarNombre() && ValidarApellido() && ValidarNombreViejo() && ValidarApellidoViejo()) {
        limpiarForm();
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function ValidarNombreViejo(){

    let mensajeNombreViejo = document.getElementById("nombreJugadorViejo");
    mensajeNombreViejo.classList.remove("is-invalid");

    let nombreJugadorViejo = document.getElementById("nombreJugadorViejo");
    let JugadorNombreViejo = nombreJugador.value.trim();

    let mensajeEdadVieja = document.getElementById("edadViejaJugador");
    mensajeEdadVieja.classList.remove("is-invalid");

    let edadJugadorVieja = document.getElementById("edadViejaJugador");
    let JugadoredadViejo = edadJugadorVieja.value.trim();

            //Validaciones Nombre
    if (esCampoVacio(JugadorNombreViejo)) {
        console.log('Debes ingresar un nombre.');
        mensajeNombreViejo.classList.add("is-invalid");      //Nombre vacio
        return false;
    }
    if (!esUnicoNombre(JugadorNombreViejo)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');  //que sea una sola palabra
        mensajeNombreViejo.classList.add("is-invalid");
        return false;
    }
    if (!contieneSoloLetras(JugadorNombreViejo)) {
        mensajeNombreViejo.classList.add("is-invalid");                              //Solamente letras
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene3Caracteres(JugadorNombreViejo)){
        mensajeNombreViejo.classList.add("is-invalid");                             //minimo 3 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!EdadPermitida(JugadoredadViejo)){
        mensajeEdadVieja.classList.add("is-invalid");                             //minimo 3 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
   return true;
}

function esCampoVacio(JugadorNombre) {
    return JugadorNombre === "";
}

function esUnicoNombre(JugadorNombre) {
    let palabra = JugadorNombre.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(JugadorNombre) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(JugadorNombre);
}

function Contiene3Caracteres(JugadorNombre) {
    let Caracteres = JugadorNombre.trim().split(/\s+/);
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
//-----_-------------------_------------------_------------------_
function ValidarApellidoViejo(){
    let mensajeApellidoViejo = document.getElementById("apellidoJugadorViejo");
    mensajeApellidoViejo.classList.remove("is-invalid");
    
    let ApellidoJugadorViejo = document.getElementById("apellidoJugadorViejo");
    let JugadorApellidoViejo = ApellidoJugadorViejo.value.trim();

            //Validaciones 
    if (esCampoVacio(JugadorApellidoViejo)) {
        console.log('Debes ingresar un nombre.');
        mensajeApellidoViejo.classList.add("is-invalid");      //Nombre vacio
        return false;
    }
    if (!esUnicoNombre(JugadorApellidoViejo)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');  //que sea una sola palabra
        mensajeApellidoViejo.classList.add("is-invalid");
        return false;
    }
    if (!contieneSoloLetras(JugadorApellidoViejo)) {
        mensajeApellidoViejo.classList.add("is-invalid");                              //Solamente letras
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene4Caracteres(JugadorApellidoViejo)){
        mensajeApellidoViejo.classList.add("is-invalid");                             //minimo 4 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    
    return true;
}

function esCampoVacio(JugadorApellidoViejo) {
    return JugadorApellidoViejo === "";
}

function esUnicoNombre(JugadorApellidoViejo) {
    let palabra = JugadorApellidoViejo.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(JugadorApellidoViejo) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(JugadorApellidoViejo);
}

function Contiene4Caracteres(JugadorApellidoViejo) {
    let Caracteres = JugadorApellidoViejo.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 4;
    }
    return false;
}

function ValidarNombre() {

    let mensajeNombre = document.getElementById("nombreNuevoJugador");
    mensajeNombre.classList.remove("is-invalid");

    let nombreJugador = document.getElementById("nombreNuevoJugador");
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

function esCampoVacio(JugadorNombre) {
    return JugadorNombre === "";
}

function esUnicoNombre(JugadorNombre) {
    let palabra = JugadorNombre.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(JugadorNombre) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(JugadorNombre);
}

function Contiene3Caracteres(JugadorNombre) {
    let Caracteres = JugadorNombre.trim().split(/\s+/);
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