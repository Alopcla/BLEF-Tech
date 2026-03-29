import React, { useState, useEffect, useMemo } from 'react';

// Estilos adaptados para fondo oscuro (Dark Mode + Glassmorphism)
const roleStyles = {
    'Administrador': { bg: 'bg-fuchsia-500/20', text: 'text-fuchsia-300', border: 'border-fuchsia-500/50', icon: 'fa-user-tie', colorValue: 'fuchsia' },
    'Médico': { bg: 'bg-emerald-500/20', text: 'text-emerald-300', border: 'border-emerald-500/50', icon: 'fa-user-doctor', colorValue: 'emerald' },
    'Cuidador': { bg: 'bg-amber-500/20', text: 'text-amber-300', border: 'border-amber-500/50', icon: 'fa-paw', colorValue: 'amber' },
    'Guía': { bg: 'bg-sky-500/20', text: 'text-sky-300', border: 'border-sky-500/50', icon: 'fa-compass', colorValue: 'sky' },
    'Mantenimiento': { bg: 'bg-slate-500/20', text: 'text-slate-300', border: 'border-slate-500/50', icon: 'fa-screwdriver-wrench', colorValue: 'slate' }
};

// Tarjeta Estadística super compacta para la barra lateral
const StatCard = ({ title, value, icon, color }) => (
    <div className="bg-white/5 backdrop-blur-md p-4 rounded-xl border border-white/10 flex items-center gap-4 transition-all hover:bg-white/10">
        <div className={`w-10 h-10 rounded-lg flex items-center justify-center text-lg bg-${color}-500/20 text-${color}-400 border border-${color}-500/30`}>
            <i className={`fa-solid ${icon}`}></i>
        </div>
        <div>
            <p className="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{title}</p>
            <p className="text-xl font-black text-white">{value}</p>
        </div>
    </div>
);

const getInitialsAvatar = (name, surname, color) => {
    const initials = `${name?.charAt(0) || ''}${surname?.charAt(0) || ''}`.toUpperCase();
    return (
        <div className={`w-16 h-16 rounded-full flex items-center justify-center text-2xl font-black shadow-[0_0_15px_rgba(255,255,255,0.1)] bg-gradient-to-br from-${color}-900/80 to-${color}-600/80 text-white ring-2 ring-${color}-400/50`}>
            {initials || <i className="fa-solid fa-user"></i>}
        </div>
    );
};

// FONDO GALAXIA CSS
const CSSGalaxyBackground = () => (
    <div className="fixed inset-0 z-[-1] bg-slate-950 overflow-hidden">
        <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-indigo-900/40 via-slate-950 to-black"></div>
        <div className="absolute inset-0 opacity-20" style={{ backgroundImage: 'radial-gradient(rgba(255, 255, 255, 0.8) 1px, transparent 1px)', backgroundSize: '40px 40px' }}></div>
        <div className="absolute top-[-20%] left-[-10%] w-[50%] h-[50%] rounded-full bg-fuchsia-600/10 blur-[120px] animate-pulse"></div>
        <div className="absolute bottom-[-20%] right-[-10%] w-[50%] h-[50%] rounded-full bg-blue-600/10 blur-[120px] animate-pulse" style={{ animationDelay: '2s' }}></div>
    </div>
);

