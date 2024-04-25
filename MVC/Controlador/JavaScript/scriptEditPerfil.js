function index(){
    document.getElementById("edicionPerfil").addEventListener("submit", sendForm);
}

function sendForm(evento) {
  if (Validar()) {
    limpiarForm();
    console.log('el formulario se envio de manera exitosa');
  }else{
    evento.preventDefault();
  }
}

function limpiarForm() {
  document.getElementById("registrarUsuario").reset();
}

function Validar(){

  let mensajeNombre = document.getElementById("editNombre");
  mensajeNombre.classList.remove("is-invalid");

  let mensajeMail = document.getElementById("editCorreo");
  mensajeMail.classList.remove("is-invalid");

  let mensajeFecha = document.getElementById("editFecha");
  mensajeFecha.classList.remove("is-invalid");

  let nombre = document.getElementById("editNombre").value;
  let palabra = nombre.split(/\s+/);
  let RegularLetras=/^[a-zA-ZáéíóúÁÉÍÓÚ ]+$/;

  //////////Validar cantidad de palabras

  if (palabra.length !== 1 ){
          console.log('Debes ingresar un unico nombre de usuario, sin espacios.');
          mensajeNombre.classList.add("is-invalid");

          return false;
  }  

  /////////////Validar caracteres

  if(!RegularLetras.test(nombre)){
      mensajeNombre.classList.add("is-invalid");
      console.log('Los caracteres ingresados en nombre no son letras.');
  }

 
  
  let mail = document.getElementById("editCorreo").value;
  let regularMail = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
  
  if(!regularMail.test(mail)){
      return false;
  }


  //////////Validar Edad
  let fechaNacimiento = new Date(document.getElementById('editFecha').value); // aca obtengo el valor ingresado en el formulario

  // aca obtengo la fecha de la actualidad
  let fechaActual = new Date();

  let diferencia = fechaActual - fechaNacimiento; // la diferencia entre la fecha actual y la fecha ingresada 

  // convierto la diferencia en años
  let edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25)); //Math.floor para redondear hacia abajo el resto de la division matematica

  if (edad < 16 || edad > 99) {
      mensajeFecha.classList.add("is-invalid");
      // si la edad es menor a 16 años o mayor a 99 años, muestro un mensaje "alert" en la pagina indicando que no pudo iniciar sesion, y el error
      console.log('Para registrarte en la pagina de VOLEY UPE debes tener almenos 16 años y menor a 99 años');
      return false;
  }

  // La edad es mayor o igual a 16 años
  return true;
}
window.onload = index;