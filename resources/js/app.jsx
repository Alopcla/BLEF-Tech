// import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import AnimalGallery from './Components/AnimalGallery';

// 1. Buscamos el NUEVO contenedor que creaste en animales.blade.php
const container = document.getElementById('pagina-animales-root');

// 2. Si el contenedor existe (es decir, si estamos en la ruta /animales)
if (container) {
    const root = createRoot(container);
    // 3. Renderizamos la galería directamente. ¡Sin rodeos ni eventos de clic!
    root.render(<AnimalGallery />);
}
