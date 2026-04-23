import React, { useState } from 'react';

export default function EmployeeFormModal({ isOpen, onClose, zones, onSave, onShowToast }) {
    const initialState = {
        dni: '', name: '', surname: '', email: '',
        birth_date: '', address: '', province: '',
        position: '', zone_id: '', telephone: ''
    };

    const [formData, setFormData] = useState(initialState);
    const [fieldErrors, setFieldErrors] = useState({}); // <--- Errores debajo de los inputs
    const [generalError, setGeneralError] = useState(null); // <--- Banderín rojo

    if (!isOpen) return null;

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setFieldErrors({});
        setGeneralError(null);

        try {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]')?.content;

            // Asegúrate de que la ruta "/registrar-nuevo-empleado" coincide con tu web.php
            const response = await fetch("/registrar-nuevo-empleado", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken
                },
                body: JSON.stringify(formData),
            });

            const data = await response.json().catch(() => null);

            if (response.ok) {
                // Notificamos al Dashboard
                if (onShowToast) onShowToast("Empleado registrado correctamente.", "success");

                // Recargamos o actualizamos la lista
                if (typeof onSave === 'function') onSave(data);

                onClose();
                setFormData(initialState);
            } else {
                // Si Laravel devuelve error de validación
                if (response.status === 422 && data && data.errors) {
                    setFieldErrors(data.errors);
                } else {
                    setGeneralError(data?.message || "Error interno del servidor.");
                }
            }
        } catch (error) {
            setGeneralError("No se pudo conectar con el servidor.");
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm animate-fade-in">
            <div className="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200">

                <div className="bg-slate-50 px-8 py-5 border-b border-slate-200 flex justify-between items-center">
                    <h2 className="text-xl font-black text-slate-800 uppercase tracking-tight">Nuevo Registro de Personal</h2>
                    <button onClick={onClose} className="text-slate-400 hover:text-red-500 transition-colors">
                        <i className="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form onSubmit={handleSubmit} className="p-8 overflow-y-auto max-h-[80vh]">

                    {/* BANDERÍN DE ERROR GENERAL */}
                    {generalError && (
                        <div className="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r-xl text-sm font-bold flex items-start gap-3 shadow-sm">
                            <i className="fa-solid fa-triangle-exclamation text-lg mt-0.5"></i>
                            <p>{generalError}</p>
                        </div>
                    )}

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-5">
                        {/* DNI / NIE */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">DNI / NIE *</label>
                            <input
                                required
                                name="dni"
                                value={formData.dni}
                                onChange={handleChange}
                                className={`w-full bg-slate-50 border rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 ${fieldErrors.dni ? 'border-red-500 focus:ring-red-400' : 'border-slate-200 focus:ring-blue-500'}`}
                            />
                            {/* ALERTA ROJA DEBAJO DEL INPUT */}
                            {fieldErrors.dni && (
                                <p className="text-red-500 text-[11px] font-bold mt-1">
                                    <i className="fa-solid fa-circle-exclamation mr-1"></i>{fieldErrors.dni[0]}
                                </p>
                            )}
                        </div>

                        {/* Correo Electrónico */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Correo electrónico *</label>
                            <input
                                required
                                type="email"
                                name="email"
                                value={formData.email}
                                onChange={handleChange}
                                className={`w-full bg-slate-50 border rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 ${fieldErrors.email ? 'border-red-500 focus:ring-red-400' : 'border-slate-200 focus:ring-blue-500'}`}
                            />
                            {fieldErrors.email && (
                                <p className="text-red-500 text-[11px] font-bold mt-1">
                                    <i className="fa-solid fa-circle-exclamation mr-1"></i>{fieldErrors.email[0]}
                                </p>
                            )}
                        </div>

                        {/* Nombre */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Nombre *</label>
                            <input required name="name" value={formData.name} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        {/* Apellidos */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Apellidos *</label>
                            <input required name="surname" value={formData.surname} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        {/* Teléfono de contacto */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Teléfono de contacto *</label>
                            <input
                                required
                                type="tel"
                                name="telephone"
                                value={formData.telephone}
                                onChange={handleChange}
                                className={`w-full bg-slate-50 border rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 ${fieldErrors.telephone ? 'border-red-500 focus:ring-red-400' : 'border-slate-200 focus:ring-blue-500'}`}
                                placeholder="Ej: 600123456"
                            />
                            {fieldErrors.telephone && (
                                <p className="text-red-500 text-[11px] font-bold mt-1">
                                    <i className="fa-solid fa-circle-exclamation mr-1"></i>{fieldErrors.telephone[0]}
                                </p>
                            )}
                        </div>

                        {/* Fecha de Nacimiento */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Fecha de Nacimiento *</label>
                            <input
                                required
                                type="date"
                                name="birth_date"
                                value={formData.birth_date}
                                onChange={handleChange}
                                className={`w-full bg-slate-50 border rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 ${fieldErrors.birth_date ? 'border-red-500 focus:ring-red-400' : 'border-slate-200 focus:ring-blue-500'}`}
                            />
                            {fieldErrors.birth_date && (
                                <p className="text-red-500 text-[11px] font-bold mt-1">
                                    <i className="fa-solid fa-circle-exclamation mr-1"></i>{fieldErrors.birth_date[0]}
                                </p>
                            )}
                        </div>

                        {/* Posición / Cargo */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Posición / Cargo *</label>
                            <select required name="position" value={formData.position} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled>Seleccionar...</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Médico">Médico</option>
                                <option value="Cuidador">Cuidador</option>
                                <option value="Guía">Guía</option>
                            </select>
                        </div>

                        {/* Zona de Trabajo */}
                        <div className="space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Zona de Trabajo *</label>
                            <select required name="zone_id" value={formData.zone_id} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="" disabled>Seleccionar zona...</option>
                                {zones.map(z => <option key={z.id} value={z.id}>{z.type}</option>)}
                            </select>
                        </div>

                        {/* Dirección */}
                        <div className="md:col-span-2 space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Dirección de residencia *</label>
                            <input required name="address" value={formData.address} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>

                        {/* Provincia */}
                        <div className="md:col-span-2 space-y-1">
                            <label className="text-[10px] font-black text-slate-400 uppercase">Provincia *</label>
                            <input required name="province" value={formData.province} onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                        </div>
                    </div>

                    {/* BOTONES */}
                    <div className="mt-8 flex gap-4">
                        <button type="button" onClick={onClose} className="flex-1 px-6 py-3 border border-slate-200 text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs uppercase tracking-widest">
                            Cancelar
                        </button>
                        <button type="submit" className="flex-[2] px-6 py-3 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all text-xs uppercase tracking-widest flex justify-center items-center gap-2">
                            <i className="fa-solid fa-floppy-disk"></i> Registrar Empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
