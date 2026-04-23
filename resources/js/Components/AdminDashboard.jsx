import React, { useState, useEffect, useMemo } from "react";
import EmployeeCard from "./EmployeeCard";
import EmployeeDrawer from "./EmployeeDrawer";
import EmployeeFormModal from "./EmployeeFormModal";
import NavigationModules from "./NavigationModules";
import Toast from "./Toast"; // <--- 1. IMPORTAMOS EL TOAST MAGICO

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
};

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

    // NUEVOS ESTADOS PARA BORRADO Y TOAST
    const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
    const [employeeToDelete, setEmployeeToDelete] = useState(null);
    const [toastData, setToastData] = useState(null);

    const showToast = (message, type = "success") => {
        setToastData({ message, type });
    };

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

    // --- ACCIONES (BORRAR Y GUARDAR) ---

    // 1. Prepara el borrado (Abre el modal rojo)
    const requestDeleteEmployee = (dni, name) => {
        setEmployeeToDelete({ dni, name });
        setShowDeleteConfirm(true);
    };

    // 2. Ejecuta el borrado real en la base de datos
    const executeDeleteEmployee = () => {
        if (!employeeToDelete) return;

        fetch(`/empleados/${employeeToDelete.dni}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                "Accept": "application/json"
            },
        })
        .then((response) => {
            if (response.ok) {
                // Quitamos al empleado de la lista visualmente
                setRawEmployees((prev) => prev.filter((emp) => emp.dni !== employeeToDelete.dni));
                setShowDeleteConfirm(false);
                setIsDrawerOpen(false); // Cerramos el panel lateral si estaba abierto
                setEmployeeToDelete(null);
                showToast("Empleado eliminado correctamente.", "success");
            } else {
                showToast("Error al intentar eliminar el empleado.", "error");
            }
        })
        .catch((err) => {
            showToast("Fallo de conexión al eliminar.", "error");
            setShowDeleteConfirm(false);
        });
    };

    // 3. Cuando el modal de crear empleado termina con éxito
    const handleSaveEmployee = (respuestaLaravel) => {
        // Buscamos el empleado venga como venga ('employee', 'data', o directo)
        const empleadoReal = respuestaLaravel.employee || respuestaLaravel.data || respuestaLaravel;

        // Verificamos que el objeto tiene un DNI válido antes de intentar dibujarlo
        if (empleadoReal && empleadoReal.dni) {
            setRawEmployees((prev) => [...prev, empleadoReal]);
        } else {
            // Si Laravel nos devuelve algo raro que no podemos leer, recargamos suavemente
            // para que traiga la lista fresca desde la base de datos y no haya pantalla blanca.
            window.location.reload();
        }
    };

    // 4. Cuando el drawer edita un empleado
    const handleUpdateEmployee = (empleadoActualizado) => {
        // Buscamos al empleado en la lista y lo cambiamos por el nuevo
        setRawEmployees((prev) =>
            prev.map(emp => emp.dni === empleadoActualizado.dni ? empleadoActualizado : emp)
        );
        showToast("Empleado actualizado correctamente.", "success");
    };

    const roles = ["Administrador", "Médico", "Cuidador", "Guía"];

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12 relative">
            {/* BARRA SUPERIOR */}
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-blue-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-leaf"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-blue-600">Pro</span> Admin
                        </h1>
                    </div>

                    <div className="flex items-center gap-4">
                        <a href="/" className="bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                            <i className="fa-solid fa-house"></i> Inicio
                        </a>

                        <form method="POST" action="/logout" className="m-0">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                            <button type="submit" className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                                <i className="fa-solid fa-power-off"></i> Desconectar
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                {/* COLUMNA IZQUIERDA: CONTROLES */}
                <aside className="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-6">
                    <button onClick={() => setIsFormOpen(true)} className="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-4 rounded-2xl font-black shadow-md transition-all flex justify-center items-center gap-3">
                        <i className="fa-solid fa-plus text-lg"></i> NUEVO EMPLEADO
                    </button>

                    <a href="/admin/reclamaciones" className="w-full bg-amber-50 border border-amber-200 text-amber-700 px-5 py-3 rounded-2xl font-bold transition-all flex justify-center items-center gap-3 hover:bg-amber-100 shadow-sm">
                        <i className="fa-solid fa-ticket text-lg"></i> RECLAMACIONES TICKETS
                    </a>
                    <a href="/alerts" className="w-full bg-indigo-50 border border-indigo-200 text-indigo-700 px-5 py-3 rounded-2xl font-bold transition-all flex justify-center items-center gap-3 hover:bg-indigo-100 shadow-sm mt-2">
                        <i className="fa-solid fa-bullhorn text-lg"></i> MANEJAR ALERTAS
                    </a>

                    <div className="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-5">
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
                            <button
                                onClick={() => setSelectedRole("Todos")}
                                className={`w-full flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all border ${selectedRole === "Todos" ? "bg-blue-50 text-blue-700 border-blue-200" : "bg-transparent text-slate-600 border-transparent hover:bg-slate-50"}`}
                            >
                                <div className="flex items-center gap-2">
                                    <i className="fa-solid fa-users w-5 text-center"></i> Todos
                                </div>
                                <span className={`px-2 py-0.5 rounded-full text-xs ${selectedRole === "Todos" ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-500'}`}>
                                    {rawEmployees.length}
                                </span>
                            </button>

                            {roles.map((role) => {
                                const count = rawEmployees.filter(emp => emp.position === role).length;
                                const style = roleStyles[role];
                                const isActive = selectedRole === role;

                                return (
                                    <button
                                        key={role}
                                        onClick={() => setSelectedRole(role)}
                                        className={`w-full flex justify-between items-center px-4 py-3 rounded-xl text-sm font-bold transition-all border ${isActive ? `${style.bg} ${style.text} ${style.border}` : "bg-transparent text-slate-600 border-transparent hover:bg-slate-50"}`}
                                    >
                                        <div className="flex items-center gap-2">
                                            <i className={`fa-solid ${style.icon} w-5 text-center`}></i> {role}
                                        </div>
                                        <span className={`px-2 py-0.5 rounded-full text-xs ${isActive ? 'bg-white/60' : 'bg-slate-100 text-slate-500'}`}>
                                            {count}
                                        </span>
                                    </button>
                                );
                            })}
                        </div>
                    </div>

                    <NavigationModules currentPanel="Administrador" />
                </aside>

                {/* COLUMNA DERECHA: TARJETAS DE EMPLEADOS */}
                <section className="flex-1">
                    {isLoading ? (
                        <div className="flex justify-center items-center h-64">
                            <i className="fa-solid fa-circle-notch fa-spin text-4xl text-blue-600"></i>
                        </div>
                    ) : filteredEmployees.length === 0 ? (
                        <div className="bg-white rounded-3xl p-16 text-center border border-slate-200 shadow-sm">
                            <p className="text-slate-500">No hay coincidencias en el directorio.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            {filteredEmployees.map((employee) => (
                                <EmployeeCard
                                    key={employee.dni}
                                    employee={employee}
                                    style={roleStyles[employee.position]}
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

            {/* Le pasamos las funciones actualizadas al Drawer */}
            <EmployeeDrawer
                isOpen={isDrawerOpen}
                onClose={() => setIsDrawerOpen(false)}
                employee={selectedEmployee}
                style={selectedEmployee ? roleStyles[selectedEmployee.position] : null}
                onDeleteRequest={(dni, name) => requestDeleteEmployee(dni, name)}
                onUpdate={handleUpdateEmployee}
                onShowToast={showToast}
                zones={zones}
            />

            {/* Le pasamos la función showToast al Modal */}
            <EmployeeFormModal
                isOpen={isFormOpen}
                onClose={() => setIsFormOpen(false)}
                zones={zones}
                onSave={handleSaveEmployee}
                onShowToast={showToast}
            />

            {/* MODAL DE CONFIRMACIÓN DE BORRADO ELEGANTE */}
            {showDeleteConfirm && employeeToDelete && (
                <div className="fixed inset-0 z-[200] flex items-center justify-center p-4 animate-fade-in">
                    <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setShowDeleteConfirm(false)}></div>
                    <div className="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm overflow-hidden text-center p-8">
                        <div className="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i className="fa-solid fa-triangle-exclamation text-4xl"></i>
                        </div>
                        <h3 className="text-2xl font-black text-slate-800 mb-2">¿Despedir empleado?</h3>
                        <p className="text-slate-500 text-sm mb-8">
                            Estás a punto de eliminar a <strong className="text-slate-700">{employeeToDelete.name}</strong> del sistema. Esta acción revocará su acceso y no se puede deshacer.
                        </p>
                        <div className="flex gap-3">
                            <button onClick={() => setShowDeleteConfirm(false)} className="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-3.5 rounded-xl text-sm font-bold transition-colors">CANCELAR</button>
                            <button onClick={executeDeleteEmployee} className="flex-1 bg-red-600 hover:bg-red-700 text-white py-3.5 rounded-xl text-sm font-black shadow-md transition-colors flex justify-center items-center gap-2">
                                <i className="fa-solid fa-user-xmark"></i> ELIMINAR
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {/* COMPONENTE TOAST UNIVERSAL */}
            <Toast
                message={toastData?.message}
                type={toastData?.type}
                onClose={() => setToastData(null)}
            />
        </div>
    );
}
