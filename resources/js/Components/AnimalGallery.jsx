import React, { useState, useEffect } from 'react';
import AnimalCard from './AnimalCard';

const AnimalGallery = () => {
    // Estados originales
    const [animales, setAnimales] = useState([]);
    const [cargando, setCargando] = useState(true);

    // NUEVOS ESTADOS: Para el buscador y los filtros
    const [busqueda, setBusqueda] = useState('');
    const [filtroDieta, setFiltroDieta] = useState('Todos');

    useEffect(() => {
        fetch('/api/animales')
            .then(response => response.json())
            .then(datos => {
                setAnimales(datos.data);
                setCargando(false);
            })
            .catch(error => {
                console.error("Error al cargar los animales:", error);
                setCargando(false);
            });
    }, []);

    // LÓGICA DE FILTRADO BLINDADA CONTRA NULOS
    const animalesFiltrados = animales.filter(animal => {
        // 1. Extraemos los datos asegurándonos de que nunca sean null (usamos un string vacío '' si no existen)
        const nombre = animal.common_name || '';
        const especie = animal.species || '';
        const dieta = animal.diet || '';

        // 2. Comprobamos la búsqueda
        const textoBusqueda = busqueda.toLowerCase();
        const coincideBusqueda =
            nombre.toLowerCase().includes(textoBusqueda) ||
            especie.toLowerCase().includes(textoBusqueda);

        // 3. Comprobamos el filtro de botones
        const coincideDieta =
            filtroDieta === 'Todos' ||
            dieta.toLowerCase() === filtroDieta.toLowerCase();

        // El animal solo se muestra si cumple AMBAS condiciones
        return coincideBusqueda && coincideDieta;
    });

    // Array de dietas para generar los botones automáticamente
    const opcionesDieta = ['Todos', 'Carnívoro', 'Herbívoro', 'Omnívoro', 'Piscívoro', 'Frugívoro', 'Insectívoro'];

    return (
        <section className="!bg-transparent min-h-screen pb-24 w-full">
            <style>
                {`
                    @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&display=swap');
                    .fuente-zoo { font-family: 'Fredoka', sans-serif; }
                `}
            </style>

            {/* Título */}
            <div className="pt-16 pb-8 md:pt-24 flex justify-center">
                <h1
                    className="fuente-zoo text-6xl md:text-8xl text-white/90 tracking-wide text-center transform hover:scale-105 transition duration-500"
                    style={{ textShadow: '3px 3px 0px rgba(0,0,0,0.9), 8px 8px 15px rgba(0,0,0,0.6)' }}
                >
                    Nuestro Zoológico
                </h1>
            </div>

            {/* ==========================================
                NUEVA SECCIÓN: CONTROLES DE BÚSQUEDA Y FILTRO
                ========================================== */}
            <div className="container mx-auto px-4 max-w-7xl mb-12">
                <div className="bg-[#171717]/80 backdrop-blur-md p-6 rounded-[32px] border border-neutral-800 shadow-2xl flex flex-col md:flex-row gap-6 items-center justify-between">

                    {/* Barra de Búsqueda */}
                    <div className="relative w-full md:w-1/3">
                        <div className="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400">
                            <i className="bi bi-search"></i>
                        </div>
                        <input
                            type="text"
                            placeholder="Buscar por nombre o especie..."
                            value={busqueda}
                            onChange={(e) => setBusqueda(e.target.value)}
                            className="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-full focus:ring-[#E0D7B6] focus:border-[#E0D7B6] block pl-10 p-3.5 transition-colors placeholder-neutral-500"
                        />
                    </div>

                    {/* Botones de Filtro de Dieta */}
                    <div className="flex flex-wrap justify-center gap-2 w-full md:w-2/3">
                        {opcionesDieta.map((dieta) => (
                            <button
                                key={dieta}
                                onClick={() => setFiltroDieta(dieta)}
                                className={`px-4 py-2 rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300 ${
                                    filtroDieta === dieta
                                        ? 'bg-[#E0D7B6] text-black shadow-[0_0_15px_rgba(224,215,182,0.4)] scale-105'
                                        : 'bg-neutral-800 text-neutral-400 border border-neutral-700 hover:bg-neutral-700 hover:text-white'
                                }`}
                            >
                                {dieta}
                            </button>
                        ))}
                    </div>
                </div>
            </div>
            {/* ========================================== */}

            {/* Cuadrícula de Animales */}
            <div className="container mx-auto px-4 max-w-7xl !bg-transparent">
                {cargando ? (
                    <p className="text-center text-2xl text-white font-bold animate-pulse" style={{textShadow: '2px 2px 4px black'}}>
                        Cargando animales...
                    </p>
                ) : animalesFiltrados.length === 0 ? (
                    /* Mensaje si la búsqueda no encuentra nada */
                    <div className="text-center py-20">
                        <i className="bi bi-emoji-frown text-6xl text-neutral-500 mb-4 block"></i>
                        <h3 className="text-2xl text-white font-bold">No hemos encontrado ningún animal</h3>
                        <p className="text-neutral-400 mt-2">Prueba a buscar con otras palabras o quita los filtros.</p>
                        <button
                            onClick={() => { setBusqueda(''); setFiltroDieta('Todos'); }}
                            className="mt-6 text-[#E0D7B6] underline hover:text-white transition"
                        >
                            Limpiar búsqueda
                        </button>
                    </div>
                ) : (
                    /* Renderizamos los animales FILTRADOS, no todos */
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 !bg-transparent">
                        {animalesFiltrados.map((animal) => (
                            <AnimalCard key={animal.id} animal={animal} />
                        ))}
                    </div>
                )}
            </div>
        </section>
    );
};

export default AnimalGallery;
