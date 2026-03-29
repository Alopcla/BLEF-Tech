import React, { useState, useEffect, useMemo } from 'react';

import EmployeeCard from './EmployeeCard';
import EmployeeDrawer from './EmployeeDrawer';

const roleStyles = {
    'Administrador': { bg: 'bg-fuchsia-500/20', text: 'text-fuchsia-300', border: 'border-fuchsia-500/50', icon: 'fa-user-tie', colorValue: 'fuchsia' },
    'Médico': { bg: 'bg-emerald-500/20', text: 'text-emerald-300', border: 'border-emerald-500/50', icon: 'fa-user-doctor', colorValue: 'emerald' },
    'Cuidador': { bg: 'bg-amber-500/20', text: 'text-amber-300', border: 'border-amber-500/50', icon: 'fa-paw', colorValue: 'amber' },
    'Guía': { bg: 'bg-sky-500/20', text: 'text-sky-300', border: 'border-sky-500/50', icon: 'fa-compass', colorValue: 'sky' },
    'Mantenimiento': { bg: 'bg-slate-500/20', text: 'text-slate-300', border: 'border-slate-500/50', icon: 'fa-screwdriver-wrench', colorValue: 'slate' }
};

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

    // Estados del Drawer (Panel lateral)
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
            .catch(error => console.error("Fallo API:", error));
    }, []);

    const filteredEmployees = useMemo(() => {
        return rawEmployees.filter(emp => {
            const matchesRole = selectedRole === 'Todos' || emp.position === selectedRole;
            const matchesSearch = searchTerm === '' || `${emp.name} ${emp.surname}`.toLowerCase().includes(searchTerm.toLowerCase()) || emp.dni.includes(searchTerm);
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
                <header className="bg-slate-950/50 backdrop-blur-xl border-b border-white/10 sticky top-0 z-40">
                    {/* ... (Cabecera igual) ... */}
                    <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                        <div className="flex items-center gap-3">
                            <div className="bg-gradient-to-tr from-blue-500 to-indigo-500 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-lg shadow-blue-500/50"><i className="fa-solid fa-shuttle-space"></i></div>
                            <h1 className="text-xl font-black tracking-tight text-white">Zoo<span className="text-blue-400">Pro</span> Dashboard</h1>
                        </div>
                        <form method="POST" action="/logout" className="m-0">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                            <button type="submit" className="bg-red-500/10 border border-red-500/30 text-red-300 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 hover:bg-red-500/30"><i className="fa-solid fa-power-off"></i> Desconectar</button>
                        </form>
                    </div>
                </header>

                <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                    {/* SIDEBAR */}
                    <aside className="w-full lg:w-1/3 xl:w-1/4 space-y-6">
                        <button className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white px-5 py-4 rounded-2xl font-black shadow-[0_0_20px_rgba(59,130,246,0.4)] transition-all flex justify-center items-center gap-3">
                            <i className="fa-solid fa-plus text-lg"></i> NUEVO EMPLEADO
                        </button>

                        <div className="bg-white/5 backdrop-blur-xl p-5 rounded-2xl border border-white/10 space-y-5">
                            <div className="relative">
                                <i className="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-500"></i>
                                <input type="text" placeholder="Buscar empleado o DNI..." value={searchTerm} onChange={(e) => setSearchTerm(e.target.value)} className="w-full bg-slate-900/50 border border-white/10 rounded-xl py-3 pl-11 pr-4 text-sm focus:ring-2 focus:ring-blue-500 text-white outline-none" />
                            </div>
                            <div className="flex flex-col gap-2">
                                {roles.map(role => (
                                    <button key={role} onClick={() => setSelectedRole(role)} className={`px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-between border ${selectedRole === role ? 'bg-blue-500/20 text-blue-300 border-blue-500/50' : 'bg-transparent text-slate-400 border-white/5 hover:bg-white/5'}`}>
                                        <div className="flex items-center gap-2">{role !== 'Todos' && <i className={`fa-solid ${roleStyles[role].icon}`}></i>} {role}</div>
                                        {selectedRole === role && <i className="fa-solid fa-check text-blue-400"></i>}
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div className="grid grid-cols-2 gap-3">
                            <StatCard title="Plantilla" value={isLoading ? '...' : stats.total} icon="fa-users" color="blue" />
                            <StatCard title="Admin" value={isLoading ? '...' : stats.administradores} icon="fa-user-tie" color="fuchsia" />
                            <StatCard title="Médica" value={isLoading ? '...' : stats.medicos} icon="fa-user-doctor" color="emerald" />
                            <StatCard title="Cuidadores" value={isLoading ? '...' : stats.cuidadores} icon="fa-paw" color="amber" />
                            <StatCard title="Guías" value={isLoading ? '...' : stats.guias} icon="fa-compass" color="sky" />
                            <StatCard title="Manten." value={isLoading ? '...' : stats.mantenimiento} icon="fa-screwdriver-wrench" color="slate" />
                        </div>
                    </aside>

                    {/* TARJETAS */}
                    <section className="flex-1">
                        {isLoading ? (
                            <div className="flex justify-center items-center h-64"><i className="fa-solid fa-circle-notch fa-spin text-4xl text-blue-500"></i></div>
                        ) : filteredEmployees.length === 0 ? (
                            <div className="bg-white/5 rounded-3xl p-16 text-center border border-white/10"><p className="text-slate-300">No hay coincidencias</p></div>
                        ) : (
                            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                                {/* AQUÍ INYECTAMOS TU NUEVO COMPONENTE */}
                                {filteredEmployees.map((employee) => (
                                    <EmployeeCard
                                        key={employee.dni}
                                        employee={employee}
                                        style={roleStyles[employee.position] || roleStyles['Mantenimiento']}
                                        onOpenDetails={openEmployeeDetails}
                                    />
                                ))}
                            </div>
                        )}
                    </section>
                </main>

                {/* AQUÍ INYECTAMOS EL PANEL LATERAL (DRAWER) */}
                <EmployeeDrawer
                    isOpen={isDrawerOpen}
                    onClose={() => setIsDrawerOpen(false)}
                    employee={selectedEmployee}
                    style={selectedEmployee ? (roleStyles[selectedEmployee.position] || roleStyles['Mantenimiento']) : null}
                />
            </div>
        </>
    );
}
