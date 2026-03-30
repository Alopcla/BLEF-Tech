import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom"; // <--- IMPORTACIÓN CRÍTICA

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
        const response = await fetch(`/empleados/${employee.dni}`, {
            method: 'PUT',
            // ... tus headers y el body: JSON.stringify(editData)
        });

        if (response.ok) {
            // --- AQUÍ VA EL CÓDIGO ---
            alert("Datos actualizados con éxito.");

            // Por último, recargas para ver los cambios reales
            window.location.reload();
        } else {
            alert("Error al actualizar");
        }
    } catch (error) {
        console.error(error);
    }
};

    // Función que abre el menú flotante
    const openSelectMenu = (e) => {
        if (!isEditing) return;

        // Calculamos dónde está el botón para poner el menú encima
        const rect = e.currentTarget.getBoundingClientRect();
        setSelectMenuPosition({
            top: rect.bottom + window.scrollY,
            left: rect.left,
            width: rect.width,
        });
    };

    // --- SUB-COMPONENTE: MENÚ FLOTANTE CON PORTAL ---
    const SelectPortal = ({ value, onChange }) => {
        if (!selectMenuPosition) return null;

        const menuStyle = {
            position: "absolute",
            top: `${selectMenuPosition.top}px`,
            left: `${selectMenuPosition.left}px`,
            width: `${selectMenuPosition.width}px`,
            zIndex: 9999, // <--- POR ENCIMA DE TODO
            backgroundColor: "white",
            border: "1px solid #e2e8f0",
            borderRadius: "0.75rem",
            boxShadow:
                "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
            maxHeight: "200px",
            overflowY: "auto",
            padding: "0.5rem 0",
        };

        // Pintamos el menú fuera del Drawer, en el 'body'
        return ReactDOM.createPortal(
            <div style={menuStyle} className="animate-fade-in-down">
                {zones?.map((z) => (
                    <div
                        key={z.id}
                        onClick={() => {
                            onChange({
                                target: { name: "zone_id", value: z.id },
                            });
                            setSelectMenuPosition(null); // Cerrar menú
                        }}
                        className={`px-4 py-2 text-sm cursor-pointer transition-colors
                                   ${value === z.id ? "bg-blue-50 text-blue-700 font-bold" : "hover:bg-slate-50 text-slate-700"}`}
                    >
                        {z.type}
                    </div>
                ))}
            </div>,
            document.body, // <--- DESTINO DEL PORTAL
        );
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

                    {/* Información de Zona - SOLUCIÓN FINAL SIN SELECT */}
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

                        {/* Si estamos editando, mostramos las zonas como botones seleccionables */}
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
                                    className="flex items-center justify-between bg-slate-50 p-3 rounded-xl border border-slate-100 overflow-hidden"
                                >
                                    {isEditing ? (
                                        <input
                                            value={tel.telephone}
                                            onChange={(e) =>
                                                handlePhoneChange(
                                                    idx,
                                                    e.target.value,
                                                )
                                            }
                                            className={inputClass}
                                        />
                                    ) : (
                                        <>
                                            <span className="text-sm font-mono font-bold text-slate-600 truncate flex-1 pr-4">
                                                <i className="fa-solid fa-phone mr-2 text-slate-400"></i>{" "}
                                                {tel.telephone}
                                            </span>
                                            <span className="text-[9px] bg-white px-2 py-0.5 rounded-full border border-slate-200 font-bold text-slate-400 uppercase shrink-0">
                                                {idx === 0
                                                    ? "Principal"
                                                    : `Secundario ${idx}`}
                                            </span>
                                        </>
                                    )}
                                </div>
                            ))}
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

            {/* --- EL COMPONENTE DEL PORTAL --- */}
            <SelectPortal value={editData.zone_id} onChange={handleChange} />
        </>
    );
}
