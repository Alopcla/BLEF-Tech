/*document.addEventListener('DOMContentLoaded', () => {
    // 1. Lógica de Scroll suave hacia la sección de animales
    const enlaceAnimales = document.querySelector('a[href="#seccion-animales"]');
    const seccion = document.getElementById("pagina-animales-root");

    if (enlaceAnimales) {
        enlaceAnimales.addEventListener("click", (e) => {
            e.preventDefault();
            if (seccion) {
                seccion.style.display = "block";
                seccion.scrollIntoView({ behavior: "smooth" });
            }
        });
    }

    // 2. Lógica para la barra de temperatura
    const barraTemperatura = document.getElementById("temperatura");
    if (barraTemperatura) {
        // Simulamos el tiempo de carga como lo tenías originalmente
        setTimeout(() => {
            barraTemperatura.innerHTML = '24°C <i class="bi bi-cloud-sun ml-2"></i>';
        }, 1500);
    }
});*/

function Temperatura(){
    const apiKey = "cf65edd77d4d40d68b8200346262804";
    const ciudad = "Sevilla"; // o la ciudad de tu zoológico


    async function obtenerTemperatura() {
        const url = `https://api.weatherapi.com/v1/current.json?key=${apiKey}&q=${ciudad}&lang=es`;

        try {
            const respuesta = await fetch(url);
            const datos = await respuesta.json();

            const temp = Math.trunc(datos.current.temp_c);
            const icono = datos.current.condition.icon;

            document.getElementById("temperatura").innerHTML =
                `${temp}°C | <img src="${icono}" width="35">`;
        } catch {
            document.getElementById("temperatura").innerHTML =
                `<i class="bi bi-thermometer-high"></i> No disponible`;
        }
    }

    function ajustarTemperatura() {
        const tempDiv = document.getElementById("temperatura");
        const navFlex = document.querySelector(".navegacion-flex");
        const header = document.querySelector("header");

        if (window.innerWidth <= 900) {
            navFlex.prepend(tempDiv);
            tempDiv.style.marginBottom = "10px"; 
        } else {
            header.prepend(tempDiv);
            tempDiv.style.marginBottom = "0";
        }
    }

    

    window.addEventListener("resize", ajustarTemperatura);
    window.addEventListener("load", ajustarTemperatura);

    obtenerTemperatura();
}

Temperatura();
setInterval(Temperatura,30000);
