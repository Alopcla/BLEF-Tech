import React, { useState, useEffect } from "react";
import NavigationModules from "./NavigationModules";
import AnimalFormModal from "./AnimalFormModal";
import Toast from "./Toast";
import MedicalRecordDrawer from "./MedicalRecordDrawer"; // <--- Importamos el componente pesado

export default function DoctorDashboard() {
    const [animals, setAnimals] = useState([]);
    const [doctorInfo, setDoctorInfo] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [zones, setZones] = useState([]);

    const [selectedAnimal, setSelectedAnimal] = useState(null);
    const [isDrawerOpen, setIsDrawerOpen] = useState(false);
    const [isAnimalFormOpen, setIsAnimalFormOpen] = useState(false);
    const [showDeleteConfirm, setShowDeleteConfirm] = useState(false);
    const [toastData, setToastData] = useState(null);

    const showToast = (message, type = "success") => setToastData({ message, type });

    useEffect(() => {
        fetch("/api/medico/datos")
            .then((res) => res.json())
            .then((data) => {
                setDoctorInfo(data.doctor);
                setAnimals(data.animals);
                setZones(data.zones || []);
                setIsLoading(false);
            })
            .catch((err) => console.error("Error cargando datos:", err));
    }, []);

    const handleSaveAnimal = (nuevoAnimal) => {
        const animalReal = nuevoAnimal?.data || nuevoAnimal?.animal || nuevoAnimal;
        if (animalReal && animalReal.id) setAnimals((prev) => [...prev, animalReal]);
        else window.location.reload();
    };

    const executeDeleteAnimal = async () => {
        try {
            const response = await fetch(`/api/medico/animal/${selectedAnimal.id}`, {
                method: "DELETE",
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content, Accept: "application/json" },
            });

            if (response.ok) {
                setAnimals((prev) => prev.filter((a) => a.id !== selectedAnimal.id));
                setShowDeleteConfirm(false);
                setIsDrawerOpen(false);
                showToast("El animal y su historial han sido eliminados.", "success");
            } else {
                showToast("Error al intentar eliminar el animal.", "error");
            }
        } catch (error) {
            showToast("Fallo de conexión al eliminar.", "error");
        }
    };

    if (isLoading) return <div className="min-h-screen flex justify-center items-center bg-slate-50"><i className="fa-solid fa-circle-notch fa-spin text-4xl text-teal-600"></i></div>;

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12 relative">
            {/* Header */}
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-teal-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md"><i className="fa-solid fa-stethoscope"></i></div>
                        <h1 className="text-xl font-black text-slate-800">Zoo<span className="text-teal-600">Pro</span> Doctor</h1>
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="/" className="bg-slate-50 hover:bg-slate-100 border text-slate-700 px-5 py-2 rounded-xl text-sm font-bold flex items-center gap-2"><i className="fa-solid fa-house"></i> Inicio</a>
                        <form method="POST" action="/logout" className="m-0">
                            <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                            <button type="submit" className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold flex gap-2"><i className="fa-solid fa-power-off"></i> Desconectar</button>
                        </form>
                    </div>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                {/* Sidebar */}
                <aside className="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-6">
                    <button onClick={() => setIsAnimalFormOpen(true)} className="w-full bg-teal-600 hover:bg-teal-700 text-white px-5 py-4 rounded-2xl font-black shadow-md flex justify-center gap-3">
                        <i className="fa-solid fa-plus text-lg"></i> NUEVO ANIMAL
                    </button>
                    <div className="bg-white px-5 py-4 rounded-3xl border shadow-sm flex items-center gap-4">
                        <div className="w-12 h-12 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center text-xl"><i className="fa-solid fa-user-doctor"></i></div>
                        <div>
                            <p className="text-xs font-black text-slate-400 uppercase">Zona: {doctorInfo?.zone_id || "General"}</p>
                            <p className="text-sm font-bold text-slate-800">{doctorInfo?.name} {doctorInfo?.surname}</p>
                        </div>
                    </div>
                    <NavigationModules currentPanel="Médico" />
                </aside>

                {/* Grid */}
                <section className="flex-1">
                    {animals.length === 0 ? (
                        <div className="bg-white p-12 text-center rounded-3xl border shadow-sm">
                            <i className="fa-solid fa-paw text-4xl text-slate-300 mb-4 block"></i>
                            <p className="text-slate-500 font-bold">No hay animales registrados en tu zona actual.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            {animals.map((animal) => (
                                <div key={animal.id} onClick={() => { setSelectedAnimal(animal); setIsDrawerOpen(true); }} className="bg-white rounded-3xl p-6 border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all cursor-pointer group flex flex-col justify-between">
                                    <div>
                                        <div className="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-teal-50 group-hover:text-teal-600 mb-4 transition-colors"><i className="fa-solid fa-paw text-2xl"></i></div>
                                        <h3 className="text-xl font-black text-slate-800">{animal.common_name || animal.name}</h3>
                                        <p className="text-xs font-bold text-slate-400 uppercase mb-4">{animal.species}</p>
                                    </div>
                                    <div className="pt-4 border-t flex justify-between items-center text-sm text-slate-500 font-medium">
                                        <span><i className="fa-regular fa-clock mr-1"></i> {animal.medical_records?.length || 0} Registros</span>
                                        <span className="text-teal-600 font-bold group-hover:translate-x-1 transition-transform">Ver ficha <i className="fa-solid fa-arrow-right text-xs"></i></span>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </section>
            </main>

            {/* Modales Compartidos */}
            <AnimalFormModal isOpen={isAnimalFormOpen} onClose={() => setIsAnimalFormOpen(false)} onSave={handleSaveAnimal} zones={zones} />
            <MedicalRecordDrawer isOpen={isDrawerOpen} onClose={() => setIsDrawerOpen(false)} animal={selectedAnimal} onDeleteRequest={() => setShowDeleteConfirm(true)} onShowToast={showToast} />

            {/* Modal Eliminar */}
            {showDeleteConfirm && selectedAnimal && (
                <div className="fixed inset-0 z-[200] flex items-center justify-center p-4">
                    <div className="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onClick={() => setShowDeleteConfirm(false)}></div>
                    <div className="relative bg-white rounded-3xl shadow-2xl p-8 max-w-sm text-center">
                        <div className="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-5"><i className="fa-solid fa-triangle-exclamation text-4xl"></i></div>
                        <h3 className="text-2xl font-black text-slate-800 mb-2">¿Eliminar animal?</h3>
                        <p className="text-slate-500 text-sm mb-8">Vas a borrar a <strong className="text-slate-700">{selectedAnimal.common_name}</strong>. Esta acción no se deshace.</p>
                        <div className="flex gap-3">
                            <button onClick={() => setShowDeleteConfirm(false)} className="flex-1 bg-slate-100 text-slate-600 py-3.5 rounded-xl font-bold">CANCELAR</button>
                            <button onClick={executeDeleteAnimal} className="flex-1 bg-red-600 text-white py-3.5 rounded-xl font-black flex justify-center gap-2"><i className="fa-solid fa-trash-can"></i> ELIMINAR</button>
                        </div>
                    </div>
                </div>
            )}
            <Toast message={toastData?.message} type={toastData?.type} onClose={() => setToastData(null)} />
        </div>
    );
}
