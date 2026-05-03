import React, { useState, useEffect } from "react";
import NavigationModules from "./NavigationModules";
import GuideFormModal from "./GuideFormModal";
import Toast from './Toast';

export default function GuideDashboard() {
    const [experiencias, setExperiencias] = useState([]);
    const [guideInfo, setGuideInfo] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [isExperienceOpen, setIsExperienceOpen] = useState(false);
    const [zones, setZones] = useState([]);
    const [editingExp, setEditingExp] = useState(null);
    const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
    const [expToDelete, setExpToDelete] = useState(null);

    // Estados del Toast
    const [toastMessage, setToastMessage] = useState("");
    const [toastType, setToastType] = useState("success");

    const showToast = (message, type = "success") => {
        setToastMessage(message);
        setToastType(type);
    };

    useEffect(() => {
        fetch("/api/guide/data")
            .then((res) => res.json())
            .then((data) => {
                setGuideInfo(data.guide);
                setExperiencias(data.experiencias || []);
                setZones(data.zones || []);
                setIsLoading(false);
            })
            .catch((err) => {
                console.error("Error cargando datos:", err);
                setIsLoading(false);
            });
    }, []);

    const handleDeleteExperience = () => {
        if (!expToDelete) return;

        fetch(`/api/guide/experience/${expToDelete.id}`, {
            method: "DELETE",
            headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content },
        })
        .then((res) => {
            if(res.ok) {
                setExperiencias((prev) => prev.filter((e) => e.id !== expToDelete.id));
                showToast("Experiencia eliminada correctamente.", "success");
            } else {
                showToast("No se pudo eliminar la experiencia.", "error");
            }
        })
        .catch(() => showToast("Fallo de red al eliminar.", "error"))
        .finally(() => {
            setShowDeleteConfirm(false);
            setExpToDelete(null);
        });
    };

    if (isLoading) {
        return (
            <div className="min-h-screen flex justify-center items-center bg-slate-50">
                <i className="fa-solid fa-circle-notch fa-spin text-4xl text-orange-500"></i>
            </div>
        );
    }

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12 relative">
            {/* BARRA SUPERIOR */}
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-orange-500 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-map-signs"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-orange-500">Pro</span> Guía
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
                    <button
                        onClick={() => {
                            setEditingExp(null);
                            setIsExperienceOpen(true);
                        }}
                        className="w-full bg-orange-500 hover:bg-orange-600 text-white px-5 py-4 rounded-2xl font-black shadow-md transition-all flex justify-center items-center gap-3"
                    >
                        <i className="fa-solid fa-plus"></i> NUEVA EXPERIENCIA
                    </button>
                    <div className="bg-white px-5 py-4 rounded-3xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div className="w-12 h-12 bg-orange-50 text-orange-500 rounded-xl flex items-center justify-center font-black text-xl">
                            <i className="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <p className="text-xs font-black text-slate-400 uppercase tracking-widest">Guía de Zona</p>
                            <p className="text-sm font-bold text-slate-800">
                                {guideInfo?.name} {guideInfo?.surname}
                            </p>
                        </div>
                    </div>
                    <NavigationModules currentPanel="Guía" />
                </aside>

                <section className="flex-1">
                    {experiencias.length === 0 ? (
                        <div className="bg-white p-12 text-center rounded-3xl border border-slate-200 shadow-sm">
                            <i className="fa-solid fa-route text-4xl text-slate-300 mb-4 block"></i>
                            <p className="text-slate-500 font-bold">No hay experiencias asignadas a tu zona actual.</p>
                        </div>
                    ) : (
                        <div>
                            <h2 className="text-sm font-black text-orange-500 uppercase tracking-widest mb-6">
                                <i className="fa-solid fa-map mr-2"></i>
                                {guideInfo?.position === "Administrador" ? " Todas las Experiencias (Admin)" : " Experiencias de mi Zona"}
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {experiencias.map((exp) => (
                                    <div key={exp.id} className="relative bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-shadow">
                                        <div className="absolute top-4 right-4 flex gap-2">
                                            <button
                                                onClick={() => {
                                                    setEditingExp(exp);
                                                    setIsExperienceOpen(true);
                                                }}
                                                className="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm"
                                            >
                                                <i className="fa-solid fa-pen"></i>
                                            </button>

                                            {/* BOTON DE ELIMINAR */}
                                            <button
                                                onClick={() => {
                                                    setExpToDelete(exp);
                                                    setShowDeleteConfirm(true);
                                                }}
                                                className="w-8 h-8 flex items-center justify-center rounded-lg bg-red-50 hover:bg-red-100 text-red-500 text-sm"
                                            >
                                                <i className="fa-solid fa-trash"></i>
                                            </button>
                                        </div>

                                        <div className="mb-3 inline-flex items-center gap-1.5 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg border border-slate-200">
                                            <i className="fa-solid fa-map-location-dot text-slate-400"></i>
                                            Zona {exp.zone?.id} - {exp.zone?.type}
                                        </div>

                                        <h3 className="text-xl font-black text-slate-800 mb-2">{exp.name}</h3>
                                        <p className="text-sm text-slate-600 mb-4 line-clamp-3">
                                            {exp.description || "Sin descripción disponible."}
                                        </p>
                                        <div className="flex justify-between items-center text-xs font-bold text-slate-500 bg-slate-50 p-3 rounded-xl border border-slate-100">
                                            <span><i className="fa-regular fa-clock text-orange-400"></i> {exp.duration_min} min</span>
                                            <span><i className="fa-solid fa-users text-orange-400"></i> Máx. {exp.capacity} pers.</span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}
                </section>
            </main>

            {isExperienceOpen && (
                <GuideFormModal
                    isOpen={isExperienceOpen}
                    onClose={() => setIsExperienceOpen(false)}
                    zones={zones}
                    initialData={editingExp}
                    onSave={async (data) => {
                        try {
                            const isEdit = !!editingExp;
                            const url = isEdit ? `/api/guide/experience/${editingExp.id}` : "/api/guide/experience";
                            const method = isEdit ? "PUT" : "POST";

                            const res = await fetch(url, {
                                method,
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content,
                                },
                                body: JSON.stringify(data),
                            });

                            if (!res.ok) {
                                const err = await res.json();
                                showToast(err.message || "Error guardando experiencia", "error");
                                return;
                            }

                            const savedData = await res.json();
                            const savedExp = savedData.experience || savedData;

                            setExperiencias((prev) =>
                                isEdit
                                    ? prev.map((e) => (e.id === savedExp.id ? savedExp : e))
                                    : [...prev, savedExp]
                            );

                            setIsExperienceOpen(false);
                            setEditingExp(null);
                            showToast(isEdit ? "Experiencia actualizada con éxito." : "Experiencia creada con éxito.", "success");

                        } catch (e) {
                            showToast("Error de conexión con el servidor", "error");
                        }
                    }}
                />
            )}

            {/* MODAL DE CONFIRMACIoN DE ELIMINACION */}
            {showDeleteConfirm && (
                <div className="fixed inset-0 z-[200] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in">
                    <div className="bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 text-center border border-slate-200">
                        <div className="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                            <i className="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <h2 className="text-xl font-black text-slate-800 mb-2">¿Eliminar experiencia?</h2>
                        <p className="text-slate-500 text-sm mb-6">
                            Estás a punto de eliminar la experiencia <strong className="text-slate-700">{expToDelete?.name}</strong>. Esta acción es irreversible.
                        </p>
                        <div className="flex gap-3">
                            <button
                                onClick={() => {
                                    setShowDeleteConfirm(false);
                                    setExpToDelete(null);
                                }}
                                className="flex-1 px-4 py-3 border border-slate-200 text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs uppercase tracking-widest"
                            >
                                Cancelar
                            </button>
                            <button
                                onClick={handleDeleteExperience}
                                className="flex-1 px-4 py-3 bg-red-500 text-white font-black rounded-xl hover:bg-red-600 shadow-lg shadow-red-100 transition-all text-xs uppercase tracking-widest flex justify-center items-center gap-2"
                            >
                                <i className="fa-solid fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            )}

            <Toast
                message={toastMessage}
                type={toastType}
                onClose={() => setToastMessage("")}
            />
        </div>
    );
}
