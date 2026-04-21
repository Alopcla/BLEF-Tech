import React, { useEffect, useState } from "react";
import { QRCodeCanvas } from "qrcode.react";

export default function MyOrders({ auth, initialEmail }) {
    const [tab, setTab] = useState("tickets");
    const [email, setEmail] = useState(initialEmail || "");
    const [loading, setLoading] = useState(false);
    const [data, setData] = useState({ tickets: [], experiencias: [], orders: [] });
    const [selectedTicket, setSelectedTicket] = useState(null);

    const fetchData = async (customEmail = null) => {
        setLoading(true);
        try {
            let url = "/api/compras";
            const finalEmail = customEmail || email;
            if (!finalEmail) return;
            url += `?email=${finalEmail}`;
            const res = await fetch(url);
            const json = await res.json();
            setData(json);
        } catch (error) {
            console.error("Error cargando compras:", error);
        }
        setLoading(false);
    };

    useEffect(() => {
        if (auth) fetchData();
    }, []);

    const formatDate = (dateString) => {
        return new Date(dateString).toLocaleDateString("es-ES", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
    };

    return (
        <div className="space-y-12 animate-fade-in">
            {/* SEARCH */}
            {!auth && (
                <div className="relative group max-w-2xl mx-auto">
                    <div className="absolute -inset-1 bg-gradient-to-r from-[#D9C8A1]/20 to-transparent rounded-[2rem] blur opacity-25 group-hover:opacity-50 transition"></div>
                    <div className="relative flex flex-col md:flex-row gap-4 p-2 bg-[#1A2E1A]/40 backdrop-blur-xl border border-white/10 rounded-[2rem]">
                        <div className="flex-grow relative">
                            <i className="fa-solid fa-envelope absolute left-6 top-1/2 -translate-y-1/2 text-[#D9C8A1]/40"></i>
                            <input
                                type="email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                placeholder="Tu correo electrónico de compra"
                                className="w-full pl-14 pr-6 py-4 bg-transparent text-white placeholder:text-white/20 text-sm focus:outline-none"
                            />
                        </div>
                        <button
                            onClick={() => fetchData(email)}
                            className="px-10 py-4 bg-[#D9C8A1] text-[#1A2E1A] rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-white transition"
                        >
                            {loading ? "..." : "Localizar Pedidos"}
                        </button>
                    </div>
                </div>
            )}

            {/* TABS */}
            <div className="flex gap-4 border-b border-white/5 pb-8 overflow-x-auto">
                {[
                    { id: "tickets", label: "Entradas" },
                    { id: "experiencias", label: "Experiencias" },
                    { id: "orders", label: "Tienda" },
                ].map((t) => (
                    <button
                        key={t.id}
                        onClick={() => setTab(t.id)}
                        className={`px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-colors ${
                            tab === t.id ? "bg-[#D9C8A1] text-[#1A2E1A]" : "text-white/40"
                        }`}
                    >
                        {t.label}
                    </button>
                ))}
            </div>

            {/* CONTENT - Columnas para evitar huecos blancos */}
            <div className="columns-1 lg:columns-2 gap-6 space-y-6">
                
                {/* TICKETS */}
                {tab === "tickets" &&
                    (data.tickets.length > 0 ? (() => {
                        const grouped = data.tickets.reduce((acc, t) => {
                            const key = t.stripe_session_id || `ticket_${t.id}`;
                            if (!acc[key]) acc[key] = { tickets: [] };
                            acc[key].tickets.push(t);
                            return acc;
                        }, {});

                        return Object.values(grouped).map((group, index) => {
                            // CORRECCIÓN: Tomamos el total del pedido directamente del primer ticket
                            // ya que 'total_order_amount' es el total de la transacción completa.
                            const firstTicket = group.tickets[0];
                            const orderTotal = parseFloat(firstTicket.total_order_amount) || 0;

                            return (
                                <div
                                    key={index}
                                    className="break-inside-avoid bg-[#1A2E1A]/60 border border-white/10 rounded-[2.5rem] p-8 hover:border-[#D9C8A1]/30 transition-all mb-6"
                                >
                                    <div className="flex justify-between items-start mb-8 pb-6 border-b border-white/5">
                                        <div className="flex gap-5 items-center">
                                            <div className="w-14 h-14 bg-[#D9C8A1]/10 flex items-center justify-center rounded-2xl text-[#D9C8A1] border border-[#D9C8A1]/20">
                                                <i className="fa-solid fa-ticket text-2xl" />
                                            </div>
                                            <div>
                                                <p className="text-white font-bold text-xl font-parkzoo tracking-wide">Pedido #{index + 1}</p>
                                                <p className="text-white/30 text-[10px] uppercase tracking-[2px] mt-1">
                                                    Realizado el {new Date(firstTicket.created_at).toLocaleDateString()}
                                                </p>
                                            </div>
                                        </div>
                                        <div className="text-right">
                                            {/* Ahora muestra el total correcto (ej. 15.00€) aunque haya 3 tickets dentro */}
                                            <p className="text-[#D9C8A1] font-black text-2xl">{orderTotal.toFixed(2)}€</p>
                                            <span className="bg-green-500/10 text-green-500 text-[9px] font-black uppercase px-3 py-1 rounded-full border border-green-500/20">
                                                Confirmado
                                            </span>
                                        </div>
                                    </div>

                                    <div className="space-y-4 max-h-[380px] overflow-y-auto pr-2 custom-scrollbar">
                                        {group.tickets.map((t) => (
                                            <div
                                                key={t.id}
                                                onClick={() => setSelectedTicket(t)}
                                                className="cursor-pointer flex items-center justify-between bg-white/[0.03] rounded-2xl p-4 border border-white/5 hover:bg-white/[0.05] transition-colors"
                                            >
                                                <div className="flex items-center gap-4">
                                                    <div className="w-12 h-12 rounded-xl bg-[#D9C8A1]/10 flex items-center justify-center text-[#D9C8A1] border border-[#D9C8A1]/20">
                                                        <i className="fa-solid fa-qrcode" />
                                                    </div>
                                                    <div>
                                                        <p className="text-white font-bold text-sm">Entrada General</p>
                                                        <p className="text-[#D9C8A1] font-mono text-xs">{t.cod_ticket}</p>
                                                        <p className="text-white/30 text-[10px] mt-1">{formatDate(t.visit_day)}</p>
                                                    </div>
                                                </div>
                                                <div className="text-right flex items-center gap-4">
                                                    <div className="flex flex-col items-end">
                                                        {/* Precio */}
                                                        <span className="text-white font-bold text-sm tracking-tight">
                                                            {t.price}€
                                                        </span>
                                                        <span className="text-[8px] text-[#D9C8A1] uppercase tracking-widest opacity-60">
                                                            Individual
                                                        </span>
                                                    </div>
                                                    <div className="w-8 h-8 rounded-full border border-white/5 flex items-center justify-center bg-white/5 group-hover:bg-[#D9C8A1] group-hover:text-[#1A2E1A] transition-all duration-300">
                                                        <i className="fa-solid fa-chevron-right text-[10px]"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                </div>
                            );
                        });
                    })() : (
                        <EmptyState message="No hay entradas registradas" />
                    ))
                }

                {/* EXPERIENCIAS */}
                {tab === "experiencias" && (
                    data.experiencias.length > 0 ? data.experiencias.map(e => (
                        <div key={e.id} className="break-inside-avoid bg-[#1A2E1A]/60 border border-white/10 rounded-[2rem] p-8 flex flex-col sm:flex-row gap-6 hover:border-[#D9C8A1]/30 transition-all group mb-6">
                            <div className="w-20 h-20 rounded-2xl bg-white/5 flex items-center justify-center text-[#D9C8A1] overflow-hidden shrink-0 border border-white/5">
                                {(e.experience?.image || e.image) ? (
                                    <img src={e.experience?.image || e.image} alt="Experiencia" className="w-full h-full object-cover" />
                                ) : (
                                    <i className="fa-solid fa-leaf text-2xl" />
                                )}
                            </div>
                            <div className="flex-1">
                                <p className="text-[#D9C8A1] text-[9px] font-black uppercase tracking-widest">Reserva Confirmada</p>
                                <h3 className="text-white font-bold text-lg">{e.experience?.name || "Experiencia Wild"}</h3>
                                <p className="text-white/40 text-xs mt-1"><i className="fa-solid fa-calendar-day mr-2"></i>{formatDate(e.reservation_date)}</p>
                                {e.ticket && <p className="text-[#D9C8A1] font-mono text-xs mt-2">🎟 Ticket: {e.ticket.cod_ticket}</p>}
                            </div>
                            <div className="text-[#D9C8A1] font-black text-xl self-start">{e.price}€</div>
                        </div>
                    )) : <EmptyState message="No hay experiencias reservadas" />
                )}

                {/* TIENDA */}
                {tab === "orders" && (
                    data.orders.length > 0 ? data.orders.map((o) => (
                        <div key={o.id} className="break-inside-avoid bg-[#1A2E1A]/60 border border-white/10 rounded-[2.5rem] p-8 hover:border-[#D9C8A1]/30 transition-all mb-6">
                            <div className="flex justify-between items-start mb-8 pb-6 border-b border-white/5">
                                <div className="flex gap-5 items-center">
                                    <div className="w-14 h-14 bg-[#D9C8A1]/10 flex items-center justify-center rounded-2xl text-[#D9C8A1] border border-[#D9C8A1]/20">
                                        <i className="fa-solid fa-receipt text-2xl" />
                                    </div>
                                    <div>
                                        <p className="text-white font-bold text-xl font-parkzoo tracking-wide">Pedido #{o.id}</p>
                                        <p className="text-white/30 text-[10px] uppercase tracking-[2px] mt-1">Realizado el {new Date(o.created_at).toLocaleDateString()}</p>
                                    </div>
                                </div>
                                <div className="text-right">
                                    <p className="text-[#D9C8A1] font-black text-2xl">{o.total}€</p>
                                    <span className="bg-green-500/10 text-green-500 text-[9px] font-black uppercase px-3 py-1 rounded-full border border-green-500/20">
                                        {o.status === 'paid' ? 'Pagado' : o.status}
                                    </span>
                                </div>
                            </div>

                            {/* LISTA CON SCROLL DESPUÉS DE ~3 PRODUCTOS */}
                            <div className="space-y-4 max-h-[380px] overflow-y-auto pr-2 custom-scrollbar">
                                {o.items?.map((item, idx) => (
                                    <div key={idx} className="flex items-center justify-between bg-white/[0.03] rounded-2xl p-4 border border-white/5 hover:bg-white/[0.05] transition-colors">
                                        <div className="flex items-center gap-4">
                                            <div className="w-16 h-16 rounded-xl overflow-hidden bg-black/40 border border-white/10 shrink-0">
                                                {item.product?.image_url ? <img src={item.product.image_url} alt={item.product.name} className="w-full h-full object-cover" /> : <i className="fa-solid fa-box text-xl text-white/10" />}
                                            </div>
                                            <div>
                                                <h4 className="text-white font-bold text-sm">{item.product?.name || 'Producto del Zoo'}</h4>
                                                <p className="text-white/40 text-xs">Cantidad: <span className="text-[#D9C8A1] font-bold">{item.quantity}</span></p>
                                            </div>
                                        </div>
                                        <div className="text-right">
                                            <p className="text-white/80 font-bold text-sm">{(item.quantity * item.unit_price).toFixed(2)}€</p>
                                            <p className="text-white/20 text-[10px]">{item.unit_price}€ / ud</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )) : <EmptyState message="Tu historial de compras está vacío" />
                )}
            </div>

            {/* MODAL QR */}
            {selectedTicket && (
                <div className="fixed inset-0 bg-black/70 flex items-center justify-center z-50">
                    <div className="bg-[#1A2E1A] p-8 rounded-3xl text-center relative">
                        <button onClick={() => setSelectedTicket(null)} className="absolute top-3 right-3 text-white/40 text-xl hover:text-white">✕</button>
                        <p className="text-[#D9C8A1] font-mono mb-4">{selectedTicket.cod_ticket}</p>
                        <div className="bg-white p-3 rounded-xl inline-block">
                            <QRCodeCanvas value={selectedTicket.cod_ticket} size={180} />
                        </div>
                    </div>
                </div>
            )}

            {/* Estilo para la barra de scroll personalizada */}
            <style jsx>{`
                .custom-scrollbar::-webkit-scrollbar {
                    width: 4px;
                }
                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: rgba(217, 200, 161, 0.2);
                    border-radius: 10px;
                }
                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: rgba(217, 200, 161, 0.4);
                }
            `}</style>
        </div>
    );
}

const EmptyState = ({ message }) => (
    <div className="col-span-full py-20 text-center bg-white/5 border border-dashed border-white/10 rounded-[3rem]">
        <p className="text-white/20 text-xs uppercase tracking-widest">{message}</p>
    </div>
);