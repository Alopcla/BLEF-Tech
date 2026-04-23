import React, { useState } from "react";

const formatearFechaYHora = (fechaIso) => {
    if (!fechaIso) return "Sin registro";
    return new Date(fechaIso).toLocaleString("es-ES", {
        day: "2-digit", month: "2-digit", year: "numeric",
        hour: "2-digit", minute: "2-digit",
    });
};

export default function MedicalRecordDrawer({ isOpen, onClose, animal, onDeleteRequest, onShowToast }) {
    const [isAddingMode, setIsAddingMode] = useState(false);
    const [newRecord, setNewRecord] = useState({ diagnosis: "", treatment: "" });

    if (!animal) return null;

    const handleClose = () => {
        setIsAddingMode(false);
        setNewRecord({ diagnosis: "", treatment: "" });
        onClose();
    };

    const handleSave = async () => {
        if (!newRecord.diagnosis || !newRecord.treatment) {
            return onShowToast("Rellena el diagnóstico y el tratamiento.", "error");
        }
        try {
            const response = await fetch("/api/medico/historial", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Content-Type": "application/json", Accept: "application/json",
                },
                body: JSON.stringify({ animal_id: animal.id, ...newRecord }),
            });

            if (response.ok) {
                onShowToast("Diagnóstico guardado con éxito.", "success");
                setTimeout(() => window.location.reload(), 1500);
            } else {
                onShowToast("Error al guardar el diagnóstico.", "error");
            }
        } catch (error) {
            onShowToast("Error de conexión al guardar.", "error");
        }
    };

    return (
        <>
            {isOpen && <div className="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-50" onClick={handleClose}></div>}

            <aside className={`fixed top-0 right-0 h-full w-full max-w-lg bg-white shadow-2xl z-50 transform transition-transform duration-500 flex flex-col border-l border-slate-200 ${isOpen ? "translate-x-0" : "translate-x-full"}`}>
                {/* Cabecera */}
                <div className="bg-slate-50 p-6 relative border-b border-slate-200 shrink-0">
                    <div className="absolute top-4 right-4 flex gap-2">
                        <button onClick={onDeleteRequest} className="w-8 h-8 rounded-full bg-white text-red-500 hover:bg-red-500 hover:text-white border shadow-sm flex justify-center items-center"><i className="fa-solid fa-trash-can"></i></button>
                        <button onClick={handleClose} className="w-8 h-8 rounded-full bg-white text-slate-400 hover:text-slate-700 border shadow-sm flex justify-center items-center"><i className="fa-solid fa-xmark"></i></button>
                    </div>
                    <div className="flex items-center gap-4 mt-2">
                        <div className="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl bg-teal-50 text-teal-600 ring-4 ring-white"><i className="fa-solid fa-paw"></i></div>
                        <div>
                            <h2 className="text-2xl font-black text-slate-800">{animal.common_name || animal.name}</h2>
                            <p className="text-slate-500 text-xs font-mono font-bold tracking-widest uppercase">{animal.species}</p>
                        </div>
                    </div>
                </div>

                {/* Contenido Central */}
                <div className="flex-grow overflow-y-auto p-6 bg-white">
                    {!isAddingMode ? (
                        <div className="space-y-6">
                            <div className="flex justify-between items-end border-b pb-2">
                                <h3 className="text-xs font-black text-slate-400 uppercase tracking-widest">Historial Clínico</h3>
                                <span className="text-[10px] font-bold bg-slate-100 text-slate-500 px-2 py-1 rounded-md">{animal.medical_records?.length || 0} Entradas</span>
                            </div>
                            <div className="space-y-4">
                                {animal.medical_records?.map((record) => (
                                    <div key={record.id} className="bg-slate-50 border border-slate-200 rounded-2xl p-4 space-y-3">
                                        <div className="flex justify-between items-center border-b pb-2">
                                            <span className="text-xs font-bold text-slate-600"><i className="fa-solid fa-calendar-day text-teal-500 mr-2"></i>{formatearFechaYHora(record.created_at)}</span>
                                            <span className="text-[9px] font-black text-slate-400 uppercase">DNI: {record.employee_dni}</span>
                                        </div>
                                        <div><p className="text-[10px] font-black text-slate-400 uppercase mb-1">Diagnóstico</p><p className="text-sm text-slate-700">{record.diagnosis}</p></div>
                                        <div className="bg-white p-3 rounded-xl border"><p className="text-[10px] font-black text-teal-600 uppercase mb-1">Tratamiento</p><p className="text-sm text-slate-600">{record.treatment}</p></div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    ) : (
                        <div className="space-y-5 animate-fade-in">
                            <h3 className="text-xs font-black text-teal-600 uppercase border-b border-teal-100 pb-2 mb-4"><i className="fa-solid fa-file-medical mr-2"></i> Nueva Evaluación</h3>
                            <div className="space-y-1"><label className="text-[10px] font-black text-slate-400 uppercase">Diagnóstico Clínico</label><textarea value={newRecord.diagnosis} onChange={(e) => setNewRecord({ ...newRecord, diagnosis: e.target.value })} rows="4" className="w-full bg-slate-50 border rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none"></textarea></div>
                            <div className="space-y-1"><label className="text-[10px] font-black text-slate-400 uppercase">Tratamiento Recetado</label><textarea value={newRecord.treatment} onChange={(e) => setNewRecord({ ...newRecord, treatment: e.target.value })} rows="4" className="w-full bg-slate-50 border rounded-xl px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-teal-400 resize-none"></textarea></div>
                        </div>
                    )}
                </div>

                {/* Footer */}
                <div className="p-6 border-t bg-slate-50 shrink-0">
                    {!isAddingMode ? (
                        <button onClick={() => setIsAddingMode(true)} className="w-full bg-teal-600 text-white py-3.5 rounded-xl font-black hover:bg-teal-700 transition flex justify-center gap-2"><i className="fa-solid fa-stethoscope"></i> AÑADIR DIAGNÓSTICO</button>
                    ) : (
                        <div className="flex gap-3">
                            <button onClick={handleSave} className="flex-1 bg-teal-600 text-white py-3.5 rounded-xl font-black hover:bg-teal-700 transition"><i className="fa-solid fa-floppy-disk mr-2"></i> GUARDAR</button>
                            <button onClick={() => setIsAddingMode(false)} className="px-6 bg-white border text-slate-500 rounded-xl font-bold hover:bg-slate-100">CANCELAR</button>
                        </div>
                    )}
                </div>
            </aside>
        </>
    );
}
