import React, { useState, useEffect, useMemo } from "react";
import EmployeeCard from "./EmployeeCard";
import EmployeeDrawer from "./EmployeeDrawer";
import EmployeeFormModal from "./EmployeeFormModal";

// Estilos Corporativos del Zoo
const roleStyles = {
    Administrador: {
        bg: "bg-emerald-100",
        text: "text-emerald-800",
        border: "border-emerald-500",
        icon: "fa-shield-dog",
        colorValue: "emerald",
    },
    Médico: {
        bg: "bg-teal-100",
        text: "text-teal-800",
        border: "border-teal-500",
        icon: "fa-stethoscope",
        colorValue: "teal",
    },
    Cuidador: {
        bg: "bg-lime-100",
        text: "text-lime-800",
        border: "border-lime-500",
        icon: "fa-leaf",
        colorValue: "lime",
    },
    Guía: {
        bg: "bg-orange-100",
        text: "text-orange-800",
        border: "border-orange-500",
        icon: "fa-map-signs",
        colorValue: "orange",
    },
    Mantenimiento: {
        bg: "bg-stone-100",
        text: "text-stone-800",
        border: "border-stone-500",
        icon: "fa-tools",
        colorValue: "stone",
    },
};

// Sub-componente de Estadísticas
const StatCard = ({ title, value, icon, color }) => (
    <div className="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
        <div
            className={`w-10 h-10 rounded-lg flex items-center justify-center text-lg bg-${color}-50 text-${color}-600 border border-${color}-100`}
        >
            <i className={`fa-solid ${icon}`}></i>
        </div>
        <div>
            <p className="text-[10px] font-bold text-slate-500 uppercase tracking-wider">
                {title}
            </p>
            <p className="text-xl font-black text-slate-800">{value}</p>
        </div>
    </div>
);

