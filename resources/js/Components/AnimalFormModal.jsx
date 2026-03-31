import React, { useState } from "react";

export default function AnimalFormModal({ isOpen, onClose, onSave, zones = [] }) {
    const initialState = {
        zone_id: "",
        common_name: "",
        species: "",
        birth_date: "",
        image: "",
        curiosity: "",
        diet: "",
    };

    const [formData, setFormData] = useState(initialState);

    if (!isOpen) return null;

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData((prev) => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSave(formData);
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 animate-fade-in">
            {/* Fondo oscuro desenfocado */}
            <div
                className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
                onClick={onClose}
            ></div>

            {/* Contenedor del Modal */}
            <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden">

                {/* Cabecera */}
                <div className="bg-teal-600 px-6 py-4 flex justify-between items-center">
                    <h2 className="text-lg font-black text-white flex items-center gap-2">
                        <i className="fa-solid fa-paw"></i> Registrar Nuevo Animal
                    </h2>
                    <button onClick={onClose} className="text-teal-100 hover:text-white transition-colors">
                        <i className="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                {/* Formulario */}
                <form onSubmit={handleSubmit} className="p-6 overflow-y-auto max-h-[75vh]">
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

                        {/* Zona (Dinámica) */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Zona Asignada *</label>
                            <select name="zone_id" required value={formData.zone_id} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 appearance-none cursor-pointer">
                                <option value="" disabled>Selecciona una zona...</option>
                                {zones.map(zone => (
                                    <option key={zone.id} value={zone.id}>{zone.type}</option>
                                ))}
                            </select>
                        </div>

                        {/* Fecha de Nacimiento */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha Nacimiento</label>
                            <input type="date" name="birth_date" value={formData.birth_date} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 text-slate-600" />
                        </div>

                        {/* Dieta */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Dieta</label>
                            <input type="text" name="diet" value={formData.diet} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ej: Carnívoro - 5kg/día" />
                        </div>

                        {/* URL Imagen */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">URL Fotografía</label>
                            <input type="text" name="image" value={formData.image} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400" placeholder="Ruta o enlace a la imagen" />
                        </div>

                        {/* Curiosidad (Ocupa 2 columnas) */}
                        <div className="space-y-1 md:col-span-2">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">Curiosidad / Nota</label>
                            <textarea name="curiosity" rows="2" value={formData.curiosity} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none" placeholder="Información relevante para visitantes o cuidadores..."></textarea>
                        </div>

                    </div>

                    {/* Botones Inferiores */}
                    <div className="mt-8 flex gap-3">
                        <button type="submit" className="flex-1 bg-teal-600 hover:bg-teal-700 text-white px-4 py-3.5 rounded-xl text-sm font-black shadow-md transition-colors flex justify-center items-center gap-2">
                            <i className="fa-solid fa-floppy-disk"></i> GUARDAR ANIMAL
                        </button>
                        <button type="button" onClick={onClose} className="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3.5 rounded-xl text-sm font-bold transition-colors">
                            CANCELAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
