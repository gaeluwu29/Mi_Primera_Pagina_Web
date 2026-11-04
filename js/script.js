
const fecha = new Date();

const formatoFecha = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
};

const elementoFecha = document.getElementById("fechaActual");

if (elementoFecha) {
    elementoFecha.textContent =
        fecha.toLocaleDateString("es-MX", formatoFecha);
}

function convertirDolares() {

    let pesos = parseFloat(document.getElementById("pesos").value);
    let resultado = document.getElementById("resultadoDolares");

    if (isNaN(pesos) || pesos < 0) {
        resultado.textContent = "Ingresa una cantidad válida.";
        return;
    }

    let dolares = pesos / 18;

    resultado.textContent = "Resultado: $" + dolares.toFixed(2) + " USD";
}

function calificarCuestionario() {

    let puntos = 0;

    let respuesta1 = document.querySelector(
        'input[name="pregunta1"]:checked'
    );

    let respuesta2 = document.querySelector(
        'input[name="pregunta2"]:checked'
    );

    let respuesta3 = document.querySelector(
        'input[name="pregunta3"]:checked'
    );

    if (respuesta1 && respuesta1.value === "b") {
        puntos++;
    }

    if (respuesta2 && respuesta2.value === "a") {
        puntos++;
    }

    if (respuesta3 && respuesta3.value === "a") {
        puntos++;
    }

    document.getElementById("resultadoCuestionario").textContent =
        "Respuestas correctas: " + puntos + " de 3.";
}


const formulario = document.getElementById("formularioContacto");

if (formulario) {

    formulario.addEventListener("submit", function(event) {

        event.preventDefault();

        let nombre = document.getElementById("Nombre").value.trim();
        let apellido = document.getElementById("Apellido").value.trim();

        let genero = document.querySelector(
            'input[name="Genero"]:checked'
        );

        let intereses = document.querySelectorAll(
            'input[type="checkbox"]:checked'
        );

        let escolaridad = document.getElementById("Escolaridad").value;

        let navegador = document.getElementById("MisBuscadores").value.trim();

        let mensaje = document.getElementById("mensajeValidacion");

        mensaje.style.color = "red";


        if (nombre === "") {
            mensaje.textContent = "El campo nombre no puede estar vacío.";
            return;
        }


        if (apellido === "") {
            mensaje.textContent = "El campo apellido no puede estar vacío.";
            return;
        }


        if (!genero) {
            mensaje.textContent = "Debes seleccionar una opción de género.";
            return;
        }


        if (intereses.length === 0) {
            mensaje.textContent = "Debes seleccionar al menos un interés.";
            return;
        }


        if (escolaridad === "") {
            mensaje.textContent = "Debes seleccionar una opción de escolaridad.";
            return;
        }


        if (navegador === "") {
            mensaje.textContent = "El campo navegador no puede estar vacío.";
            return;
        }

        mensaje.style.color = "green";

        mensaje.textContent =
            "¡Formulario completado correctamente!";

    });

}

function elevarCuadrado() {

    let numero = parseFloat(document.getElementById("numeroCuadrado").value);

    let resultado = document.getElementById("resultadoCuadrado");

    if (isNaN(numero)) {
        resultado.textContent = "Introduce un número válido.";
        return;
    }

    let cuadrado = numero * numero;

    resultado.textContent = "El resultado es: " + cuadrado;
}