export default function AdminDashboard() {
    // --- ESTADOS ---
    const [rawEmployees, setRawEmployees] = useState([]);
    const [zones, setZones] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState("");
    const [selectedRole, setSelectedRole] = useState("Todos");

    // Estados para Modales y Paneles
    const [isDrawerOpen, setIsDrawerOpen] = useState(false);
    const [selectedEmployee, setSelectedEmployee] = useState(null);
    const [isFormOpen, setIsFormOpen] = useState(false);

    // --- CARGA DE DATOS (API) ---
    useEffect(() => {
        setIsLoading(true);
        fetch("/api/empleados")
            .then((res) => res.json())
            .then((data) => {
                setRawEmployees(data.employees || []);
                setZones(data.zones || []);
                setIsLoading(false);
            })
            .catch((error) => console.error("Error al cargar datos:", error));
    }, []);

    // --- LÓGICA DE FILTRADO ---
    const filteredEmployees = useMemo(() => {
        return rawEmployees.filter((emp) => {
            const matchesRole =
                selectedRole === "Todos" || emp.position === selectedRole;
            const matchesSearch =
                searchTerm === "" ||
                `${emp.name} ${emp.surname}`
                    .toLowerCase()
                    .includes(searchTerm.toLowerCase()) ||
                emp.dni.includes(searchTerm);
            return matchesRole && matchesSearch;
        });
    }, [rawEmployees, searchTerm, selectedRole]);

    // --- ESTADÍSTICAS ---
    const stats = useMemo(
        () => ({
            total: rawEmployees.length,
            administradores: rawEmployees.filter(
                (e) => e.position === "Administrador",
            ).length,
            medicos: rawEmployees.filter((e) => e.position === "Médico").length,
            cuidadores: rawEmployees.filter((e) => e.position === "Cuidador")
                .length,
            guias: rawEmployees.filter((e) => e.position === "Guía").length,
            mantenimiento: rawEmployees.filter(
                (e) => e.position === "Mantenimiento",
            ).length,
        }),
        [rawEmployees],
    );

    // --- ACCIONES (BORRAR Y GUARDAR) ---
    const handleDeleteEmployee = (dni) => {
        fetch(`/empleados/${dni}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
            },
        })
            .then(() => {
                alert("Empleado eliminado");
                window.location.reload(); // Lo más simple: recargar para limpiar la lista
            })
            .catch((err) => alert("Error al borrar"));
    };

    const handleSaveEmployee = async (data) => {
        try {
            const response = await fetch("/registrar-nuevo-empleado", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(data),
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const errorData = await response.json();
                alert("Error: " + (errorData.message || "Fallo al guardar"));
            }
        } catch (error) {
            console.error("Error POST:", error);
        }
    };

    const roles = [
        "Todos",
        "Administrador",
        "Médico",
        "Cuidador",
        "Guía",
        "Mantenimiento",
    ];

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12">
            {/* BARRA SUPERIOR */}
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-blue-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-leaf"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-blue-600">Pro</span>{" "}
                            Dashboard
                        </h1>
                    </div>
                    <form method="POST" action="/logout" className="m-0">
                        <input
                            type="hidden"
                            name="_token"
                            value={
                                document.querySelector(
                                    'meta[name="csrf-token"]',
                                )?.content
                            }
                        />
                        <button
                            type="submit"
                            className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2"
                        >
                            <i className="fa-solid fa-power-off"></i>{" "}
                            Desconectar
                        </button>
                    </form>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                {/* COLUMNA IZQUIERDA: CONTROLES */}
                <aside className="w-full lg:w-1/3 xl:w-1/4 space-y-6">
                    <button
                        onClick={() => setIsFormOpen(true)}
                        className="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 rounded-2xl font-black shadow-md transition-all flex justify-center items-center gap-3"
                    >
                        <i className="fa-solid fa-plus text-lg"></i> NUEVO
                        EMPLEADO
                    </button>

                    <a
                        href="/admin/reclamaciones"
                        className="w-full bg-amber-50 border border-amber-200 text-amber-700 px-5 py-3 rounded-2xl font-bold transition-all flex justify-center items-center gap-3 hover:bg-amber-100 shadow-sm"
                    >
                        <i className="fa-solid fa-ticket text-lg"></i>{" "}
                        RECLAMACIONES TICKETS
                    </a>

                    <div className="bg-white p-5 rounded-2xl border border-slate-200 space-y-5 shadow-sm">
                        <div className="relative">
                            <i className="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input
                                type="text"
                                placeholder="Buscar empleado..."
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                                className="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-11 pr-4 text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                            />
                        </div>
                        <div className="flex flex-col gap-2">
                            {roles.map((role) => (
                                <button
                                    key={role}
                                    onClick={() => setSelectedRole(role)}
                                    className={`px-4 py-2.5 rounded-xl text-xs font-bold transition-all flex items-center justify-between border ${selectedRole === role ? "bg-blue-50 text-blue-700 border-blue-200 shadow-inner" : "bg-transparent text-slate-600 border-slate-100 hover:bg-slate-50"}`}
                                >
                                    <div className="flex items-center gap-2">
                                        {role !== "Todos" && (
                                            <i
                                                className={`fa-solid ${roleStyles[role].icon}`}
                                            ></i>
                                        )}{" "}
                                        {role}
                                    </div>
                                    {selectedRole === role && (
                                        <i className="fa-solid fa-check text-blue-600"></i>
                                    )}
                                </button>
                            ))}
                        </div>
                    </div>

                    <div className="grid grid-cols-2 gap-3">
                        <StatCard
                            title="Plantilla"
                            value={isLoading ? "..." : stats.total}
                            icon="fa-users"
                            color="blue"
                        />
                        <StatCard
                            title="Admin"
                            value={isLoading ? "..." : stats.administradores}
                            icon="fa-user-tie"
                            color="emerald"
                        />
                        <StatCard
                            title="Médicos"
                            value={isLoading ? "..." : stats.medicos}
                            icon="fa-user-doctor"
                            color="teal"
                        />
                        <StatCard
                            title="Cuidadores"
                            value={isLoading ? "..." : stats.cuidadores}
                            icon="fa-paw"
                            color="lime"
                        />
                        <StatCard
                            title="Guías"
                            value={isLoading ? "..." : stats.guias}
                            icon="fa-compass"
                            color="orange"
                        />
                        <StatCard
                            title="Manten."
                            value={isLoading ? "..." : stats.mantenimiento}
                            icon="fa-screwdriver-wrench"
                            color="stone"
                        />
                    </div>
                </aside>

                {/* COLUMNA DERECHA: TARJETAS */}
                <section className="flex-1">
                    {isLoading ? (
                        <div className="flex justify-center items-center h-64">
                            <i className="fa-solid fa-circle-notch fa-spin text-4xl text-blue-600"></i>
                        </div>
                    ) : filteredEmployees.length === 0 ? (
                        <div className="bg-white rounded-3xl p-16 text-center border border-slate-200 shadow-sm">
                            <p className="text-slate-500">
                                No hay coincidencias en el directorio.
                            </p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            {filteredEmployees.map((employee) => (
                                <EmployeeCard
                                    key={employee.dni}
                                    employee={employee}
                                    style={
                                        roleStyles[employee.position] ||
                                        roleStyles["Mantenimiento"]
                                    }
                                    onOpenDetails={(emp) => {
                                        setSelectedEmployee(emp);
                                        setIsDrawerOpen(true);
                                    }}
                                />
                            ))}
                        </div>
                    )}
                </section>
            </main>

            {/* COMPONENTES MODALES / PANEL LATERAL */}
            <EmployeeDrawer
                isOpen={isDrawerOpen}
                onClose={() => setIsDrawerOpen(false)}
                employee={selectedEmployee}
                style={
                    selectedEmployee
                        ? roleStyles[selectedEmployee.position]
                        : null
                }
                onDelete={handleDeleteEmployee}
                zones={zones} // <--- REVISA QUE ESTA LÍNEA ESTÉ EXACTAMENTE ASÍ
            />

            <EmployeeFormModal
                isOpen={isFormOpen}
                onClose={() => setIsFormOpen(false)}
                zones={zones}
                onSave={handleSaveEmployee}
            />
        </div>
    );
}
