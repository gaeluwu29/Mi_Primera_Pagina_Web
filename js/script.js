const fecha = new Date();

const formatoFecha = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric"
};
  document.getElementById("fechaActual").textContent =
            fecha.toLocaleDateString("es-MX", formatoFecha);

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