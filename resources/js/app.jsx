// import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import AnimalGallery from './Components/AnimalGallery';
import AdminDashboard from './Components/AdminDashboard';

// Buscamos el contenedor en animales.blade.php
const container = document.getElementById('pagina-animales-root');

// Si el contenedor existe (es decir, si estamos en la ruta /animales)
if (container) {
    const root = createRoot(container);
    // 3. Renderizamos la galería directamente. ¡Sin rodeos ni eventos de clic!
    root.render(<AnimalGallery />);
}

// Buscamos la "caja vacía" que dejamos en el Blade
const rootElement = document.getElementById('admin-dashboard-root');
// Si la encontramos (es decir, si estamos en la ruta /empleados), pintamos el panel de React
if (rootElement) {
    const root = createRoot(rootElement);
    root.render(<AdminDashboard />);
}
