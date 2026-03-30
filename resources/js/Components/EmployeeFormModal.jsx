import React, { useState } from 'react';

export default function EmployeeFormModal({ isOpen, onClose, zones, onSave }) {
    // Añadimos 'telephone' al estado inicial
    const [formData, setFormData] = useState({
        dni: '', name: '', surname: '', email: '',
        birth_date: '', address: '', province: '',
        position: '', zone_id: '', telephone: ''
    });

    if (!isOpen) return null;

    const handleChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        onSave(formData);
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div className="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden border border-slate-200">

                <div className="bg-slate-50 px-8 py-5 border-b border-slate-200 flex justify-between items-center">
                    <h2 className="text-xl font-black text-slate-800 uppercase tracking-tight">Nuevo Registro de Personal</h2>
                    <button onClick={onClose} className="text-slate-400 hover:text-red-500 transition-colors">
                        <i className="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <form onSubmit={handleSubmit} className="p-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                    {/* Fila 1 */}
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">DNI / NIE</label>
                        <input required name="dni" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Correo electrónico</label>
                        <input required type="email" name="email" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    {/* Fila 2 */}
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Nombre</label>
                        <input required name="name" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Apellidos</label>
                        <input required name="surname" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    {/* Fila 3: Teléfono y Fecha Nacimiento */}
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Teléfono de contacto</label>
                        <input required type="tel" name="telephone" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej: 600123456" />
                    </div>
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Fecha de Nacimiento</label>
                        <input required type="date" name="birth_date" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    {/* Fila 4 */}
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Posición / Cargo</label>
                        <select required name="position" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar...</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Médico">Médico</option>
                            <option value="Cuidador">Cuidador</option>
                            <option value="Guía">Guía</option>
                            <option value="Mantenimiento">Mantenimiento</option>
                        </select>
                    </div>
                    <div className="space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Zona de Trabajo</label>
                        <select required name="zone_id" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Seleccionar zona...</option>
                            {zones.map(z => <option key={z.id} value={z.id}>{z.type}</option>)}
                        </select>
                    </div>

                    {/* Fila 5: Dirección */}
                    <div className="md:col-span-2 space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Dirección de residencia</label>
                        <input required name="address" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div className="md:col-span-1 space-y-1">
                        <label className="text-[10px] font-black text-slate-400 uppercase">Provincia</label>
                        <input required name="province" onChange={handleChange} className="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>

                    <div className="md:col-span-2 pt-6 flex gap-4">
                        <button type="button" onClick={onClose} className="flex-1 px-6 py-3 border border-slate-200 text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs uppercase tracking-widest">
                            Cancelar
                        </button>
                        <button type="submit" className="flex-[2] px-6 py-3 bg-blue-600 text-white font-black rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all text-xs uppercase tracking-widest">
                            Registrar Empleado
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}
