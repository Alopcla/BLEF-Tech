document.addEventListener('DOMContentLoaded', () => {
    const enlaceAnimales = document.querySelector('a[href="#seccion-animales"]');
    const seccion = document.getElementById('pagina-animales-root');

    if (enlaceAnimales && seccion) {
        enlaceAnimales.addEventListener('click', (e) => {
            e.preventDefault();
            seccion.style.display = 'block';
            seccion.scrollIntoView({ behavior: 'smooth' });
        });
    }
});