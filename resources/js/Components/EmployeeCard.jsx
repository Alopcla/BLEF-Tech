import React from 'react';

export default function EmployeeCard({ employee, style, onOpenDetails }) {
    // Función de ayuda para las iniciales
    const getInitials = (name, surname) => `${name?.charAt(0) || ''}${surname?.charAt(0) || ''}`.toUpperCase();

    return (
        <div className="bg-white/5 backdrop-blur-xl rounded-2xl shadow-xl hover:shadow-[0_0_30px_rgba(255,255,255,0.05)] transition-all duration-300 overflow-hidden border border-white/10 flex flex-col h-full group">

            <div className="p-6 flex-grow flex flex-col items-center text-center relative">
                <div className="absolute top-4 right-4">
                    <span className={`px-2.5 py-1 rounded-lg text-[10px] font-black tracking-wide uppercase flex items-center gap-1.5 border ${style.bg} ${style.text} ${style.border}`}>
                        <i className={`fa-solid ${style.icon}`}></i> {employee.position}
                    </span>
                </div>

                <div className="absolute top-4 left-4 font-mono text-[10px] font-bold text-slate-400 bg-black/30 px-2 py-1 rounded border border-white/5">
                    {employee.dni}
                </div>

                <div className="mt-8 mb-4">
                    <div className={`w-16 h-16 rounded-full flex items-center justify-center text-2xl font-black shadow-[0_0_15px_rgba(255,255,255,0.1)] bg-gradient-to-br from-${style.colorValue}-900/80 to-${style.colorValue}-600/80 text-white ring-2 ring-${style.colorValue}-400/50`}>
                        {getInitials(employee.name, employee.surname) || <i className="fa-solid fa-user"></i>}
                    </div>
                </div>

                <h3 className="text-lg font-bold text-white group-hover:text-blue-400 transition-colors">
                    {employee.name} {employee.surname}
                </h3>

                <div className="mt-4 text-xs text-slate-400 w-full text-left bg-black/20 rounded-xl p-3 border border-white/5 space-y-2">
                    <p className="flex items-center gap-3">
                        <i className="fa-solid fa-map-location-dot text-slate-500 w-4 text-center"></i>
                        <span className="truncate">{employee.zone?.nombre || 'Sin zona'}</span>
                    </p>
                    <p className="flex items-center gap-3">
                        <i className="fa-solid fa-envelope text-slate-500 w-4 text-center"></i>
                        <span className="truncate">{employee.email}</span>
                    </p>
                </div>
            </div>

            <div className="bg-black/30 p-3 border-t border-white/5 flex justify-end gap-2 mt-auto">
                <button
                    onClick={() => onOpenDetails(employee)}
                    className="w-full py-2 bg-white/5 border border-white/10 text-slate-300 rounded-lg hover:bg-blue-500/20 hover:text-blue-300 hover:border-blue-500/50 transition-all text-sm font-bold flex items-center justify-center gap-2">
                    <i className="fa-solid fa-id-badge"></i> Ver Ficha
                </button>
            </div>
        </div>
    );
}
