import React, { useState, useEffect, useMemo } from 'react';
import NavigationModules from './NavigationModules';

export default function GuideDashboard() {
    const [reservations, setReservations] = useState([]);
    const [guideInfo, setGuideInfo] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    const [selectedReservation, setSelectedReservation] = useState(null);
    const [isDrawerOpen, setIsDrawerOpen] = useState(false);

    useEffect(() => {
        fetch('/api/guide/data')
            .then(res => res.json())
            .then(data => {
                setGuideInfo(data.guide);
                setReservations(data.reservations || []);
                setIsLoading(false);
            })
            .catch(err => {
                console.error("Error cargando datos:", err);
                setIsLoading(false);
            });
    }, []);

    const pendingReservations = useMemo(() => reservations.filter(r => r.status == true), [reservations]);
    const completedReservations = useMemo(() => reservations.filter(r => r.status == false), [reservations]);

    const openReservationDetails = (reservation) => {
        setSelectedReservation(reservation);
        setIsDrawerOpen(true);
    };

    if (isLoading) {
        return <div className="min-h-screen flex justify-center items-center bg-slate-50"><i className="fa-solid fa-circle-notch fa-spin text-4xl text-purple-600"></i></div>;
    }

    return (
        <div className="min-h-screen bg-slate-50 font-sans text-slate-800 pb-12">
            <header className="bg-white border-b border-slate-200 sticky top-0 z-40 shadow-sm">
                <div className="max-w-[1600px] mx-auto px-6 py-4 flex justify-between items-center">
                    <div className="flex items-center gap-3">
                        <div className="bg-purple-600 text-white w-10 h-10 rounded-xl flex items-center justify-center text-xl shadow-md">
                            <i className="fa-solid fa-map-location-dot"></i>
                        </div>
                        <h1 className="text-xl font-black tracking-tight text-slate-800">
                            Zoo<span className="text-purple-600">Pro</span> Guide
                        </h1>
                    </div>
                    <form method="POST" action="/logout" className="m-0">
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content} />
                        <button type="submit" className="bg-red-50 hover:bg-red-100 border border-red-200 text-red-600 px-5 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                            <i className="fa-solid fa-power-off"></i> Desconectar
                        </button>
                    </form>
                </div>
            </header>

            <main className="max-w-[1600px] mx-auto px-6 mt-8 flex flex-col lg:flex-row gap-8">
                <aside className="w-full lg:w-1/3 xl:w-1/4 flex flex-col gap-6">
                    <div className="bg-white px-5 py-4 rounded-3xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div className="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center font-black text-xl">
                            <i className="fa-solid fa-user-tie"></i>
                        </div>
                        <div>
                            <p className="text-xs font-black text-slate-400 uppercase tracking-widest">Guía Asignado</p>
                            <p className="text-sm font-bold text-slate-800">{guideInfo?.name} {guideInfo?.surname}</p>
                        </div>
                    </div>
                    <NavigationModules currentPanel="Guía" />
                </aside>

                <section className="flex-1">
                    {reservations.length === 0 ? (
                        <div className="bg-white p-12 text-center rounded-3xl border border-slate-200 shadow-sm">
                            <i className="fa-solid fa-route text-4xl text-slate-300 mb-4 block"></i>
                            <p className="text-slate-500 font-bold">No tienes experiencias asignadas.</p>
                        </div>
                    ) : (
                        <div className="flex flex-col gap-10">
                            {pendingReservations.length > 0 && (
                                <div>
                                    <h2 className="text-sm font-black text-amber-500 uppercase tracking-widest mb-6"><i className="fa-solid fa-clock mr-2"></i> Rutas Pendientes</h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        {pendingReservations.map(res => (
                                            <div key={res.id} onClick={() => openReservationDetails(res)} className="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm hover:shadow-xl cursor-pointer">
                                                <h3 className="text-xl font-black text-slate-800">{res.experience?.name || 'Ruta'}</h3>
                                                <p className="text-xs font-bold text-slate-400 mt-2">{res.reservation_date}</p>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                            {completedReservations.length > 0 && (
                                <div>
                                    <h2 className="text-sm font-black text-purple-600 uppercase tracking-widest mb-6"><i className="fa-solid fa-check-double mr-2"></i> Rutas Completadas</h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6 opacity-75">
                                        {completedReservations.map(res => (
                                            <div key={res.id} onClick={() => openReservationDetails(res)} className="bg-white rounded-3xl p-6 border border-purple-100 shadow-sm cursor-pointer">
                                                <h3 className="text-xl font-black text-slate-800">{res.experience?.name || 'Ruta'}</h3>
                                                <p className="text-xs font-bold text-slate-400 mt-2">{res.reservation_date}</p>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    )}
                </section>
            </main>
            <GuideDrawer isOpen={isDrawerOpen} onClose={() => setIsDrawerOpen(false)} reservation={selectedReservation} />
        </div>
    );
}

function GuideDrawer({ isOpen, onClose, reservation }) {
    if (!reservation) return null;
    const isPending = reservation.status == true;

    const handleComplete = async () => {
        try {
            const response = await fetch('/api/guide/complete', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reservation_id: reservation.id })
            });
            if (response.ok) window.location.reload();
        } catch (error) { alert("Error al procesar."); }
    };

    return (
        <>
            {isOpen && <div className="fixed inset-0 bg-slate-900/20 backdrop-blur-sm z-50" onClick={onClose}></div>}
            <aside className={`fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform transition-transform duration-500 flex flex-col ${isOpen ? 'translate-x-0' : 'translate-x-full'}`}>
                <div className="p-6 border-b border-slate-200 flex justify-between items-center bg-slate-50">
                    <h2 className="text-xl font-black text-slate-800">Detalles de la Ruta</h2>
                    <button onClick={onClose} className="text-slate-400 hover:text-red-500"><i className="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <div className="p-6 flex-grow overflow-y-auto">
                    <p className="font-bold text-purple-600 mb-2">{reservation.experience?.name}</p>
                    <p className="text-sm text-slate-600 mb-6">Cliente DNI: {reservation.customer_dni}</p>
                </div>
                <div className="p-6 bg-slate-50 border-t border-slate-100">
                    <button onClick={handleComplete} disabled={!isPending} className={`w-full py-4 rounded-xl text-sm font-black flex justify-center items-center gap-2 ${!isPending ? 'bg-slate-200 text-slate-400 cursor-not-allowed' : 'bg-purple-600 text-white hover:bg-purple-700'}`}>
                        {!isPending ? 'RUTA COMPLETADA' : 'MARCAR COMO COMPLETADA'}
                    </button>
                </div>
            </aside>
        </>
    );
}
