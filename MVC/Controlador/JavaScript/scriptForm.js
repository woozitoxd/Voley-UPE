function inicio(){

}

function enviarFormulario(evento) {
  if (Validaciones()) {
    console.log('El formulario se envió de manera exitosa.');

  }else{
    console.log('Error al enviar el formulario');
    evento.preventDefault();
  }
}

function Validaciones(){

  let mensajeNombre = document.getElementById("name_registro");
  mensajeNombre.classList.remove("is-invalid");

  let mensajeMail = document.getElementById("email_registro");
  mensajeMail.classList.remove("is-invalid");

  let mensajeEdad = document.getElementById("fecha_Registro");
  mensajeEdad.classList.remove("is-invalid");

  let nombre = document.getElementById("name_registro").value;
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

 
  
  let mail = document.getElementById("email_registro").value;
  let regularMail = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
  
  if(!regularMail.test(mail)){
      return false;
  }

  //////////Validar Edad
  let fechaNacimiento = new Date(document.getElementById('fecha_Registro').value); // aca obtengo el valor ingresado en el formulario

  // aca obtengo la fecha de la actualidad
  let fechaActual = new Date();

  let diferencia = fechaActual - fechaNacimiento; // la diferencia entre la fecha actual y la fecha ingresada 

  // convierto la diferencia en años
  let edad = Math.floor(diferencia / (1000 * 60 * 60 * 24 * 365.25)); //Math.floor para redondear hacia abajo el resto de la division matematica

  if (edad < 16 || edad > 100) {
      //la edad no puede ser menor de 16 años ni mayor de 100 años
    console.log('Para registrarte en la pagina de VOLEY UPE debes tener almenos 16 años');
      return false;
  }

  return true;
}
window.onload = inicio;