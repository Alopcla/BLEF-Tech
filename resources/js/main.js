document.addEventListener('DOMContentLoaded', () => {
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
});
