import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import TarjetaAnimal from './Components/TarjetaAnimal';

// 1. Buscamos el contenedor que pusimos en welcome.blade.php
const container = document.getElementById('seccion-animales');

// 2. Si el contenedor existe, renderizamos el componente de React
if (container) {
    const root = createRoot(container);
    root.render(<TarjetaAnimal />);
}
