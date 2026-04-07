import React, { useState, useEffect } from "react";

const Index = () => {
    const [temperatura, setTemperatura] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // 1. Lógica del clima (He dejado la simulación temporal por si quieres conectarlo a una API más adelante)
        const fetchWeather = async () => {
            try {
                setTimeout(() => {
                    setTemperatura("24°C");
                    setLoading(false);
                }, 1500);
            } catch (error) {
                console.error("Error al obtener la temperatura:", error);
                setTemperatura("N/A");
                setLoading(false);
            }
        };

        fetchWeather();

        // 2. Lógica migrada desde main.js (Scroll suave hacia animales)
        const enlaceAnimales = document.querySelector(
            'a[href="#seccion-animales"]',
        );
        const seccion = document.getElementById("pagina-animales-root");

        const handleScroll = (e) => {
            e.preventDefault();
            if (seccion) {
                seccion.style.display = "block";
                seccion.scrollIntoView({ behavior: "smooth" });
            }
        };

        if (enlaceAnimales) {
            enlaceAnimales.addEventListener("click", handleScroll);
        }

        // 3. Limpieza del evento (Buenas prácticas de React)
        return () => {
            if (enlaceAnimales) {
                enlaceAnimales.removeEventListener("click", handleScroll);
            }
        };
    }, []);

    return (
        <div className="w-full flex justify-end">
            {/* Barra de temperatura */}
            <div className="barra-tiempo" id="temperatura">
                {loading ? "Cargando..." : `${temperatura}`}
                <i className="bi bi-cloud-sun ml-2"></i>
            </div>
        </div>
    );
};

export default Index;
