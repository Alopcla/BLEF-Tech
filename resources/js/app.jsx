import "./bootstrap";
import "./main.js";

import React from "react";
import { createRoot } from "react-dom/client";

import AnimalGallery from "./Components/AnimalGallery";
import MapaZoologic from "./Components/MapaZoologic";
import AdminDashboard from "./Components/AdminDashboard";
import DoctorDashboard from "./Components/DoctorDashboard";
import KeeperDashboard from "./Components/KeeperDashboard";
import GuideDashboard from './Components/GuideDashboard';
import ExperienciasPage from './Components/Experience';
import ExperienceInfo from "./Components/ExperienceInfo";
import MyOrders from "./Components/MyOrders";


const mount = (id, component) => {
    const el = document.getElementById(id);
    if (el) createRoot(el).render(component);
};

// Animales
mount("pagina-animales-root", <AnimalGallery />);

// Mapa
mount("react-mapa", <React.StrictMode><MapaZoologic /></React.StrictMode>);

// Admin
mount("admin-dashboard-root", <AdminDashboard />);

// Médico
mount("doctor-dashboard-root", <DoctorDashboard />);

// Cuidador
mount("keeper-dashboard-root", <KeeperDashboard />);

// Guía
mount("guide-dashboard-root", <GuideDashboard />);

// Experiencias
const experienciasContainer = document.getElementById('experiencias-root');
if (experienciasContainer) {
    const { auth, email } = experienciasContainer.dataset;
    mount("experiencias-root", 
        <ExperienciasPage isAuth={auth === 'true'} userEmail={email || ''} />
    );
}

// Detalle experiencia
const reservaContainer = document.getElementById("reserva-root");
if (reservaContainer) {
    const { auth, email, expId, expName, available } = reservaContainer.dataset;
    createRoot(reservaContainer).render(
        <ExperienceInfo
            isAuth={auth === "true"}
            userEmail={email || ""}
            expId={expId}
            expName={expName}
            available={parseInt(available)}
        />
    );
}

// Mis pedidos
const ordersContainer = document.getElementById("myorders-root");
if (ordersContainer) {
    const { auth, email } = ordersContainer.dataset;
    createRoot(ordersContainer).render(
        <MyOrders auth={auth === "true"} initialEmail={email} />
    );
}