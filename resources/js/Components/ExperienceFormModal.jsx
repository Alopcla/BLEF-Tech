import React, { useState, useEffect } from "react";

const generateSlug = (text) => {
    return text
        .toLowerCase()
        .trim()
        .replace(/ /g, "-")
        .replace(/[^\w-]+/g, "");
};

export default function ExperienceModal({
    isOpen,
    onClose,
    onSave,
    zones = [],
    initialData = null,
}) {
    const initialState = {
        zone_id: "",
        name: "",
        slug: "",
        description: "",
        details: "",
        duration_min: "",
        price: "",
        capacity: "",
        image: "",
    };

    const [formData, setFormData] = useState(initialState);

    useEffect(() => {
        if (isOpen) {
            setFormData(
                initialData
                    ? {
                        zone_id: initialData.zone_id || "",
                        name: initialData.name || "",
                        slug: initialData.slug || "",
                        description: initialData.description || "",
                        details: initialData.details || "",
                        duration_min: initialData.duration_min || "",
                        price: initialData.price || "",
                        capacity: initialData.capacity || "",
                        image: initialData.image || "",
                    }
                    : initialState
            );
        }
    }, [isOpen, initialData]);

    if (!isOpen) return null;

    const handleChange = (e) => {
        const { name, value } = e.target;

        setFormData((prev) => ({
            ...prev,
            [name]: value,
        }));
    };
    const handleNameChange = (e) => {
        const value = e.target.value;

        setFormData((prev) => ({
            ...prev,
            name: value,
            slug: generateSlug(value),
        }));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSave(formData);
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 animate-fade-in">
            {/* Fondo */}
            <div
                className="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
                onClick={onClose}
            ></div>

            {/* Modal */}
            <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden">

                {/* Header */}
                <div className="bg-orange-500 px-6 py-4 flex justify-between items-center">
                    <h2 className="text-lg font-black text-white flex items-center gap-2">
                        <i className="fa-solid fa-route"></i>
                        Nueva Experiencia
                    </h2>

                    <button
                        onClick={onClose}
                        className="text-orange-100 hover:text-white transition-colors"
                    >
                        <i className="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                {/* Form */}
                <form
                    onSubmit={handleSubmit}
                    className="p-6 overflow-y-auto max-h-[90vh]"
                >
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {/* Nombre */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Nombre *
                            </label>
                            <input
                                type="text"
                                name="name"
                                required
                                value={formData.name}
                                onChange={handleNameChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="Ej: Safari Nocturno"
                            />
                        </div>

                        {/* SLUG (oculto) */}
                        <input
                            type="hidden"
                            name="slug"
                            value={formData.slug}
                        />

                        {/* Zona */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Zona *
                            </label>
                            <select
                                name="zone_id"
                                required
                                value={formData.zone_id}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                            >
                                <option value="">Selecciona zona...</option>
                                {Array.isArray(zones) &&
                                    zones.map((zone) => (
                                        <option key={zone.id} value={zone.id}>
                                            {zone.type}
                                        </option>
                                ))}
                            </select>
                        </div>

                        {/* Duración */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Duración (min) *
                            </label>
                            <input
                                type="number"
                                name="duration_min"
                                required
                                value={formData.duration_min}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="Ej: 90"
                            />
                        </div>

                        {/* Precio */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Precio *
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                required
                                value={formData.price}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="Ej: 12.50"
                            />
                        </div>

                        {/* Capacidad */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Capacidad *
                            </label>
                            <input
                                type="number"
                                name="capacity"
                                required
                                value={formData.capacity}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="Ej: 20"
                            />
                        </div>

                        {/* Imagen */}
                        <div className="space-y-1 md:col-span-2">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Imagen URL
                            </label>
                            <input
                                type="text"
                                name="image"
                                value={formData.image}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400"
                                placeholder="https://..."
                            />
                        </div>

                        {/* Descripción */}
                        <div className="space-y-1 md:col-span-2">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Descripción
                            </label>
                            <textarea
                                name="description"
                                rows="2"
                                value={formData.description}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400 resize-none"
                            />
                        </div>

                        {/* Detalles */}
                        <div className="space-y-1 md:col-span-2">
                            <label className="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                Detalles
                            </label>
                            <textarea
                                name="details"
                                rows="3"
                                value={formData.details}
                                onChange={handleChange}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-orange-400 resize-none"
                            />
                        </div>
                    </div>

                    {/* Botones */}
                    <div className="mt-8 flex gap-3">
                        <button
                            type="submit"
                            className="flex-1 bg-orange-500 hover:bg-orange-600 text-white px-4 py-3.5 rounded-xl text-sm font-black shadow-md transition-colors flex justify-center items-center gap-2"
                        >
                            <i className="fa-solid fa-floppy-disk"></i>
                            GUARDAR EXPERIENCIA
                        </button>

                        <button
                            type="button"
                            onClick={onClose}
                            className="bg-slate-100 hover:bg-slate-200 text-slate-600 px-6 py-3.5 rounded-xl text-sm font-bold transition-colors"
                        >
                            CANCELAR
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}