import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client'; // Importamos createRoot directamente

// Importación de componentes
import AnimalGallery from './Components/AnimalGallery';
import MapaZoologic from './Components/MapaZoologic';

// Lógica para la Galería de Animales
const animalContainer = document.getElementById('pagina-animales-root');
if (animalContainer) {
    const root = createRoot(animalContainer);
    root.render(<AnimalGallery />);
}

// Lógica para el Mapa del Zoo
const mapaContainer = document.getElementById('react-mapa');
if (mapaContainer) {
    // IMPORTANTE: Usamos 'createRoot' directamente, NO 'ReactDOM.createRoot'
    const root = createRoot(mapaContainer);
    root.render(
        <React.StrictMode>
            <MapaZoologic />
        </React.StrictMode>
    );
}