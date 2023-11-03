<?php 
require("session.php");
require("conexion.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Pregunta y Respuesta</title>
    <script>
        function agregarPregunta() {
            var textoNuevaPregunta = document.getElementById("textoNuevaPregunta");
            var campoPregunta = document.getElementById("campoPregunta");

            textoNuevaPregunta.style.display = "none";
            campoPregunta.style.display = "block";

            campoPregunta.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();

                    textoNuevaPregunta.textContent = campoPregunta.value;
                    campoPregunta.style.display = "none";
                    textoNuevaPregunta.style.display = "block";

                    // Mostrar "Agregar respuesta" debajo de la pregunta
                    var agregarRespuesta = document.getElementById("agregarRespuesta");
                    agregarRespuesta.style.display = "block";
                    agregarRespuesta.addEventListener("click", agregarRespuesta);
                }
            });
        }

        function agregarRespuesta() {
            var textoAgregarRespuesta = document.getElementById("textoAgregarRespuesta");
            var campoRespuesta = document.getElementById("campoRespuesta");

            textoAgregarRespuesta.style.display = "none";
            campoRespuesta.style.display = "block";

            campoRespuesta.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();

                    textoAgregarRespuesta.textContent = campoRespuesta.value;
                    campoRespuesta.style.display = "none";
                    textoAgregarRespuesta.style.display = "block";

                    // Mostrar "Agregar otra respuesta" debajo de la respuesta
                    var agregarOtraRespuesta = document.getElementById("textoAgregarOtraRespuesta");
                    textoAgregarOtraRespuesta.style.display = "block";
                    textoAgregarOtraRespuesta.addEventListener("click", textoAgregarOtraRespuesta);
                }
            });
        }

        function agregarOtraRespuesta() {
            var textoAgregarOtraRespuesta = document.getElementById("textoAgregarOtraRespuesta");
            var campoOtraRespuesta = document.getElementById("campoOtraRespuesta");

            textoAgregarOtraRespuesta.style.display = "none";
            campoOtraRespuesta.style.display = "block";

            campoOtraRespuesta.addEventListener("keydown", function (event) {
                if (event.key === "Enter") {
                    event.preventDefault();

                    textoAgregarOtraRespuesta.textContent = campoOtraRespuesta.value;
                    campoOtraRespuesta.style.display = "none";
                    textoAgregarOtraRespuesta.style.display = "block";

                    // Clonar la estructura de la respuesta y agregarla debajo
                    agregarNuevaRespuesta();
                }
            });
        }

        function agregarNuevaRespuesta() {
            var respuestaClone = document.getElementById("respuestaClone");
            var nuevaRespuesta = respuestaClone.cloneNode(true);
            nuevaRespuesta.style.display = "block";
            nuevaRespuesta.id = "respuestaClone" + Date.now();
            document.body.appendChild(nuevaRespuesta);
        }
        
    </script>
</head>
<body>
    <p id="textoNuevaPregunta" onclick="agregarPregunta()">Nueva pregunta</p>
    <input id="campoPregunta" type="text" style="display: none;" placeholder="Escribe tu pregunta aquí">

    <p id="textoAgregarRespuesta" onclick="agregarRespuesta()">Agregar respuesta</p>
    <input id="campoRespuesta" type="text" style="display: none;" placeholder="Escribe tu respuesta aquí">

    <p id="textoAgregarOtraRespuesta" style="display: none" onclick="agregarOtraRespuesta()">Agregar otra respuesta</p>
    <input id="campoOtraRespuesta" type="text" style="display: none;" placeholder="Escribe otra respuesta aquí">

    <div id="respuestaClone" style="display: none">
        <p onclick="agregarNuevaRespuesta()">Agregar respuesta</p>
        <input type="text" style="display: none" placeholder="Escribe tu respuesta aquí">
    </div>
</body>
</html>