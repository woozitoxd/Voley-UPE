var FormUsuario;

function inicio(){
    document.getElementById('EditarUsuarioForm').addEventListener('submit', sendForm);
}

function sendForm(event) {
    if (Validar()) {
        console.log('el formulario se envio de manera exitosa');
      }else{
        event.preventDefault();
      }
}

function Validar() {

//mensajes
    let mensajeNombre = document.getElementById("nombre");
    mensajeNombre.classList.remove("is-invalid");

    let mensajeCorreo = document.getElementById("email_registrol");
    mensajeCorreo.classList.remove("is-invalid");

    let mensajeCorreoViejo = document.getElementById("emailViejo");
    mensajeCorreoViejo.classList.remove("is-invalid");

    let mensajeFecha = document.getElementById("fecha_edad");
    mensajeFecha.classList.remove("is-invalid");

// vbles para LOS MAILS
    let regularMail = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
    let contieneSoloNumeros = /^\d+$/;

//Validar mail Viejo
    let mailViejo = document.getElementById("emailViejo").value;
    if (esCampoVacio(mailViejo)) {
        console.log('Debes ingresar un nombre.');
        mensajeCorreoViejo.classList.add("is-invalid");      //Nombre vacio
        return false;
    }if(!regularMail.test(mailViejo)){
        mensajeCorreoViejo.classList.add("is-invalid");      
        return false;
    } if(contieneSoloNumeros.test(mailViejo)) {
        mensajeCorreoViejo.classList.add("is-invalid");
        console.log('El correo no puede consistir solo en números.');
        return false;
    }
// Valido EL NOMBRE del ususario
    let nombreUsuario = document.getElementById("nombre");
    let NombreUsuario = nombreUsuario.value.trim();
    if (esCampoVacio(NombreUsuario)) {
        console.log('Debes ingresar un nombre.');
        mensajeNombre.classList.add("is-invalid");      //Nombre vacio
        return false;
    }if (!esUnicoNombre(NombreUsuario)) {
        console.log('Debes ingresar un único nombre de usuario, sin espacios.');  //que sea una sola palabra
        mensajeNombre.classList.add("is-invalid");
        return false;
    }
    if (!contieneSoloLetras(NombreUsuario)) {
        mensajeNombre.classList.add("is-invalid");                              //Solamente letras
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }
    if(!Contiene3Caracteres(NombreUsuario)){
        mensajeNombre.classList.add("is-invalid");                             //minimo 3 caracteres
        console.log('Los caracteres ingresados en nombre no son letras.');
        return false;
    }

// Valido el MAIL NUEVO
  let mailNuevo = document.getElementById("email").value;
  if (esCampoVacio(mailNuevo)) {
        console.log('Debes ingresar un MAIL.');
        mensajeCorreo.classList.add("is-invalid");      
        return false;
    }if(!regularMail.test(mailNuevo)){
        mensajeCorreo.classList.add("is-invalid");      
        return false;
    } if (contieneSoloNumeros.test(mailNuevo)) {
        mensajeCorreo.classList.add("is-invalid");
        console.log('El correo no puede consistir solo en números.');
        return false;
    }

// VAlido LA FECHA DE NACIMIENTO 
  let fechaNacimiento = new Date(document.getElementById('fecha_edad').value);
  let fechaActual = new Date();
  let diferencia = fechaActual - fechaNacimiento; 
  let edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25));
   
  if (esCampoVacio(fechaNacimiento)) {
        console.log('Debes ingresar una fecha.');
        mensajeFecha.classList.add("is-invalid");      
        return false;
    }if (edad < 16 || edad > 100) {
        mensajeFecha.classList.add("is-invalid"); 
        console.log('Para registrarte en la pagina de VOLEY UPE debes tener almenos 16 años');
        return false;
    }
   return true;
}

if (esCampoVacio(mailViejo)) {
    return mailViejo === "";
}
function esCampoVacio(NombreUsuario) {
    return NombreUsuario === "";
}

function esCampoVacio(fechaNacimiento) {
    return fechaNacimiento === "";
}

function esCampoVacio(mail) {
    return mail === "";
}

function esUnicoNombre(NombreUsuario) {
    let palabra = NombreUsuario.split(/\s+/);
    return palabra.length === 1;
}

function contieneSoloLetras(NombreUsuario) {
    let RegularLetras = /^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/;
    return RegularLetras.test(NombreUsuario);
}
function Contiene3Caracteres(NombreUsuario) {
    let Caracteres = NombreUsuario.trim().split(/\s+/);
    if (Caracteres.length === 1) {
        let nombreUnido = Caracteres.join('');
        return nombreUnido.length >= 3;
    }
    return false;
}

window.onload = inicio;