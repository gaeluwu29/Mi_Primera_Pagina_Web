
document.addEventListener("DOMContentLoaded", function () {

    const formulario = document.getElementById("formRegistro");

    formulario.addEventListener("submit", function (evento) {

        const password = document.getElementById("password").value;
        const confirmar = document.getElementById("confirmar").value;

        if (password !== confirmar) {

            evento.preventDefault();

            alert("Las contraseñas no coinciden.");

        } else if (password.length < 8) {

            evento.preventDefault();

            alert("La contraseña debe tener al menos 8 caracteres.");

        }

    });

});
