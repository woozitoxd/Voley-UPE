/////////////////// Cargar la barra de navegacion desde navbar.html utilizando JavaScript
let navbarContainer = document.getElementById('navbar-container');
fetch('navbar.php')
    .then(response => {
        // Verificar si la respuesta es exitosa
        if (!response.ok) {
            throw new Error('La solicitud no se pudo completar correctamente.');
        }
        // Convertir la respuesta a texto
        return response.text();
    })
    .then(data => {
        // Insertar el contenido de 'navbar.html' en el contenedor
        navbarContainer.innerHTML = data;
        document.getElementById("registrarUsuario").addEventListener('submit', enviarFormulario);

    })
    .catch(error => {
        // Manejar errores si ocurren
        console.error('Error al cargar la barra de navegación:', error);
    });
///////////////////

/////////////////// Cargar el pie de pagina desde footer.html utilizando JavaScript
let footerContainer = document.getElementById('footer-container');
fetch('footer.html')
    .then(response => {
        // verifico si la respuesta que obtuve fue exitosa
        if (!response.ok) {
            throw new Error('La solicitud no se pudo completar correctamente.');
        }
        // convierto la respuesta a texto
        return response.text();
    })
    .then(data => {
        // Insertar el contenido de 'footer.html' en el contenedor
        footerContainer.innerHTML = data;
    })
    .catch(error => {
        // Manejar errores si es que ocurren
        console.error('Error al cargar el footer:', error);
    });


//////////////////////////////////////
