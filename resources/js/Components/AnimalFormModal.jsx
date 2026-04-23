import React, { useState } from "react";
import Toast from "./Toast"; // <--- 1. IMPORTAMOS NUESTRO COMPONENTE MÁGICO

const dietasDisponibles = [
    { value: "Carnívoro", label: "Carnívoro" },
    { value: "Herbívoro", label: "Herbívoro" },
    { value: "Omnívoro", label: "Omnívoro" },
    { value: "Insectívoro", label: "Insectívoro" },
    { value: "Piscívoro", label: "Piscívoro" },
];

export default function AnimalFormModal({
    isOpen,
    onClose,
    onSave,
    zones = [],
}) {
    const initialState = {
        zone_id: "",
        common_name: "",
        species: "",
        birth_date: "",
        image: "",
        curiosity: "",
        diet: "",
        food_ration: "",
    };

    const [formData, setFormData] = useState(initialState);
    const [mensajeExito, setMensajeExito] = useState(null);
    const [errorBackend, setErrorBackend] = useState(null);

    const hoy = new Date().toISOString().split("T")[0];

    if (!isOpen) return null;

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorBackend(null);

        try {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]')?.content;

            const response = await fetch("/api/animales", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify(formData),
            });

            const data = await response.json().catch(() => null);

            if (response.ok) {
                // Lanzamos el mensaje para que el Toast lo recoja
                setMensajeExito("¡El animal ha sido registrado correctamente!");

                // Esperamos 3 segundos (lo que dura el Toast en pantalla) para cerrar
                setTimeout(() => {
                    setMensajeExito(null);
                    if (typeof onSave === "function") onSave(data.data);
                    onClose();
                    setFormData(initialState);
                }, 3000);
            } else {
                if (response.status === 422 && data && data.errors) {
                    const primerError = Object.values(data.errors)[0][0];
                    setErrorBackend(primerError);
                } else {
                    setErrorBackend(data?.message || "Error interno del servidor.");
                }
            }
        } catch (error) {
            setErrorBackend("No se pudo conectar con el servidor.");
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 animate-fade-in">
            <div className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" onClick={onClose}></div>

            <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden">
                {/* Cabecera */}
                <div className="bg-teal-600 px-6 py-4 flex justify-between items-center">
                    <h2 className="text-lg font-black text-white flex items-center gap-2">
                        <i className="fa-solid fa-paw"></i> Registrar nuevo animal
                    </h2>
                    <button onClick={onClose} className="text-teal-100 hover:text-white transition-colors">
                        <i className="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form onSubmit={handleSubmit} className="p-6 overflow-y-auto max-h-[75vh]">
                    {/* BANDERÍN DE ERROR (Lo mantenemos inline porque es mejor UX para formularios) */}
                    {errorBackend && (
                        <div className="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl text-sm font-bold flex items-start gap-3 animate-fade-in shadow-sm">
                            <i className="bi bi-exclamation-triangle-fill text-lg mt-0.5"></i>
                            <div>
                                <p>No se pudo guardar el animal:</p>
                                <p className="font-normal text-red-600">{errorBackend}</p>
                            </div>
                        </div>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {/* Nombre Común */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nombre Común *</label>
                            <input type="text" name="common_name" required value={formData.common_name} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ej: León Africano" />
                        </div>

                        {/* Especie */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Especie *</label>
                            <input type="text" name="species" required value={formData.species} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ej: Panthera leo" />
                        </div>

                        {/* Zona */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Zona Asignada *</label>
                            <select name="zone_id" required value={formData.zone_id} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 appearance-none cursor-pointer">
                                <option value="" disabled>Selecciona una zona...</option>
                                {zones.map((zone) => (
                                    <option key={zone.id} value={zone.id}>{zone.type}</option>
                                ))}
                            </select>
                        </div>

                        {/* Fecha de Nacimiento */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha Nacimiento *</label>
                            <input type="date" name="birth_date" required max={hoy} value={formData.birth_date} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 text-slate-600" />
                        </div>

                        {/* Dieta */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipo de Dieta *</label>
                            <select name="diet" required value={formData.diet} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 appearance-none cursor-pointer">
                                <option value="" disabled>Selecciona una dieta...</option>
                                {dietasDisponibles.map((dieta) => (
                                    <option key={dieta.value} value={dieta.value}>{dieta.label}</option>
                                ))}
                            </select>
                        </div>

                        {/* URL Imagen */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">URL Fotografía</label>
                            <input type="text" name="image" value={formData.image} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ruta o enlace a la imagen" />
                        </div>

                        {/* Ración de Comida */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Ración de Comida *</label>
                            <input type="text" name="food_ration" required value={formData.food_ration} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ej: 5kg carne / 3 veces al día" />
                        </div>

                        {/* Curiosidad */}
                        <div className="space-y-1 md:col-span-2">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Curiosidad / Nota</label>
                            <textarea name="curiosity" rows="2" value={formData.curiosity} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none" placeholder="Información relevante para visitantes o cuidadores..."></textarea>
                        </div>
                    </div>

                    <div className="mt-8 flex gap-3">
                        <button type="submit" className="flex-1 bg-teal-600 hover:bg-teal-700 text-white px-4 py-3.5 rounded-xl text-sm font-black shadow-md transition-colors flex justify-center items-center gap-2">
                            <i className="fa-solid fa-floppy-disk"></i> GUARDAR ANIMAL
                        </button>
                        <button type="button" onClick={onClose} className="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3.5 rounded-xl text-sm font-bold transition-colors">
                            CANCELAR
                        </button>
                    </div>
                </form>

                {/* 2. SUSTITUIMOS EL HTML GIGANTE POR ESTA ÚNICA LÍNEA */}
                <Toast
                    message={mensajeExito}
                    type="success"
                    onClose={() => setMensajeExito(null)}
                />
            </div>
        </div>
    );
}
