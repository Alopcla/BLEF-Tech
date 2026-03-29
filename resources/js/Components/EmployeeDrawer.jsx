import React from 'react';

export default function EmployeeDrawer({ isOpen, onClose, employee, style }) {
    if (!employee) return null;

    const getInitials = (name, surname) => `${name?.charAt(0) || ''}${surname?.charAt(0) || ''}`.toUpperCase();

    return (
        <>
            {/* OVERLAY OSCURO */}
            {isOpen && (
                <div className="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 transition-opacity" onClick={onClose}></div>
            )}

            {/* PANEL DESLIZANTE */}
            <aside className={`fixed top-0 right-0 h-full w-full max-w-md bg-slate-900/95 backdrop-blur-2xl shadow-[0_0_50px_rgba(0,0,0,0.5)] z-50 transform transition-transform duration-500 ease-out flex flex-col border-l border-white/10 ${isOpen ? 'translate-x-0' : 'translate-x-full'}`}>

                <div className="bg-black/40 text-white p-6 relative border-b border-white/10">
                    <button onClick={onClose} className="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500/80 transition-colors">
                        <i className="fa-solid fa-xmark"></i>
                    </button>
                    <h2 className="text-xl font-black mb-1">Perfil del Empleado</h2>
                    <p className="text-slate-400 text-sm font-mono">{employee.dni}</p>
                </div>

                <div className="flex-grow overflow-y-auto p-6 space-y-6">
                    <div className="flex items-center gap-4">
                        <div className={`w-16 h-16 rounded-full flex items-center justify-center text-2xl font-black shadow-lg bg-gradient-to-br from-${style?.colorValue}-900/80 to-${style?.colorValue}-600/80 text-white ring-2 ring-${style?.colorValue}-400/50`}>
                            {getInitials(employee.name, employee.surname)}
                        </div>
                        <div>
                            <h3 className="text-xl font-bold text-white">{employee.name} {employee.surname}</h3>
                            <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold mt-2 border ${style?.bg} ${style?.text} ${style?.border}`}>
                                <i className={`fa-solid ${style?.icon}`}></i> {employee.position}
                            </span>
                        </div>
                    </div>

                    <div>
                        <h4 className="text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Datos Personales</h4>
                        <div className="space-y-3 bg-white/5 p-4 rounded-xl border border-white/10 text-sm text-slate-300">
                            <div className="flex justify-between border-b border-white/10 pb-2">
                                <span className="text-slate-500">Nacimiento</span>
                                <span className="text-white">{new Date(employee.birth_date).toLocaleDateString('es-ES')}</span>
                            </div>
                            <div className="flex justify-between border-b border-white/10 pb-2">
                                <span className="text-slate-500">Dirección</span>
                                <span className="text-white text-right">{employee.address}</span>
                            </div>
                            <div className="flex justify-between">
                                <span className="text-slate-500">Provincia</span>
                                <span className="text-white">{employee.province}</span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 className="text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Contacto</h4>
                        <div className="space-y-3 bg-white/5 p-4 rounded-xl border border-white/10 text-sm">
                            <p className="flex items-center justify-between text-slate-300 border-b border-white/10 pb-2">
                                <span className="text-slate-500">Email</span>
                                <span className="text-white">{employee.email}</span>
                            </p>
                            <div className="pt-2">
                                <span className="text-slate-500 block mb-2">Teléfonos</span>
                                <ul className="space-y-2">
                                    {employee.telephones?.map(tel => (
                                        <li key={tel.id} className="bg-black/30 p-2 rounded flex items-center gap-3 text-slate-300">
                                            <i className="fa-solid fa-phone text-slate-500 text-xs"></i>
                                            <span className="font-mono">{tel.telephone}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="p-6 border-t border-white/10 bg-black/40 flex gap-3">
                    <button className="flex-1 bg-white/10 border border-white/20 text-white px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-500/20 hover:border-blue-500/50 hover:text-blue-300 transition-colors flex justify-center items-center gap-2">
                        <i className="fa-solid fa-pen"></i> Editar Datos
                    </button>
                </div>
            </aside>
        </>
    );
}
