import React, { useState, useEffect, useMemo } from "react";
import NavigationModules from "./NavigationModules";

// 1. FUNCIÓN GLOBAL A PRUEBA DE BOMBAS
const formatearFechaYHora = (fechaIso) => {
    if (!fechaIso) return "Sin registro";
    try {
        const fecha = new Date(fechaIso);
        if (isNaN(fecha.getTime())) return "Sin registro";
        return fecha.toLocaleString('es-ES', {
            day: '2-digit', month: '2-digit', year: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    } catch (error) {
        return "Sin registro";
    }
};

// 2. COMPONENTE PRINCIPAL
export default function KeeperDashboard() {
    const [animals, setAnimals] = useState([]);
    const [keeperInfo, setKeeperInfo] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [selectedAnimal, setSelectedAnimal] = useState(null);
    const [isDrawerOpen, setIsDrawerOpen] = useState(false);

    const today = new Date().toISOString().split("T")[0];

    useEffect(() => {
        fetch("/api/keeper/data")
            .then((res) => res.json())
            .then((data) => {
                setKeeperInfo(data.keeper);
                setAnimals(data.animals || []);
                setIsLoading(false);
            })
            .catch((err) => {
                console.error("Error al cargar:", err);
                setIsLoading(false);
            });
    }, []);

    // --- FILTROS 100% SEGUROS (Evitan el crash por nulos) ---
    const fedAnimals = useMemo(() => {
        if (!Array.isArray(animals)) return [];
        return animals.filter((animal) => {
            if (!animal || !animal.last_fed_date) return false;
            return String(animal.last_fed_date).includes(today);
        });
    }, [animals, today]);

    const pendingAnimals = useMemo(() => {
        if (!Array.isArray(animals)) return [];
        return animals.filter((animal) => {
            if (!animal || !animal.last_fed_date) return true;
            return !String(animal.last_fed_date).includes(today);
        });
    }, [animals, today]);

    const openAnimalCare = (animal) => {
        setSelectedAnimal(animal);
        setIsDrawerOpen(true);
    };

    if (isLoading) {
        return (
            <div className="min-h-screen flex justify-center items-center bg-slate-50">
                <i className="fa-solid fa-circle-notch fa-spin text-4xl text-lime-600"></i>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12">
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-lime-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-paw"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-lime-600">Pro</span> Keeper
                        </h1>
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="/" className="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                            <i className="fa-solid fa-house"></i> Inicio
                        </a>
                        <form method="POST" action="/logout" className="m-0">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                            <button type="submit" className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                                <i className="fa-solid fa-power-off"></i> Desconectar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                <aside className="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-6">
                    <div className="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
                        <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest">Resumen de Tareas</h3>
                        <div className="grid grid-cols-1 gap-3">
                            <div className="flex items-center justify-between p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center">
                                        <i className="fa-solid fa-check text-sm"></i>
                                    </div>
                                    <span className="text-sm font-bold text-emerald-800">Alimentados</span>
                                </div>
                                <span className="text-lg font-black text-emerald-600">{fedAnimals.length}</span>
                            </div>
                            <div className="flex items-center justify-between p-3 bg-amber-50 rounded-2xl border border-amber-100">
                                <div className="flex items-center gap-3">
                                    <div className="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center">
                                        <i className="fa-solid fa-clock text-sm"></i>
                                    </div>
                                    <span className="text-sm font-bold text-amber-800">Pendientes</span>
                                </div>
                                <span className="text-lg font-black text-amber-600">{pendingAnimals.length}</span>
                            </div>
                        </div>
                    </div>

                    <div className="bg-white px-5 py-4 rounded-3xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div className="w-12 h-12 bg-lime-50 text-lime-600 rounded-xl flex items-center justify-center font-black text-xl">
                            <i className="fa-solid fa-hand-holding-heart"></i>
                        </div>
                        <div>
                            <p className="text-xs font-black text-slate-400 uppercase tracking-widest">
                                Zona: {keeperInfo?.zone_id || "General"}
                            </p>
                            <p className="text-sm font-bold text-slate-800">
                                {keeperInfo?.name || "Cargando..."}
                            </p>
                        </div>
                    </div>

                    <NavigationModules currentPanel="Cuidador" />
                </aside>

                <section className="flex-1">
                    {animals.length === 0 ? (
                        <div className="bg-white p-12 text-center rounded-3xl border border-slate-200 shadow-sm">
                            <i className="fa-solid fa-bowl-food text-4xl text-slate-300 mb-4 block"></i>
                            <p className="text-slate-500 font-bold">No tienes animales asignados.</p>
                        </div>
                    ) : (
                        <div className="flex flex-col gap-10">
                            {pendingAnimals.length > 0 && (
                                <div>
                                    <div className="flex items-center gap-4 mb-6">
                                        <h2 className="text-sm font-black text-amber-500 uppercase tracking-widest">
                                            <i className="fa-solid fa-clock mr-2"></i> Pendientes ({pendingAnimals.length})
                                        </h2>
                                        <div className="h-px bg-amber-200 flex-1"></div>
                                    </div>
                                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                        {pendingAnimals.map((animal) => (
                                            <div key={animal?.id || Math.random()} onClick={() => openAnimalCare(animal)} className="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl transition-all cursor-pointer group">
                                                <div className="flex justify-between items-start mb-4">
                                                    <div className="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-lime-50 group-hover:text-lime-600">
                                                        <i className="fa-solid fa-paw text-2xl"></i>
                                                    </div>
                                                    <span className="bg-amber-50 text-amber-600 border border-amber-200 px-3 py-1 rounded-full text-[10px] font-black uppercase animate-pulse">
                                                        Pendiente
                                                    </span>
                                                </div>
                                                <h3 className="text-xl font-black text-slate-800">{animal?.common_name || animal?.name || 'Desconocido'}</h3>
                                                <p className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">{animal?.species || 'Sin especie'}</p>
                                                <div className="pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                                                    <span className="font-bold text-slate-500 italic">
                                                        <i className="fa-solid fa-scale-balanced mr-1"></i> {animal?.food_ration || "Sin ración"}
                                                    </span>
                                                    <span className="text-lime-600 font-black">
                                                        GESTIONAR <i className="fa-solid fa-arrow-right ml-1"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}

                            {fedAnimals.length > 0 && (
                                <div>
                                    <div className="flex items-center gap-4 mb-6">
                                        <h2 className="text-sm font-black text-emerald-500 uppercase tracking-widest">
                                            <i className="fa-solid fa-check-double mr-2"></i> Alimentados ({fedAnimals.length})
                                        </h2>
                                        <div className="h-px bg-emerald-200 flex-1"></div>
                                    </div>
                                    <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 opacity-75 hover:opacity-100 transition-opacity">
                                        {fedAnimals.map((animal) => (
                                            <div key={animal?.id || Math.random()} onClick={() => openAnimalCare(animal)} className="bg-white rounded-3xl p-6 border border-emerald-100 shadow-sm hover:shadow-md transition-all cursor-pointer group">
                                                <div className="flex justify-between items-start mb-4">
                                                    <div className="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                                                        <i className="fa-solid fa-paw text-2xl"></i>
                                                    </div>
                                                    <span className="bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-full text-[10px] font-black uppercase">
                                                        Finalizado
                                                    </span>
                                                </div>
                                                <h3 className="text-xl font-black text-slate-800">{animal?.common_name || animal?.name || 'Desconocido'}</h3>
                                                <p className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">{animal?.species || 'Sin especie'}</p>
                                                <div className="pt-4 border-t border-slate-100 flex justify-between items-center text-xs">
                                                    <span className="font-bold text-slate-500 italic">
                                                        <i className="fa-solid fa-scale-balanced mr-1"></i> {animal?.food_ration || "Sin ración"}
                                                    </span>
                                                    <span className="text-emerald-600 font-black">
                                                        VER FICHA <i className="fa-solid fa-arrow-right ml-1"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    )}
                </section>
            </main>

            <KeeperDrawer
                isOpen={isDrawerOpen}
                onClose={() => setIsDrawerOpen(false)}
                animal={selectedAnimal}
                today={today}
            />
        </div>
    );
}

// 3. COMPONENTE SECUNDARIO (EL MODAL DEL CUIDADOR)
function KeeperDrawer({ isOpen, onClose, animal, today }) {
    if (!animal) return null;

    // Filtro seguro para saber si se ha alimentado hoy
    const hasFedToday = animal?.last_fed_date ? String(animal.last_fed_date).includes(today) : false;

    const handleFeed = async () => {
        try {
            const response = await fetch("/api/keeper/feed", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({ animal_id: animal.id }),
            });
            if (response.ok) window.location.reload();
        } catch (error) {
            alert("Error de conexión al marcar como completado.");
        }
    };

    return (
        <>
            {isOpen && (
                <div className="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-50" onClick={onClose}></div>
            )}
            <aside className={`fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-50 transform transition-transform duration-500 flex flex-col ${isOpen ? "translate-x-0" : "translate-x-full"}`}>
                <div className="bg-slate-50 p-6 relative border-b border-slate-200">
                    <button onClick={onClose} className="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:bg-slate-200 transition-colors">
                        <i className="fa-solid fa-xmark"></i>
                    </button>
                    <div className="flex items-center gap-4 mt-2">
                        <div className="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl bg-lime-50 text-lime-500 shadow-inner">
                            <i className="fa-solid fa-utensils"></i>
                        </div>
                        <div>
                            <h2 className="text-2xl font-black text-slate-800">{animal?.common_name || 'Animal'}</h2>
                            <p className="text-slate-500 text-xs font-bold uppercase tracking-widest">{animal?.species}</p>
                        </div>
                    </div>
                </div>

                <div className="p-6 space-y-6 flex-grow overflow-y-auto">
                    <div className="bg-lime-50 border border-lime-100 rounded-2xl p-5">
                        <h3 className="text-[10px] font-black text-lime-600 uppercase tracking-widest mb-2">Ración Diaria</h3>
                        <p className="text-xl font-black text-lime-900">{animal?.food_ration || "No especificada"}</p>
                    </div>

                    <div className="bg-blue-50 border border-blue-100 rounded-2xl p-5">
                        <h3 className="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2 text-left">Tipo de Dieta</h3>
                        <p className="text-lg font-bold text-blue-900">{animal?.diet || "No especificada"}</p>
                    </div>

                    <div className="border-t border-slate-100 pt-6">
                        <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Último Registro</h3>
                        {animal?.last_fed_date ? (
                            <div className="bg-slate-50 p-4 rounded-xl border border-slate-200 flex justify-between items-center">
                                <span className="text-sm font-bold text-slate-700">
                                    <i className="fa-solid fa-calendar mr-2"></i>
                                    {formatearFechaYHora(animal.last_fed_date)}
                                </span>
                                <span className="text-[10px] font-black text-slate-400">
                                    CUIDADOR: {animal.last_fed_by || "ID desconocido"}
                                </span>
                            </div>
                        ) : (
                            <p className="text-sm text-slate-400 italic text-left">Sin registros previos.</p>
                        )}
                    </div>
                </div>

                <div className="p-6 bg-slate-50 border-t border-slate-100">
                    <button
                        onClick={handleFeed}
                        disabled={hasFedToday}
                        className={`w-full py-4 rounded-xl text-sm font-black transition-all flex justify-center items-center gap-2 ${hasFedToday ? "bg-slate-200 text-slate-400 cursor-not-allowed" : "bg-lime-500 text-white shadow-lg shadow-lime-500/30 hover:bg-lime-600"}`}
                    >
                        {hasFedToday ? (
                            <><i className="fa-solid fa-check-double"></i> TAREA FINALIZADA</>
                        ) : (
                            <><i className="fa-solid fa-utensils"></i> MARCAR COMO COMPLETADO</>
                        )}
                    </button>
                </div>
            </aside>
        </>
    );
}
