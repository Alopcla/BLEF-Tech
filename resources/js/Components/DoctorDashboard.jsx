import React, { useState, useEffect } from "react";
import NavigationModules from "./NavigationModules";
import AnimalFormModal from "./AnimalFormModal"; // Formulario de Animal

const formatearFechaYHora = (fechaIso) => {
        if (!fechaIso) return "Sin registro";
        const fecha = new Date(fechaIso);
        return fecha.toLocaleString("es-ES", {
            day: "2-digit",
            month: "2-digit",
            year: "numeric",
            hour: "2-digit",
            minute: "2-digit",
        });
    };

export default function DoctorDashboard() {
    // --- ESTADOS ---
    const [animals, setAnimals] = useState([]);
    const [doctorInfo, setDoctorInfo] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [zones, setZones] = useState([]); // <-- Dinámico desde el controlador

    // Estados de modales
    const [selectedAnimal, setSelectedAnimal] = useState(null);
    const [isDrawerOpen, setIsDrawerOpen] = useState(false);
    const [isAnimalFormOpen, setIsAnimalFormOpen] = useState(false); // <-- Estado del nuevo modal

    // --- CARGA DE DATOS ---
    useEffect(() => {
        fetch("/api/medico/datos")
            .then((res) => res.json())
            .then((data) => {
                setDoctorInfo(data.doctor);
                setAnimals(data.animals);
                setZones(data.zones || []); // Guardamos las zonas
                setIsLoading(false);
            })
            .catch((err) =>
                console.error("Error cargando datos médicos:", err),
            );
    }, []);

    // --- ACCIONES ---
    const openAnimalRecord = (animal) => {
        setSelectedAnimal(animal);
        setIsDrawerOpen(true);
    };

    const handleSaveAnimal = async (animalData) => {
        try {
            const response = await fetch("/api/medico/animal", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(animalData),
            });

            if (response.ok) {
                alert("Animal registrado con éxito.");
                window.location.reload();
            } else {
                const err = await response.json();
                alert("Error: " + (err.message || "Fallo al guardar"));
            }
        } catch (error) {
            alert("Fallo de conexión al guardar el animal.");
        }
    };

    const handleDeleteAnimal = async (animalId) => {
        if (
            !window.confirm(
                "⚠️ ¿Estás seguro de que quieres eliminar este animal y todo su historial médico? Esta acción no se puede deshacer.",
            )
        ) {
            return;
        }

        try {
            const response = await fetch(`/api/medico/animal/${animalId}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    Accept: "application/json",
                },
            });

            if (response.ok) {
                alert("Animal eliminado correctamente.");
                window.location.reload();
            } else {
                alert("Error al intentar eliminar el animal.");
            }
        } catch (error) {
            alert("Fallo de conexión.");
        }
    };

    // --- RENDERIZADO CONDICIONAL DE CARGA ---
    if (isLoading) {
        return (
            <div className="min-h-screen flex justify-center items-center bg-slate-50">
                <i className="fa-solid fa-circle-notch fa-spin text-4xl text-teal-600"></i>
            </div>
        );
    }

    // --- VISTA PRINCIPAL ---
    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12">
            {/* BARRA SUPERIOR */}
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    {/* LOGO */}
                    <div className="flex items-center gap-3">
                        <div className="bg-teal-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-stethoscope"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-teal-600">Pro</span> Doctor
                        </h1>
                    </div>

                    {/* BOTONES DERECHA: Inicio + Desconectar */}
                    <div className="flex items-center gap-4">
                        {/* 🌟 EL BOTÓN MÁGICO PARA VOLVER A LARAVEL 🌟 */}
                        <a
                            href="/"
                            className="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2"
                        >
                            <i className="fa-solid fa-house"></i>
                            Inicio
                        </a>

                        <form method="POST" action="/logout" className="m-0">
                            <input
                                type="hidden"
                                name="_token"
                                value={
                                    document.querySelector(
                                        'meta[name="csrf-token"]',
                                    )?.content
                                }
                            />
                            <button
                                type="submit"
                                className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2"
                            >
                                <i className="fa-solid fa-power-off"></i>{" "}
                                Desconectar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                {/* COLUMNA IZQUIERDA */}
                <aside className="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-6">
                    {/* Botón Nuevo Animal */}
                    <button
                        onClick={() => setIsAnimalFormOpen(true)}
                        className="w-full bg-teal-600 hover:bg-teal-700 text-white px-5 py-4 rounded-2xl font-black shadow-md transition-all flex justify-center items-center gap-3"
                    >
                        <i className="fa-solid fa-plus text-lg"></i> NUEVO
                        ANIMAL
                    </button>

                    {/* Ficha del Médico Actual */}
                    <div className="bg-white px-5 py-4 rounded-3xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div className="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center font-black text-xl">
                            <i className="fa-solid fa-user-doctor"></i>
                        </div>
                        <div>
                            <p className="text-xs font-black text-slate-400 uppercase tracking-widest">
                                Zona:{" "}
                                {doctorInfo?.zone_id
                                    ? `${doctorInfo.zone_id}`
                                    : "General"}
                            </p>
                            <p className="text-sm font-bold text-slate-800">
                                {doctorInfo?.name} {doctorInfo?.surname}
                            </p>
                        </div>
                    </div>

                    {/* NAVEGACIÓN */}
                    <NavigationModules currentPanel="Médico" />
                </aside>

                {/* COLUMNA DERECHA: TARJETAS DE ANIMALES */}
                <section className="flex-1">
                    {animals.length === 0 ? (
                        <div className="bg-white p-12 text-center rounded-3xl border border-slate-200 shadow-sm">
                            <i className="fa-solid fa-paw text-4xl text-slate-300 mb-4 block"></i>
                            <p className="text-slate-500 font-bold">
                                No hay animales registrados en tu zona actual.
                            </p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            {animals.map((animal) => (
                                <div
                                    key={animal.id}
                                    onClick={() => openAnimalRecord(animal)}
                                    className="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group flex flex-col justify-between"
                                >
                                    <div>
                                        <div className="flex justify-between items-start mb-4">
                                            <div className="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors">
                                                <i className="fa-solid fa-paw text-2xl"></i>
                                            </div>
                                        </div>
                                        <h3 className="text-xl font-black text-slate-800">
                                            {animal.common_name || animal.name}
                                        </h3>
                                        <p className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">
                                            {animal.species}
                                        </p>
                                    </div>

                                    <div className="pt-4 border-t border-slate-100 flex justify-between items-center text-sm text-slate-500 font-medium">
                                        <span>
                                            <i className="fa-regular fa-clock mr-1"></i>{" "}
                                            {animal.medical_records?.length ||
                                                0}{" "}
                                            Registros
                                        </span>
                                        <span className="text-teal-600 font-bold group-hover:translate-x-1 transition-transform">
                                            Ver ficha{" "}
                                            <i className="fa-solid fa-arrow-right text-xs"></i>
                                        </span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </section>
            </main>

            {/* MODALES FLOTANTES */}
            <AnimalFormModal
                isOpen={isAnimalFormOpen}
                onClose={() => setIsAnimalFormOpen(false)}
                onSave={handleSaveAnimal}
                zones={zones}
            />

            {/* MODALES FLOTANTES */}
            <MedicalRecordDrawer
                isOpen={isDrawerOpen}
                onClose={() => setIsDrawerOpen(false)}
                animal={selectedAnimal}
                onDelete={handleDeleteAnimal} // <--- AÑADE ESTA LÍNEA
            />
        </div>
    );
}

// --- SUB-COMPONENTE: EL DRAWER MÉDICO ---
function MedicalRecordDrawer({ isOpen, onClose, animal, onDelete }) {
    const [isAddingMode, setIsAddingMode] = useState(false);
    const [newRecord, setNewRecord] = useState({
        diagnosis: "",
        treatment: "",
    });

    if (!animal) return null;

    const handleClose = () => {
        setIsAddingMode(false);
        setNewRecord({ diagnosis: "", treatment: "" });
        onClose();
    };

    const handleSave = async () => {
        if (!newRecord.diagnosis || !newRecord.treatment) {
            alert("Rellena el diagnóstico y el tratamiento.");
            return;
        }

        try {
            const response = await fetch("/api/medico/historial", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify({
                    animal_id: animal.id,
                    diagnosis: newRecord.diagnosis,
                    treatment: newRecord.treatment,
                }),
            });

            if (response.ok) {
                alert("Diagnóstico guardado correctamente.");
                window.location.reload();
            } else {
                const err = await response.json();
                alert("Error: " + (err.message || "Fallo al guardar"));
            }
        } catch (error) {
            console.error(error);
            alert("Error de conexión al guardar.");
        }
    };

    return (
        <>
            {isOpen && (
                <div
                    className="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-50 transition-opacity"
                    onClick={handleClose}
                ></div>
            )}

            <aside
                className={`fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-50 transform transition-transform duration-500 ease-out flex flex-col border-l border-slate-200 ${isOpen ? "translate-x-0" : "translate-x-full"}`}
            >
                <div className="bg-slate-50 p-6 relative border-b border-slate-200 shrink-0">
                    <div className="absolute top-4 right-4 flex gap-2">
                        <button
                            onClick={() => onDelete(animal.id)}
                            className="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-red-200 text-red-500 hover:bg-red-500 hover:text-white transition-all shadow-sm"
                            title="Eliminar Animal"
                        >
                            <i className="fa-solid fa-trash-can"></i>
                        </button>
                        <button
                            onClick={handleClose}
                            className="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:text-slate-700 transition-all shadow-sm"
                            title="Cerrar"
                        >
                            <i className="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div className="flex items-center gap-4 mt-2">
                        <div className="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-inner bg-teal-50 text-teal-600 ring-4 ring-white shrink-0">
                            <i className="fa-solid fa-paw"></i>
                        </div>
                        <div>
                            <h2 className="text-2xl font-black text-slate-800">
                                {animal.common_name || animal.name}
                            </h2>
                            <p className="text-slate-500 text-xs font-mono font-bold tracking-widest uppercase">
                                {animal.species}
                            </p>
                        </div>
                    </div>
                </div>

                <div className="flex-grow overflow-y-auto p-6 bg-white">
                    {!isAddingMode ? (
                        <div className="space-y-6">
                            <div className="flex justify-between items-end border-b border-slate-100 pb-2">
                                <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest">
                                    Historial Clínico
                                </h3>
                                <span className="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-1 rounded-md">
                                    {animal.medical_records?.length || 0}{" "}
                                    Entradas
                                </span>
                            </div>

                            <div className="space-y-4">
                                {animal.medical_records?.map((record) => (
                                    <div
                                        key={record.id}
                                        className="bg-slate-50 border border-slate-200 rounded-2xl p-4"
                                    >
                                        <div className="flex items-center justify-between mb-3">
                                            <div className="flex items-center gap-2">
                                                <i className="fa-solid fa-calendar-day text-teal-500"></i>
                                                <span className="text-xs font-bold text-slate-600 font-mono">
                                                    {formatearFechaYHora(record.created_at)}
                                                </span>
                                            </div>
                                            <span className="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                                DNI Médico:{" "}
                                                {record.employee_dni}
                                            </span>
                                        </div>
                                        <div className="space-y-3">
                                            <div>
                                                <p className="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">
                                                    Diagnóstico
                                                </p>
                                                <p className="text-sm text-slate-700">
                                                    {record.diagnosis}
                                                </p>
                                            </div>
                                            <div className="bg-white p-3 rounded-xl border border-slate-100">
                                                <p className="text-[10px] font-black text-teal-600 uppercase tracking-widest mb-1">
                                                    Tratamiento
                                                </p>
                                                <p className="text-sm text-slate-600">
                                                    {record.treatment}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    ) : (
                        <div className="space-y-5 animate-fade-in">
                            <h3 className="text-xs font-black text-teal-600 uppercase tracking-widest border-b border-teal-100 pb-2 mb-4">
                                <i className="fa-solid fa-file-medical mr-2"></i>
                                Nueva Evaluación Médica
                            </h3>

                            <div className="space-y-1">
                                <label className="text-[10px] font-black text-slate-400 uppercase">
                                    Diagnóstico Clínico
                                </label>
                                <textarea
                                    value={newRecord.diagnosis}
                                    onChange={(e) =>
                                        setNewRecord({
                                            ...newRecord,
                                            diagnosis: e.target.value,
                                        })
                                    }
                                    rows="4"
                                    className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none"
                                    placeholder="Describe los síntomas..."
                                ></textarea>
                            </div>

                            <div className="space-y-1">
                                <label className="text-[10px] font-black text-slate-400 uppercase">
                                    Tratamiento Recetado
                                </label>
                                <textarea
                                    value={newRecord.treatment}
                                    onChange={(e) =>
                                        setNewRecord({
                                            ...newRecord,
                                            treatment: e.target.value,
                                        })
                                    }
                                    rows="4"
                                    className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none"
                                    placeholder="Indica la medicación..."
                                ></textarea>
                            </div>
                        </div>
                    )}
                </div>

                <div className="p-6 border-t border-slate-100 bg-slate-50 shrink-0">
                    {!isAddingMode ? (
                        <button
                            onClick={() => setIsAddingMode(true)}
                            className="w-full bg-teal-600 text-white px-4 py-3.5 rounded-xl text-sm font-black shadow-lg shadow-teal-500/30 hover:bg-teal-700 transition-all flex justify-center items-center gap-2"
                        >
                            <i className="fa-solid fa-stethoscope"></i> AÑADIR
                            NUEVO DIAGNÓSTICO
                        </button>
                    ) : (
                        <div className="flex gap-3">
                            <button
                                onClick={handleSave}
                                className="flex-1 bg-teal-600 text-white px-4 py-3.5 rounded-xl text-sm font-black shadow-md hover:bg-teal-700 flex justify-center items-center gap-2 transition-colors"
                            >
                                <i className="fa-solid fa-floppy-disk"></i>{" "}
                                GUARDAR FICHA
                            </button>
                            <button
                                onClick={() => setIsAddingMode(false)}
                                className="flex-[0.5] bg-white border border-slate-200 text-slate-500 px-4 py-3.5 rounded-xl text-sm font-bold hover:bg-slate-100 transition-colors"
                            >
                                CANCELAR
                            </button>
                        </div>
                    )}
                </div>
            </aside>
        </>
    );
}
