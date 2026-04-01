import React from 'react';

export default function NavigationModules({ currentPanel }) {
    // Definimos TODOS los módulos posibles
    const modules = [
        {
            id: 'Administrador', href: '/empleados', title: 'Panel Admin', desc: 'Directorio y RRHH',
            icon: 'fa-shield-dog', bg: 'bg-blue-50', text: 'text-blue-900', border: 'border-blue-100',
            hoverBg: 'hover:bg-blue-600', hoverText: 'group-hover:text-blue-100'
        },
        {
            id: 'Médico', href: '/medico/dashboard', title: 'Área Médica', desc: 'Historiales clínicos',
            icon: 'fa-stethoscope', bg: 'bg-teal-50', text: 'text-teal-900', border: 'border-teal-100',
            hoverBg: 'hover:bg-teal-600', hoverText: 'group-hover:text-teal-100'
        },
        {
            id: 'Cuidador', href: '/cuidador/dashboard', title: 'Cuidadores', desc: 'Dietas y recintos',
            icon: 'fa-paw', bg: 'bg-lime-50', text: 'text-lime-900', border: 'border-lime-100',
            hoverBg: 'hover:bg-lime-600', hoverText: 'group-hover:text-lime-100'
        },
        {
            id: 'Guía', href: '/guia/dashboard', title: 'Guías', desc: 'Tours y visitantes',
            icon: 'fa-map-signs', bg: 'bg-orange-50', text: 'text-orange-900', border: 'border-orange-100',
            hoverBg: 'hover:bg-orange-500', hoverText: 'group-hover:text-orange-100'
        },
    ];

    // Filtramos para NO mostrar el panel en el que estamos actualmente
    const visibleModules = modules.filter(mod => mod.id !== currentPanel);

    return (
        <div className="bg-white rounded-3xl p-5 border border-slate-200 shadow-sm">
            <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Módulos Operativos</h3>
            <div className="grid grid-cols-1 gap-3">
                {visibleModules.map(mod => (
                    <a key={mod.id} href={mod.href} className={`group flex items-center justify-between p-4 rounded-2xl ${mod.bg} border ${mod.border} ${mod.hoverBg} hover:text-white transition-all cursor-pointer`}>
                        <div className="flex items-center gap-3">
                            <div className={`w-10 h-10 rounded-xl bg-white ${mod.text} flex items-center justify-center shadow-sm`}>
                                <i className={`fa-solid ${mod.icon} text-lg`}></i>
                            </div>
                            <div className="text-left">
                                <p className={`text-sm font-black ${mod.text} group-hover:text-white`}>{mod.title}</p>
                                <p className={`text-[10px] font-bold uppercase tracking-wider ${mod.text} opacity-70 ${mod.hoverText}`}>{mod.desc}</p>
                            </div>
                        </div>
                        <i className={`fa-solid fa-chevron-right opacity-40 group-hover:text-white transition-transform group-hover:translate-x-1`}></i>
                    </a>
                ))}
            </div>
        </div>
    );
}
