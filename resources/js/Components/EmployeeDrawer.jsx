import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom";

// Función para calcular la edad exacta
const calcularEdad = (fechaNacimiento) => {
    if (!fechaNacimiento) return "";

    const hoy = new Date();
    const nacimiento = new Date(fechaNacimiento);

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    const mes = hoy.getMonth() - nacimiento.getMonth();

    // Ajuste si aún no ha cumplido años este año
    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate()))
        edad--;

    return edad;
};

// Calculamos la fecha límite (Hace 18 años exactamente)
    const getMaxDate18YearsAgo = () => {
        const today = new Date();
        today.setFullYear(today.getFullYear() - 18);
        return today.toISOString().split("T")[0]; // Formato "YYYY-MM-DD"
    };

    const maxDateAllowed = getMaxDate18YearsAgo();
    
export default function EmployeeDrawer({
    isOpen,
    onClose,
    employee,
    style,
    onDelete,
    zones,
}) {
    const [isConfirming, setIsConfirming] = useState(false);
    const [isEditing, setIsEditing] = useState(false);
    const [editData, setEditData] = useState({ telephones: [] });

    // Estado para saber dónde se abrió el select y poder posicionar el portal
    const [selectMenuPosition, setSelectMenuPosition] = useState(null);

    useEffect(() => {
        if (employee) {
            setEditData({
                ...employee,
                telephones: employee.telephones || [],
            });
        }
    }, [employee]);

    if (!employee) return null;

    // Añade una caja vacía al array de teléfonos
    const handleAddPhone = () => {
        setEditData({
            ...editData,
            telephones: [...(editData.telephones || []), { telephone: "" }],
        });
    };

    // Elimina una caja de teléfono específica
    const handleRemovePhone = (index) => {
        const newPhones = editData.telephones.filter((_, i) => i !== index);
        setEditData({ ...editData, telephones: newPhones });
    };

    const handleClose = () => {
        setIsConfirming(false);
        setIsEditing(false);
        setSelectMenuPosition(null); // Limpiar Portal
        onClose();
    };

    const handleChange = (e) => {
        setEditData({ ...editData, [e.target.name]: e.target.value });
    };

    const handlePhoneChange = (index, value) => {
        const newPhones = [...editData.telephones];
        newPhones[index].telephone = value;
        setEditData({ ...editData, telephones: newPhones });
    };

    const handleUpdate = async () => {
        try {
            // 1. Limpiamos los datos antes de enviarlos a Laravel
            const payload = {
                ...editData,
                // Si la zona está vacía, forzamos un null real para que Laravel no explote
                zone_id: editData.zone_id ? parseInt(editData.zone_id) : null,
            };

            const response = await fetch(`/empleados/${employee.dni}`, {
                method: "PUT",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]',
                    ).content,
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(payload),
            });

            if (response.ok) {
                alert("¡Datos actualizados con éxito!");
                window.location.reload();
            } else {
                // 2. Extraemos el error exacto que devuelve Laravel
                const errorData = await response.json();
                console.error("Fallo detectado:", errorData);

                // Mostramos el mensaje de validación real en el alert
                const errorMessage =
                    errorData.message ||
                    JSON.stringify(errorData.errors) ||
                    "Error desconocido en el servidor";
                alert("❌ Laravel dice: \n\n" + errorMessage);
            }
        } catch (error) {
            console.error("Fallo de red:", error);
            alert("Fallo de conexión con el servidor.");
        }
    };

    const inputClass =
        "w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none transition-all text-slate-700";

    return (
        <>
            {isOpen && (
                <div
                    className="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-50 transition-opacity"
                    onClick={handleClose}
                ></div>
            )}

            <aside
                className={`fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform transition-transform duration-500 ease-out flex flex-col border-l border-slate-200 ${isOpen ? "translate-x-0" : "translate-x-full"}`}
            >
                {/* Cabecera */}
                <div className="bg-slate-50 p-6 border-b border-slate-200 shrink-0">
                    <button
                        onClick={handleClose}
                        className="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-white border border-slate-200 text-slate-400 hover:text-red-500 transition-all shadow-sm z-10"
                    >
                        <i className="fa-solid fa-xmark"></i>
                    </button>
                    <div className="flex items-center gap-4 mt-2">
                        <div
                            className={`w-16 h-16 rounded-full flex items-center justify-center text-2xl font-black bg-${style?.colorValue}-50 text-${style?.colorValue}-700 ring-4 ring-white shadow-inner shrink-0`}
                        >
                            {employee.name.charAt(0)}
                            {employee.surname.charAt(0)}
                        </div>
                        <div className="flex-1 min-w-0">
                            {isEditing ? (
                                <div className="flex flex-col gap-1">
                                    <input
                                        name="name"
                                        value={editData.name}
                                        onChange={handleChange}
                                        className={inputClass}
                                    />
                                    <input
                                        name="surname"
                                        value={editData.surname}
                                        onChange={handleChange}
                                        className={inputClass}
                                    />
                                </div>
                            ) : (
                                <>
                                    <h2 className="text-xl font-black text-slate-800 truncate">
                                        {employee.name} {employee.surname}
                                    </h2>
                                    <p className="text-slate-500 text-xs font-mono font-bold tracking-widest">
                                        {employee.dni}
                                    </p>
                                </>
                            )}
                        </div>
                    </div>
                </div>

                {/* Contenido */}
                <div className="flex-grow overflow-y-auto p-6 space-y-8 scrollbar-hide">
                    <div
                        className={`inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border ${style?.bg} ${style?.text} border-transparent shadow-sm`}
                    >
                        <i className={`fa-solid ${style?.icon}`}></i>{" "}
                        {employee.position}
                    </div>

                    {/* Información de Zona */}
                    <div className="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 space-y-3">
                        <div className="flex items-center gap-4">
                            <div className="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-blue-600 shadow-sm shrink-0">
                                <i className="fa-solid fa-map-location-dot text-lg"></i>
                            </div>
                            <div>
                                <p className="text-[10px] font-black text-blue-400 uppercase tracking-tighter">
                                    Ubicación Asignada
                                </p>
                                {!isEditing && (
                                    <p className="text-lg font-bold text-blue-900">
                                        {employee.zone
                                            ? employee.zone.type
                                            : "Sin zona"}
                                    </p>
                                )}
                            </div>
                        </div>

                        {/* Si estamos editando, mostramos las zonas */}
                        {isEditing && (
                            <div className="grid grid-cols-2 gap-2 mt-2">
                                {zones?.map((z) => (
                                    <button
                                        key={z.id}
                                        type="button"
                                        onClick={() =>
                                            setEditData({
                                                ...editData,
                                                zone_id: z.id,
                                            })
                                        }
                                        className={`px-3 py-2 rounded-lg text-xs font-bold border transition-all ${
                                            editData.zone_id === z.id
                                                ? "bg-blue-600 border-blue-600 text-white shadow-md"
                                                : "bg-white border-slate-200 text-slate-600 hover:border-blue-300"
                                        }`}
                                    >
                                        {z.type}
                                    </button>
                                ))}
                            </div>
                        )}
                    </div>

                    {/* Datos Detallados */}
                    <div className="space-y-4">
                        <h4 className="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 text-left">
                            Información de contacto
                        </h4>
                        <div className="space-y-4">

                            {/* EMAIL */}
                            <div className="flex items-center gap-3">
                                <div className="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                    <i className="fa-solid fa-envelope"></i>
                                </div>
                                {isEditing ? (
                                    <input
                                        name="email"
                                        value={editData.email}
                                        onChange={handleChange}
                                        className={inputClass}
                                    />
                                ) : (
                                    <span className="text-sm font-medium text-slate-700 truncate">
                                        {employee.email}
                                    </span>
                                )}
                            </div>

                            {/* DIRECCIÓN */}
                            <div className="flex items-center gap-3">
                                <div className="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                    <i className="fa-solid fa-location-dot"></i>
                                </div>
                                <div className="flex-1">
                                    {isEditing ? (
                                        <div className="space-y-2">
                                            <input
                                                name="address"
                                                value={editData.address}
                                                onChange={handleChange}
                                                className={inputClass}
                                                placeholder="Dirección"
                                            />
                                            <input
                                                name="province"
                                                value={editData.province}
                                                onChange={handleChange}
                                                className={inputClass}
                                                placeholder="Provincia"
                                            />
                                        </div>
                                    ) : (
                                        <span className="text-sm font-medium text-slate-700">
                                            {employee.address},{" "}
                                            {employee.province}
                                        </span>
                                    )}
                                </div>
                            </div>

                            {/* --- NUEVO: FECHA DE NACIMIENTO --- */}
                            <div className="flex items-center gap-3">
                                <div className="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 shrink-0">
                                    <i className="fa-solid fa-cake-candles"></i>
                                </div>
                                <div className="flex-1 min-w-0">
                                    {isEditing ? (
                                        <div className="flex items-center gap-2">
                                            <input
                                                type="date"
                                                name="birth_date"
                                                value={editData.birth_date || ""}
                                                onChange={handleChange}
                                                className={inputClass}
                                                max={maxDateAllowed}
                                            />
                                            {editData.birth_date && (
                                                <span className="text-[10px] bg-slate-200 px-2 py-2 rounded-lg font-black text-slate-500 shrink-0">
                                                    {calcularEdad(editData.birth_date)} AÑOS
                                                </span>
                                            )}
                                        </div>
                                    ) : (
                                        <div className="flex items-center gap-2">
                                            <span className="text-sm font-medium text-slate-700 truncate">
                                                {employee.birth_date
                                                    ? new Date(employee.birth_date).toLocaleDateString('es-ES')
                                                    : "Sin especificar"}
                                            </span>
                                            {employee.birth_date && (
                                                <span className="text-[9px] bg-white px-2 py-0.5 rounded-full border border-slate-200 font-bold text-slate-400 uppercase shrink-0">
                                                    {calcularEdad(employee.birth_date)} AÑOS
                                                </span>
                                            )}
                                        </div>
                                    )}
                                </div>
                            </div>

                        </div>
                    </div>

                    {/* Teléfonos */}
                    <div className="space-y-3">
                        <h4 className="text-xs font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2 text-left">
                            Teléfonos Registrados
                        </h4>
                        <div className="space-y-2">
                            {(isEditing
                                ? editData.telephones
                                : employee.telephones
                            )?.map((tel, idx) => (
                                <div
                                    key={idx}
                                    className="flex items-center gap-2 bg-slate-50 p-2 rounded-xl border border-slate-100"
                                >
                                    {isEditing ? (
                                        <>
                                            <input
                                                value={tel.telephone}
                                                onChange={(e) =>
                                                    handlePhoneChange(
                                                        idx,
                                                        e.target.value,
                                                    )
                                                }
                                                className="flex-1 bg-white border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-blue-400"
                                                placeholder="Ej: 600123456"
                                            />
                                            <button
                                                type="button"
                                                onClick={() =>
                                                    handleRemovePhone(idx)
                                                }
                                                className="w-9 h-9 flex items-center justify-center bg-red-50 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition-colors shrink-0"
                                                title="Borrar teléfono"
                                            >
                                                <i className="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </>
                                    ) : (
                                        <div className="flex items-center justify-between w-full px-2 py-1">
                                            <span className="text-sm font-mono font-bold text-slate-600 truncate flex-1 pr-4">
                                                <i className="fa-solid fa-phone mr-2 text-slate-400"></i>{" "}
                                                {tel.telephone}
                                            </span>
                                            <span className="text-[9px] bg-white px-2 py-0.5 rounded-full border border-slate-200 font-bold text-slate-400 uppercase shrink-0">
                                                {idx === 0
                                                    ? "Principal"
                                                    : `Secundario ${idx}`}
                                            </span>
                                        </div>
                                    )}
                                </div>
                            ))}

                            {isEditing && (
                                <button
                                    type="button"
                                    onClick={handleAddPhone}
                                    className="w-full mt-2 py-2 border-2 border-dashed border-slate-200 rounded-xl text-xs font-bold text-slate-500 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 transition-all flex justify-center items-center gap-2"
                                >
                                    <i className="fa-solid fa-plus"></i> AÑADIR
                                    OTRO TELÉFONO
                                </button>
                            )}
                        </div>
                    </div>
                </div>

                {/* Botones */}
                <div className="p-6 border-t border-slate-100 bg-slate-50 shrink-0">
                    {!isEditing ? (
                        <div className="flex gap-3">
                            <button
                                onClick={() => setIsEditing(true)}
                                className="flex-1 bg-white border border-slate-200 text-slate-800 px-4 py-3 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-100 transition-colors flex justify-center items-center gap-2"
                            >
                                <i className="fa-solid fa-pen-to-square"></i>{" "}
                                EDITAR FICHA
                            </button>
                            <button
                                onClick={() => setIsConfirming(true)}
                                className="px-4 py-3 bg-red-50 text-red-600 border border-red-100 rounded-xl hover:bg-red-600 hover:text-white transition-all"
                            >
                                <i className="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    ) : (
                        <div className="flex gap-3 animate-fade-in">
                            <button
                                onClick={handleUpdate}
                                className="flex-1 bg-emerald-600 text-white px-4 py-3 rounded-xl text-sm font-bold shadow-md hover:bg-emerald-700 flex justify-center items-center gap-2"
                            >
                                <i className="fa-solid fa-check"></i> GUARDAR
                            </button>
                            <button
                                onClick={() => setIsEditing(false)}
                                className="flex-1 bg-white border border-slate-200 text-slate-500 px-4 py-3 rounded-xl text-sm font-bold hover:bg-slate-100"
                            >
                                CANCELAR
                            </button>
                        </div>
                    )}

                    {isConfirming && !isEditing && (
                        <div className="mt-4 bg-red-50 p-4 rounded-xl border border-red-200 animate-bounce-in">
                            <p className="text-red-700 text-xs font-black text-center mb-3">
                                ¿ELIMINAR PERMANENTEMENTE?
                            </p>
                            <div className="flex gap-2">
                                <button
                                    onClick={() => onDelete(employee.dni)}
                                    className="flex-1 bg-red-600 text-white py-2 rounded-lg font-bold text-xs"
                                >
                                    SÍ, BORRAR
                                </button>
                                <button
                                    onClick={() => setIsConfirming(false)}
                                    className="flex-1 bg-white border border-slate-200 text-slate-600 py-2 rounded-lg font-bold text-xs"
                                >
                                    NO, VOLVER
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </aside>
        </>
    );
}
