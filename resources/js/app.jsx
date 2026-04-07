import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client"; // Importamos createRoot directamente

// Importación de componentes
import AnimalGallery from "./Components/AnimalGallery";
import MapaZoologic from "./Components/MapaZoologic";
import AdminDashboard from "./Components/AdminDashboard";
import DoctorDashboard from "./Components/DoctorDashboard";
import KeeperDashboard from "./Components/KeeperDashboard";
import GuideDashboard from './Components/GuideDashboard';

// Lógica para la Galería de Animales
const animalContainer = document.getElementById("pagina-animales-root");
if (animalContainer) {
    const root = createRoot(animalContainer);
    root.render(<AnimalGallery />);
}

// Lógica para el Mapa del Zoo
const mapaContainer = document.getElementById("react-mapa");
if (mapaContainer) {
    // IMPORTANTE: Usamos 'createRoot' directamente, NO 'ReactDOM.createRoot'
    const root = createRoot(mapaContainer);
    root.render(
        <React.StrictMode>
            <MapaZoologic />
        </React.StrictMode>,
    );
}

// Buscamos el contenedor en animales.blade.php
const container = document.getElementById("pagina-animales-root");

// Si el contenedor existe (es decir, si estamos en la ruta /animales)
if (container) {
    const root = createRoot(container);
    // 3. Renderizamos la galería directamente. ¡Sin rodeos ni eventos de clic!
    root.render(<AnimalGallery />);
}

// Buscamos la "caja vacía" que dejamos en el Blade
const adminElement = document.getElementById("admin-dashboard-root");
// Si la encontramos (es decir, si estamos en la ruta /empleados), pintamos el panel de React
if (adminElement) {
    const root = createRoot(adminElement);
    root.render(<AdminDashboard />);
}

// --- PANEL DE MÉDICO ---
const doctorRootEl = document.getElementById("doctor-dashboard-root");
if (doctorRootEl) {
    createRoot(doctorRootEl).render(<DoctorDashboard />);
}

// --- PANEL DE CUIDADOR (KEEPER) ---
const keeperRootEl = document.getElementById("keeper-dashboard-root");
if (keeperRootEl) {
    createRoot(keeperRootEl).render(<KeeperDashboard />);
}

const guideRootEl = document.getElementById('guide-dashboard-root');
if (guideRootEl) {
    // Usamos el createRoot que ya deberías tener importado arriba en tu app.jsx
    createRoot(guideRootEl).render(<GuideDashboard />);
}
