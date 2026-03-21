import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
// 1. IMPORTANTE: Importamos la Galería (el Padre) en lugar de la Tarjeta suelta
import AnimalGallery from './Components/AnimalGallery';

const container = document.getElementById('seccion-animales');

if (container) {
    const root = createRoot(container);

    // Función para renderizar el componente
    const renderAnimales = () => {
        container.style.display = 'block'; // Mostramos el div que estaba oculto
        // 2. IMPORTANTE: Renderizamos el componente Padre
        root.render(<AnimalGallery />);
    };

    // Buscamos el enlace del menú en el HTML y le asignamos el evento
    const linkAnimales = document.querySelector('a[href="#seccion-animales"]');
    if (linkAnimales) {
        linkAnimales.addEventListener('click', (e) => {
            e.preventDefault(); // Evitamos que la página salte
            renderAnimales();
        });
    }
}