export default function AdminDashboard() {
    const [rawEmployees, setRawEmployees] = useState([]);
    const [zones, setZones] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedRole, setSelectedRole] = useState('Todos');

    const [isDrawerOpen, setIsDrawerOpen] = useState(false);
    const [selectedEmployee, setSelectedEmployee] = useState(null);

    useEffect(() => {
        setIsLoading(true);
        fetch('/api/empleados')
            .then(res => res.json())
            .then(data => {
                setRawEmployees(data.employees || []);
                setZones(data.zones || []);
                setIsLoading(false);
            })
            .catch(error => {
                console.error("Fallo API:", error);
                setIsLoading(false);
            });
    }, []);

    const filteredEmployees = useMemo(() => {
        return rawEmployees.filter(emp => {
            const matchesRole = selectedRole === 'Todos' || emp.position === selectedRole;
            const fullName = `${emp.name} ${emp.surname}`.toLowerCase();
            const matchesSearch = searchTerm === '' || fullName.includes(searchTerm.toLowerCase()) || emp.dni.includes(searchTerm);
            return matchesRole && matchesSearch;
        });
    }, [rawEmployees, searchTerm, selectedRole]);

    const stats = useMemo(() => {
        return {
            total: rawEmployees.length,
            administradores: rawEmployees.filter(e => e.position === 'Administrador').length,
            medicos: rawEmployees.filter(e => e.position === 'Médico').length,
            cuidadores: rawEmployees.filter(e => e.position === 'Cuidador').length,
            guias: rawEmployees.filter(e => e.position === 'Guía').length,
            mantenimiento: rawEmployees.filter(e => e.position === 'Mantenimiento').length
        };
    }, [rawEmployees]);

    const roles = ['Todos', 'Administrador', 'Médico', 'Cuidador', 'Guía', 'Mantenimiento'];

    const openEmployeeDetails = (employee) => {
        setSelectedEmployee(employee);
        setIsDrawerOpen(true);
    };

    return (
        <>
            <CSSGalaxyBackground />

            <div className="min-h-screen font-sans text-slate-200 pb-12 relative z-10">

                {/* CABECERA */}
                <header className="bg-slate-950/50 backdrop-blur-xl border-b border-white/10 sticky top-0 z-40">
                    <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                        <div className="flex items-center gap-3">
                            <div className="bg-gradient-to-tr from-blue-500 to-indigo-500 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-lg shadow-blue-500/50">
                                <i className="fa-solid fa-shuttle-space"></i>
                            </div>
                            <h1 className="text-xl font-black tracking-tight text-white">
                                Zoo<span className="text-blue-400">Pro</span> Dashboard
                            </h1>
                        </div>

                        <form method="POST" action="/logout" className="m-0">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                            <button type="submit" className="bg-red-500/10 hover:bg-red-500/30 border border-red-500/30 text-red-300 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 backdrop-blur-md">
                                <i className="fa-solid fa-power-off"></i> Desconectar
                            </button>
                        </form>
                    </div>
                </header>

                {/* LAYOUT DIVIDIDO: Barra lateral izquierda y contenido principal derecha */}
                <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">

                    {/* BARRA LATERAL (Panel de Control) */}
                    <aside className="w-full lg:w-1/3 xl:w-1/4 space-y-6">

                        {/* Botón Principal */}
                        <button className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-4 rounded-2xl font-black shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all flex justify-center items-center gap-3 transform hover:-translate-y-1 border border-blue-400/30">
                            <i className="fa-solid fa-plus text-lg"></i> NUEVO EMPLEADO
                        </button>

                        {/* Buscador y Filtros */}
                        <div className="bg-white/5 backdrop-blur-xl p-5 rounded-2xl border border-white/10 space-y-5 shadow-2xl">
                            <h2 className="text-sm font-black text-slate-300 uppercase tracking-wider flex items-center gap-2">
                                <i className="fa-solid fa-filter text-blue-400"></i> Directorio Activo
                            </h2>

                            <div className="relative">
                                <i className="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                <input
                                    type="text"
                                    placeholder="Buscar empleado o DNI..."
                                    value={searchTerm}
                                    onChange={(e) => setSearchTerm(e.target.value)}
                                    className="w-full bg-slate-900/50 border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm focus:ring-2 focus:ring-blue-500 text-white placeholder-slate-500 outline-none transition"
                                />
                            </div>

                            <div className="flex flex-col gap-2">
                                {roles.map(role => (
                                    <button
                                        key={role} onClick={() => setSelectedRole(role)}
                                        className={`px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-between border
                                            ${selectedRole === role ? 'bg-blue-500/20 text-blue-300 border-blue-500/50 shadow-inner' : 'bg-transparent text-slate-400 border-white/5 hover:bg-white/5 hover:text-slate-200'}`}
                                    >
                                        <div className="flex items-center gap-2">
                                            {role !== 'Todos' && roleStyles[role] && <i className={`fa-solid ${roleStyles[role].icon}`}></i>}
                                            {role}
                                        </div>
                                        {selectedRole === role && <i className="fa-solid fa-check text-blue-400"></i>}
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Estadísticas Compactas */}
                        <div className="grid grid-cols-2 gap-3">
                            <StatCard title="Plantilla" value={isLoading ? '...' : stats.total} icon="fa-users" color="blue" />
                            <StatCard title="Admin" value={isLoading ? '...' : stats.administradores} icon="fa-user-tie" color="fuchsia" />
                            <StatCard title="Médica" value={isLoading ? '...' : stats.medicos} icon="fa-user-doctor" color="emerald" />
                            <StatCard title="Cuidadores" value={isLoading ? '...' : stats.cuidadores} icon="fa-paw" color="amber" />
                            <StatCard title="Guías" value={isLoading ? '...' : stats.guias} icon="fa-compass" color="sky" />
                            <StatCard title="Mantenimiento" value={isLoading ? '...' : stats.mantenimiento} icon="fa-screwdriver-wrench" color="slate" />
                        </div>
                    </aside>

                    {/* ÁREA PRINCIPAL (Tarjetas) */}
                    <section className="flex-1">
                        {isLoading ? (
                            <div className="flex justify-center items-center h-64">
                                <i className="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500"></i>
                            </div>
                        ) : filteredEmployees.length === 0 ? (
                            <div className="bg-white/5 backdrop-blur-md rounded-3xl p-16 text-center border border-white/10 flex flex-col items-center justify-center h-full">
                                <i className="fa-regular fa-folder-open text-6xl text-slate-600 mb-6"></i>
                                <h3 className="text-2xl font-bold text-slate-300">No hay coincidencias</h3>
                                <p className="text-slate-500 mt-2">Prueba a cambiar los filtros en la barra lateral.</p>
                            </div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                {filteredEmployees.map((employee) => {
                                    const style = roleStyles[employee.position] || roleStyles['Mantenimiento'];

                                    return (
                                        <div key={employee.dni} className="bg-white/5 backdrop-blur-xl rounded-2xl shadow-xl hover:shadow-[0_0_30px_rgba(255,255,255,0.05)] transition-all duration-300 overflow-hidden border border-white/10 flex flex-col h-full group">

                                            <div className="p-6 flex-grow flex flex-col items-center text-center relative">

                                                {/* Etiqueta del Puesto (Esquina superior) */}
                                                <div className="absolute top-4 right-4">
                                                    <span className={`px-2.5 py-1 rounded-lg text-[10px] font-black tracking-wide uppercase flex items-center gap-1.5 border ${style.bg} ${style.text} ${style.border}`}>
                                                        <i className={`fa-solid ${style.icon}`}></i> {employee.position}
                                                    </span>
                                                </div>

                                                {/* DNI */}
                                                <div className="absolute top-4 left-4 font-mono text-[10px] font-bold text-slate-400 bg-black/30 px-2 py-1 rounded border border-white/5">
                                                    {employee.dni}
                                                </div>

                                                <div className="mt-8 mb-4">
                                                    {getInitialsAvatar(employee.name, employee.surname, style.colorValue)}
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
                                                    onClick={() => openEmployeeDetails(employee)}
                                                    className="w-full py-2 bg-white/5 border border-white/10 text-slate-300 rounded-lg hover:bg-blue-500/20 hover:text-blue-300 hover:border-blue-500/50 transition-all text-sm font-bold flex items-center justify-center gap-2">
                                                    <i className="fa-solid fa-id-badge"></i> Ver Ficha
                                                </button>
                                                <button className="px-3 py-2 bg-white/5 border border-white/10 text-red-400 rounded-lg hover:bg-red-500/20 hover:border-red-500/50 transition-all">
                                                    <i className="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    );
                                })}
                            </div>
                        )}
                    </section>
                </main>

                {/* OVERLAY PANEL LATERAL */}
                {isDrawerOpen && (
                    <div className="fixed inset-0 bg-slate-950/80 backdrop-blur-md z-50 transition-opacity" onClick={() => setIsDrawerOpen(false)}></div>
                )}

                {/* PANEL LATERAL (Ficha de detalles en modo oscuro) */}
                <aside className={`fixed top-0 right-0 h-full w-full max-w-md bg-slate-900/95 backdrop-blur-2xl shadow-[0_0_50px_rgba(0,0,0,0.5)] z-50 transform transition-transform duration-500 ease-out flex flex-col border-l border-white/10 ${isDrawerOpen ? 'translate-x-0' : 'translate-x-full'}`}>
                    {selectedEmployee && (
                        <>
                            <div className="bg-black/40 text-white p-6 relative border-b border-white/10">
                                <button onClick={() => setIsDrawerOpen(false)} className="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white/10 hover:bg-red-500/80 transition-colors">
                                    <i className="fa-solid fa-xmark"></i>
                                </button>
                                <h2 className="text-xl font-black mb-1">Perfil del Empleado</h2>
                                <p className="text-slate-400 text-sm font-mono">{selectedEmployee.dni}</p>
                            </div>

                            <div className="flex-grow overflow-y-auto p-6 space-y-6">
                                <div className="flex items-center gap-4">
                                    {getInitialsAvatar(selectedEmployee.name, selectedEmployee.surname, roleStyles[selectedEmployee.position]?.colorValue || 'slate')}
                                    <div>
                                        <h3 className="text-xl font-bold text-white">{selectedEmployee.name} {selectedEmployee.surname}</h3>
                                        <span className={`inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold mt-2 border ${roleStyles[selectedEmployee.position]?.bg} ${roleStyles[selectedEmployee.position]?.text} ${roleStyles[selectedEmployee.position]?.border}`}>
                                            <i className={`fa-solid ${roleStyles[selectedEmployee.position]?.icon}`}></i> {selectedEmployee.position}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <h4 className="text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Datos Personales</h4>
                                    <div className="space-y-3 bg-white/5 p-4 rounded-xl border border-white/10 text-sm text-slate-300">
                                        <div className="flex justify-between border-b border-white/10 pb-2">
                                            <span className="text-slate-500">Nacimiento</span>
                                            <span className="text-white">{new Date(selectedEmployee.birth_date).toLocaleDateString('es-ES')}</span>
                                        </div>
                                        <div className="flex justify-between border-b border-white/10 pb-2">
                                            <span className="text-slate-500">Dirección</span>
                                            <span className="text-white text-right">{selectedEmployee.address}</span>
                                        </div>
                                        <div className="flex justify-between">
                                            <span className="text-slate-500">Provincia</span>
                                            <span className="text-white">{selectedEmployee.province}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 className="text-xs font-black text-slate-500 uppercase tracking-wider mb-3">Contacto</h4>
                                    <div className="space-y-3 bg-white/5 p-4 rounded-xl border border-white/10 text-sm">
                                        <p className="flex items-center justify-between text-slate-300 border-b border-white/10 pb-2">
                                            <span className="text-slate-500">Email</span>
                                            <span className="text-white">{selectedEmployee.email}</span>
                                        </p>
                                        <div className="pt-2">
                                            <span className="text-slate-500 block mb-2">Teléfonos</span>
                                            <ul className="space-y-2">
                                                {selectedEmployee.telephones?.map(tel => (
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
                        </>
                    )}
                </aside>
            </div>
        </>
    );
}
