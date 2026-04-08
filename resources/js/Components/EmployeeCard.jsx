import React from 'react';

// Función para calcular la edad exacta
const calcularEdad = (fechaNacimiento) => {
    if (!fechaNacimiento) return "";

    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();

    // Ajuste si aún no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    return edad;
};

export default function EmployeeCard({ employee, style, onOpenDetails }) {
    const getInitials = (name, surname) => `${name?.charAt(0) || ''}${surname?.charAt(0) || ''}`.toUpperCase();

    return (
        <div className={`bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-slate-200 border-t-4 ${style.border} flex flex-col h-full group`}>

            <div className="p-6 flex-grow flex flex-col items-center text-center relative">
                <div className="absolute top-4 right-4">
                    <span className={`px-2.5 py-1 rounded-lg text-[10px] font-black tracking-wide uppercase flex items-center gap-1.5 border ${style.bg} ${style.text} border-transparent`}>
                        <i className={`fa-solid ${style.icon}`}></i> {employee.position}
                    </span>
                </div>

                <div className="absolute top-4 left-4 font-mono text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                    {employee.dni}
                </div>

                <div className="mt-8 mb-4">
                    <div className={`w-16 h-16 rounded-full flex items-center justify-center text-2xl font-black shadow-inner bg-${style.colorValue}-50 text-${style.colorValue}-700 ring-4 ring-${style.colorValue}-100`}>
                        {getInitials(employee.name, employee.surname) || <i className="fa-solid fa-user"></i>}
                    </div>
                </div>

                <h3 className="text-lg font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                    {employee.name} {employee.surname}
                </h3>

                {/* CAJA DE DATOS DEL EMPLEADO */}
                <div className="mt-4 text-xs text-slate-600 w-full text-left bg-slate-50 rounded-xl p-3 border border-slate-100 space-y-2">
                    <p className="flex items-center gap-3">
                        <i className="fa-solid fa-map-location-dot text-slate-400 w-4 text-center"></i>
                        <span className="truncate">{'Zona ' + employee.zone?.id + ' - ' + employee.zone?.type || 'Sin zona'}</span>
                    </p>
                    <p className="flex items-center gap-3">
                        <i className="fa-solid fa-envelope text-slate-400 w-4 text-center"></i>
                        <span className="truncate">{employee.email}</span>
                    </p>

                    {/* NUEVO: Fecha de Nacimiento y Edad integrada */}
                    {employee.birth_date && (
                        <p className="flex items-center gap-3">
                            <i className="fa-solid fa-cake-candles text-slate-400 w-4 text-center"></i>
                            <span className="flex items-center gap-2 truncate">
                                {new Date(employee.birth_date).toLocaleDateString('es-ES')}
                                <span className="bg-slate-200 text-slate-500 px-1.5 py-0.5 rounded text-[10px] font-black">
                                    {calcularEdad(employee.birth_date)} AÑOS
                                </span>
                            </span>
                        </p>
                    )}
                </div>
            </div>

            <div className="bg-slate-50 p-3 border-t border-slate-100 flex justify-end gap-2 mt-auto">
                <button
                    onClick={() => onOpenDetails(employee)}
                    className="flex-1 py-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 transition-all text-sm font-bold flex items-center justify-center gap-2 shadow-sm">
                    <i className="fa-solid fa-id-badge"></i> Ver Ficha
                </button>
            </div>
        </div>
    );
}
