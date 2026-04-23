import React, { useState, useEffect } from "react";
import AnimalCard from "./AnimalCard";

const AnimalGallery = () => {
    const [animales, setAnimales] = useState([]);
    const [cargando, setCargando] = useState(true);

    const [busqueda, setBusqueda] = useState("");
    const [filtroDieta, setFiltroDieta] = useState("Todos");

    useEffect(() => {
        fetch("/api/animales")
            .then((response) => response.json())
            .then((datos) => {
                setAnimales(datos.data);
                setCargando(false);
            })
            .catch((error) => {
                console.error("Error al cargar los animales:", error);
                setCargando(false);
            });
    }, []);

    const animalesFiltrados = animales.filter((animal) => {
        const nombre = animal.common_name || "";
        const especie = animal.species || "";
        const dieta = animal.diet || "";

        const textoBusqueda = busqueda.toLowerCase();
        const coincideBusqueda =
            nombre.toLowerCase().includes(textoBusqueda) ||
            especie.toLowerCase().includes(textoBusqueda);

        const coincideDieta =
            filtroDieta === "Todos" ||
            dieta.toLowerCase() === filtroDieta.toLowerCase();

        return coincideBusqueda && coincideDieta;
    });

    const opcionesDieta = [
        "Todos",
        "Carnívoro",
        "Herbívoro",
        "Omnívoro",
        "Piscívoro",
        "Frugívoro",
        "Insectívoro",
    ];

    const contarAnimalesPorDieta = (dieta) => {
        if (dieta === "Todos") return animales.length;
        return animales.filter((a) => (a.diet || "").toLowerCase() === dieta.toLowerCase()).length;
    };

    return (
        <section className="!bg-transparent min-h-screen pb-24 w-full">
            {/* Título */}
            <section className="text-center pt-24 pb-12 px-6">
                <span className="text-[#D9C8A1] uppercase tracking-[4px] text-xs font-bold">
                    Conoce a nuestros protagonistas
                </span>
                <h1 className="text-4xl md:text-5xl font-parkzoo mt-2 text-white fuenteZoo">
                    Nuestros <span className="text-[#D9C8A1]">Animales</span>
                </h1>
                <div className="w-16 h-[2px] bg-[#D9C8A1] mx-auto mt-4"></div>
                <p className="text-gray-400 max-w-xl mx-auto mt-6 italic">
                    Descubre la asombrosa diversidad de especies que cuidamos y protegemos en nuestras instalaciones.
                </p>
            </section>

            {/* CONTENEDOR PRINCIPAL: Flexbox estricto. Columna en móvil, Fila en PC */}
            <div className="container mx-auto px-4 max-w-7xl flex flex-col lg:flex-row gap-8 items-start">

                {/* ==========================================
                    BARRA LATERAL IZQUIERDA (FILTROS)
                    La clave aquí es "static lg:sticky". En móvil fluye normal, en PC se pega.
                    ========================================== */}
                <aside className="w-full lg:w-80 shrink-0 bg-[#141A14]/90 backdrop-blur-md p-6 rounded-[2rem] border border-white/5 shadow-2xl z-30 static lg:sticky lg:top-24">

                    {/* Sección Buscar */}
                    <div className="mb-8">
                        <h3 className="text-[#D9C8A1] uppercase tracking-widest text-[11px] font-black mb-3">
                            Buscar
                        </h3>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                                <i className="bi bi-search"></i>
                            </div>
                            <input
                                type="text"
                                placeholder="Nombre o especie..."
                                value={busqueda}
                                onChange={(e) => setBusqueda(e.target.value)}
                                className="w-full bg-[#1A221A] border border-white/5 text-white text-sm rounded-xl focus:ring-[#E0D7B6] focus:border-[#E0D7B6] block pl-10 p-3 transition-colors placeholder-neutral-600 shadow-inner"
                            />
                        </div>
                    </div>

                    {/* Sección Dieta (Categoría) */}
                    <div>
                        <h3 className="text-[#D9C8A1] uppercase tracking-widest text-[11px] font-black mb-3">
                            Categoría (Dieta)
                        </h3>
                        <div className="flex flex-col gap-1">
                            {opcionesDieta.map((dieta) => (
                                <button
                                    key={dieta}
                                    onClick={() => setFiltroDieta(dieta)}
                                    className={`flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all ${
                                        filtroDieta === dieta
                                            ? "bg-[#386641] text-white shadow-lg"
                                            : "text-neutral-400 hover:bg-white/5 hover:text-white"
                                    }`}
                                >
                                    <div className="flex items-center gap-3">
                                        <i className={`bi ${filtroDieta === dieta ? 'bi-grid-fill' : 'bi-dash'}`}></i>
                                        <span>{dieta}</span>
                                    </div>
                                    <span className="bg-[#1A221A] text-neutral-500 text-[10px] px-2.5 py-1 rounded-full font-bold shadow-inner">
                                        {contarAnimalesPorDieta(dieta)}
                                    </span>
                                </button>
                            ))}
                        </div>
                    </div>
                </aside>

                {/* ==========================================
                    CUADRÍCULA DERECHA (ANIMALES)
                    flex-1 asegura que ocupe el resto del espacio disponible sin desbordar
                    ========================================== */}
                <main className="w-full flex-1 min-w-0">
                    {cargando ? (
                        <p className="text-center text-2xl text-white font-bold animate-pulse mt-12">
                            Cargando animales...
                        </p>
                    ) : animalesFiltrados.length === 0 ? (
                        <div className="text-center py-20 bg-[#141A14]/50 rounded-[2rem] border border-white/5">
                            <i className="bi bi-emoji-frown text-6xl text-neutral-500 mb-4 block"></i>
                            <h3 className="text-2xl text-white font-bold">
                                No hemos encontrado ningún animal
                            </h3>
                            <p className="text-neutral-400 mt-2">
                                Prueba a buscar con otras palabras o quita los filtros.
                            </p>
                            <button
                                onClick={() => {
                                    setBusqueda("");
                                    setFiltroDieta("Todos");
                                }}
                                className="mt-6 text-[#E0D7B6] underline hover:text-white transition"
                            >
                                Limpiar búsqueda
                            </button>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            {animalesFiltrados.map((animal) => (
                                <AnimalCard key={animal.id} animal={animal} />
                            ))}
                        </div>
                    )}
                </main>
            </div>
        </section>
    );
};

export default AnimalGallery;
