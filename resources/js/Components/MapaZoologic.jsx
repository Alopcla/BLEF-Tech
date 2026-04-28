import React, { useState, useRef } from 'react';
import axios from 'axios';

const MapaZoologic = () => {
    const [infoZona, setInfoZona] = useState(null);
    const [mousePos, setMousePos] = useState({ x: 0, y: 0, quadrantX: 'right', quadrantY: 'bottom' });
    const containerRef = useRef(null);

    // IDs exactos según la tabla de Supabase
    const zonas = [
        { id: 'Edificio', top: '75%', left: '20%', nombre: 'BLR-Zoo' },// top y left son % para que sea responsive
        { id: 'Terrestre', top: '60%', left: '55%', nombre: 'Sabana / Terrestre' },
        { id: 'Acuático', top: '65%', left: '85%', nombre: 'Charca / Acuático' },
        { id: 'Aviario', top: '25%', left: '38%', nombre: 'Aviario' },
        { id: 'Reptilario', top: '22%', left: '55%', nombre: 'Reptilario' },
        { id: 'Trepadores y Terrestres', top: '25%', left: '75%', nombre: 'Jungla' },
    ];

    // Metodo asincrono que comunica con el back mediante las id en bdd
    const manejarHover = async (id) => {
        // Lógica especial para el edificio principal sin consulta a BDD
        if (id === 'Edificio') {
            setInfoZona({
                type: "Edificio y punto de acceso principal",
                dimensions_m2: "N/A",
                description: "Visita nuestra tienda de recuerdos",
                isSpecial: true,
                animals: [],
                experiences: [],
                events: []
            });
            return;
        }

        try {
            const response = await axios.get(`/api/zones/tipo/${encodeURIComponent(id)}`);// axios conecta las id por zonas
            setInfoZona(response.data); // encodeURIComponent asegura que las id sean validas aun con caracteres especiales
        } catch (error) {// Si la petición es correcta setInfoZona(response.data) hace que react renderice el popup
            console.error("Error al obtener datos de la zona:", error);
        }
    };

    // Método para manejar la redirección a la tienda
    const manejarClickZona = (id) => {
        if (id === 'Edificio') {
            window.location.href = '/tienda'; // Redirección directa
        }
    };

    // metodo que controla la logica espacial y se ejecuta cuando el raton se mueve por el contenedor
    const manejarMovimientoMouse = (e) => {
        if (!containerRef.current) return;

        const rect = containerRef.current.getBoundingClientRect();// Referencia al DOM para obtener el tamaño de la ventana y del mapa
        const x = e.clientX - rect.left;// Calcula las coordenadas en base a la distancia en pixeles desde la esquina superior izquierda del mapa (responsive)
        const y = e.clientY - rect.top;

        const quadrantX = x > rect.width / 2 ? 'left' : 'right';// Marca eje x central, si el raton está por encima el popup sale a la izquerda, si no a la derecha
        const quadrantY = y > rect.height / 2 ? 'top' : 'bottom';// Lo mismo para y pero arriba y abajo

        setMousePos({ x, y, quadrantX, quadrantY }); // Guarda los 4 valores anteriores para que el popup siga al raton de forma fluida
    };

    return (
        <div
            ref={containerRef}
            className="relative w-full max-w-6xl mx-auto rounded-xl overflow-hidden shadow-2xl border-4 border-[#2d3a3a] bg-[#1a1a1a]"
            onMouseMove={manejarMovimientoMouse}
        >
            {/* Imagen de fondo */}
            <img
                src="/img/mapa/fondo.png"
                className="w-full h-auto block select-none pointer-events-none"
                alt="Mapa Zoologic"
            />

            {/* Puntos de interés */}
            {zonas.map((zona) => (
                <div
                    key={zona.id}
                    className="absolute w-10 h-10 -translate-x-1/2 -translate-y-1/2 cursor-pointer group z-10"
                    style={{ top: zona.top, left: zona.left }}
                    // En escritorio sigue funcionando el hover
                    onMouseEnter={() => window.innerWidth > 768 && manejarHover(zona.id)}
                    onMouseLeave={() => window.innerWidth > 768 && setInfoZona(null)}
                    // En móvil y escritorio, el click manda (abre o redirige)
                    onClick={() => {
                        if (zona.id === 'Edificio') {
                            manejarClickZona(zona.id);
                        } else {
                            manejarHover(zona.id);
                        }
                    }}
                >
                    <div className="absolute inset-0 bg-yellow-400 rounded-full animate-ping opacity-30"></div>
                    <div className="relative w-full h-full bg-white/20 hover:bg-yellow-400/50 border-2 border-white rounded-full transition-all duration-300 shadow-lg flex items-center justify-center">
                        <span className="text-white font-bold text-sm">
                            {zona.id === 'Edificio' ? '🛒' : '?'}
                        </span>
                    </div>
                </div>
            ))}

            {/* Popup Dinámico e Inteligente - ADAPTACIÓN RESPONSIVE */}
            {infoZona && (
                <div
                    className={`
                        /* Desktop: Flotante */
                        absolute z-[100] bg-white/95 backdrop-blur-md shadow-2xl rounded-2xl p-0 ring-1 ring-black/5 transition-all duration-200 ease-out flex flex-col
                        
                        /* Mobile: Panel inferior fijo (Drawer) */
                        max-md:fixed max-md:bottom-0 max-md:left-0 max-md:right-0 max-md:w-full 
                        max-md:rounded-t-[2rem] max-md:rounded-b-none max-md:h-[60vh] max-md:z-[1000]
                        max-md:pointer-events-auto max-md:shadow-[0_-10px_40px_rgba(0,0,0,0.3)]
                    `}
                    style={window.innerWidth > 768 ? {
                        left: mousePos.x,
                        top: mousePos.y,
                        width: '320px',
                        height: infoZona.isSpecial ? 'auto' : '350px',
                        minHeight: infoZona.isSpecial ? '160px' : '350px',
                        transform: `translate(${mousePos.quadrantX === 'left' ? '-110%' : '10%'}, ${mousePos.quadrantY === 'top' ? '-105%' : '5%'})`,
                        pointerEvents: 'none'
                    } : {
                        /* Estilos para anular transformaciones en móvil */
                        bottom: 0,
                        left: 0,
                        transform: 'none'
                    }}
                >
                    {/* BOTÓN CERRAR (Solo visible en móviles) */}
                    <div className="md:hidden flex justify-center py-3 shrink-0">
                        <button
                            onClick={() => setInfoZona(null)}
                            className="bg-gray-200 text-gray-500 px-6 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"
                        >
                            Cerrar info
                        </button>
                    </div>

                    {/* CABECERA (Fija) */}
                    <div className={`${infoZona.isSpecial ? 'bg-amber-500' : 'bg-green-600'} px-4 py-3 shrink-0 z-20 rounded-t-2xl max-md:rounded-none shadow-sm`}>
                        <h3 className="text-white font-black uppercase tracking-tighter text-lg leading-none">
                            {infoZona.type}
                        </h3>
                        {infoZona.dimensions_m2 !== "N/A" && (
                            <p className="text-green-100 text-[10px] font-bold uppercase mt-1">
                                📍 {infoZona.dimensions_m2} m² de hábitat
                            </p>
                        )}
                    </div>

                    {/* CUERPO (Contenedor que corta el contenido) */}
                    <div className="flex-1 overflow-hidden-container bg-white relative rounded-b-2xl max-md:overflow-y-auto">

                        {/* DIV ANIMADO: En móvil quita la animación de scroll para permitir scroll táctil manual */}
                        <div className={`p-4 ${window.innerWidth > 768 && ((infoZona.animals?.length || 0) + (infoZona.experiences?.length || 0) + (infoZona.events?.length || 0)) > 5 ? 'animate-scroll' : ''}`}>

                            {/* --- SECCIÓN DE EVENTOS Y ALERTAS --- */}
                            {infoZona.events && infoZona.events.length > 0 && (
                                <div className="mb-4 space-y-2">
                                    {infoZona.events.map((evento, i) => (
                                        <div
                                            key={i}
                                            className={`p-2 rounded-xl border-l-4 shadow-sm animate-pulse ${evento.level === 'peligro' ? 'bg-red-50 border-red-500 text-red-900' :
                                                evento.level === 'alerta' ? 'bg-amber-50 border-amber-500 text-amber-900' :
                                                    'bg-green-50 border-green-500 text-green-900'
                                                }`}
                                        >
                                            <div className="flex items-center gap-2 mb-0.5">
                                                <span className="text-[10px] font-black uppercase tracking-wider">
                                                    {evento.level === 'peligro' ? '⚠️' : evento.level === 'alerta' ? '🔔' : 'ℹ️'} {evento.title}
                                                </span>
                                            </div>
                                            <p className="text-[9px] leading-tight font-medium opacity-90">
                                                {evento.message}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            )}

                            <p className={`text-gray-600 text-xs italic mb-4 leading-tight border-l-2 ${infoZona.isSpecial ? 'border-amber-400' : 'border-green-200'} pl-2`}>
                                "{infoZona.description}"
                            </p>

                            {/* Sección Animales */}
                            {infoZona.animals?.length > 0 && (
                                <div className="space-y-2">
                                    <span className="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">
                                        Animales en zona ({infoZona.animals?.length || 0})
                                    </span>

                                    <div className="grid grid-cols-2 gap-2">
                                        {infoZona.animals && infoZona.animals.map((animal, i) => (
                                            <div
                                                key={i}
                                                className="bg-gray-50 text-gray-700 text-[10px] px-2 py-2 rounded-lg border border-gray-100 font-semibold flex items-center gap-1.5 shadow-sm"
                                            >
                                                <span className="shrink-0 text-xs">🐾</span>
                                                <span className="truncate">{animal.name}</span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {/* SECCIÓN DE EXPERIENCIAS */}
                            {infoZona.experiences && infoZona.experiences.length > 0 && (
                                <div className="mt-5 pt-3 border-t border-dashed border-gray-200 space-y-2">
                                    <span className="text-[10px] font-black text-amber-500 uppercase tracking-widest block">
                                        Experiencias VIP ✨
                                    </span>
                                    <div className="flex flex-col gap-2">
                                        {infoZona.experiences.map((exp, i) => (
                                            <div
                                                key={i}
                                                className="flex justify-between items-center bg-amber-50/50 border border-amber-100 rounded-lg px-3 py-2 shadow-sm"
                                            >
                                                <div>
                                                    <p className="text-[11px] font-bold text-amber-900 leading-none">{exp.name}</p>
                                                    <p className="text-[9px] text-amber-700 mt-1">{exp.duration} min</p>
                                                </div>
                                                <span className="text-[11px] font-black text-amber-600 bg-white px-2 py-0.5 rounded-full border border-amber-200">
                                                    {exp.price}€
                                                </span>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {/* Aviso visual para la tienda */}
                            {infoZona.isSpecial && (
                                <div className="mt-2 text-center animate-bounce">
                                    <span className="text-[10px] font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                                        Clic para ver productos 🛒
                                    </span>
                                </div>
                            )}
                        </div>
                    </div>

                    {/* FOOTER (Fijo) */}
                    <div className="bg-gray-50 px-4 py-2 border-t border-gray-100 flex justify-between items-center shrink-0 rounded-b-2xl z-20">
                        <span className="text-[9px] font-bold text-green-700 uppercase tracking-tighter">Zoologic Auto-Scan</span>
                        <div className="flex gap-1">
                            <div className={`w-1.5 h-1.5 ${infoZona.isSpecial ? 'bg-amber-500' : 'bg-green-500'} rounded-full animate-pulse`}></div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default MapaZoologic;