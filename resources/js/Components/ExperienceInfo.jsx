import { useState, useEffect } from "react";

/* ===================== TICKET MODAL ===================== */
function TicketModal({ isOpen, onClose, expId, expName, tickets, userEmail }) {
    const [selectedTicket, setSelectedTicket] = useState(null);
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    if (!isOpen) return null;

    const confirmarReserva = async () => {
        if (!selectedTicket) return;

        setLoading(true);
        setError('');

        try {
            const res = await fetch('/api/experiencias/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({
                    experiencia_id: expId,
                    ticket_id: selectedTicket.id,
                    fecha: selectedTicket.visit_day,
                    email: userEmail,
                }),
            });

            const data = await res.json();

            if (data.url) {
                window.location.href = data.url;
            } else {
                setError(data.error || 'Error al procesar la reserva.');
            }
        } catch {
            setError('Error de conexión.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div className="absolute inset-0 bg-black/80 backdrop-blur-sm" onClick={onClose} />

            <div className="relative bg-[#1A2E1A] border border-white/10 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">

                {/* CLOSE */}
                <button
                    onClick={onClose}
                    className="absolute top-6 right-6 text-white/40 hover:text-white transition"
                >
                    <i className="fa-solid fa-xmark" />
                </button>

                {/* HEADER (Blade style) */}
                <div className="mb-8 text-center">
                    <div className="inline-block px-3 py-1 rounded-full bg-[#D9C8A1]/10 text-[#D9C8A1] text-[11px] font-black uppercase tracking-widest border border-[#D9C8A1]/20 mb-6">
                        Experiencia
                    </div>

                    <h2 className="text-2xl font-black text-white">
                        Selecciona tu entrada
                    </h2>

                    <p className="text-white/30 text-[10px] uppercase tracking-widest mt-2">
                        Se reservará automáticamente la fecha del ticket
                    </p>
                </div>

                {/* LIST */}
                <div className="space-y-4 max-h-60 overflow-y-auto pr-1">
                    {tickets.map(ticket => (
                        <label
                            key={ticket.id}
                            onClick={() => setSelectedTicket(ticket)}
                            className="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 transition"
                        >
                            <div className="flex items-center gap-3">
                                <input
                                    type="radio"
                                    checked={selectedTicket?.id === ticket.id}
                                    onChange={() => setSelectedTicket(ticket)}
                                    className="accent-[#D9C8A1]"
                                />

                                <div>
                                    <span className="block text-white font-bold text-sm">
                                        {ticket.visit_day_formatted}
                                    </span>
                                    <span className="text-white/40 text-xs font-mono">
                                        {ticket.cod_ticket}
                                    </span>
                                </div>
                            </div>
                        </label>
                    ))}
                </div>

                {/* ERROR */}
                {error && (
                    <p className="text-red-400 text-xs text-center mt-4">
                        {error}
                    </p>
                )}

                {/* BUTTON */}
                <div className="mt-8 pt-6 border-t border-white/5">
                    <button
                        onClick={confirmarReserva}
                        disabled={!selectedTicket || loading}
                        className="group relative w-full flex items-center justify-center gap-3 bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] px-10 py-5 rounded-2xl font-black uppercase text-xs tracking-[2px] shadow-xl hover:-translate-y-1 transition-all overflow-hidden disabled:opacity-40"
                    >
                        <div className="absolute inset-0 bg-white/30 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700 skew-x-12" />
                        <span className="relative z-10">
                            {loading ? "Procesando..." : "Confirmar Reserva"}
                        </span>
                    </button>
                </div>
            </div>
        </div>
    );
}

/* ===================== EMAIL MODAL ===================== */
function EmailModal({ isOpen, onClose, expId, expName }) {
    const [step, setStep] = useState('email');
    const [email, setEmail] = useState('');
    const [tickets, setTickets] = useState([]);
    const [selectedTicket, setSelectedTicket] = useState(null);
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);
    const [noTickets, setNoTickets] = useState(false);

    if (!isOpen) return null;

    const verificarEmail = async () => {
        if (!email) return setError('Introduce un email válido.');

        setLoading(true);
        setError('');
        setNoTickets(false); // reseteamos estado antes de comprobar

        try {
            const res = await fetch(`/api/tickets-by-email?email=${encodeURIComponent(email)}`);
            const data = await res.json();

            if (!data.tickets?.length) {
                setError('No hay entradas para este email.');
                setNoTickets(true); // marcamos que NO tiene tickets (para mostrar botón)
            } else {
                setTickets(data.tickets);
                setStep('tickets');
            }
        } catch {
            setError('Error al verificar.');
        } finally {
            setLoading(false);
        }
    };

    const confirmarReserva = async () => {
        if (!selectedTicket) return;

        setLoading(true);
        setError('');

        try {
            const res = await fetch('/api/experiencias/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({
                    experiencia_id: expId,
                    ticket_id: selectedTicket.id,
                    fecha: selectedTicket.visit_day,
                    email,
                }),
            });

            const data = await res.json();

            if (data.url) {
                window.location.href = data.url;
            } else {
                setError(data.error || 'Error al procesar la reserva.');
            }
        } catch {
            setError('Error de conexión.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div className="absolute inset-0 bg-black/80 backdrop-blur-sm" onClick={onClose} />

            <div className="relative bg-[#1A2E1A] border border-white/10 w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">

                {/* CLOSE */}
                <button
                    onClick={onClose}
                    className="absolute top-6 right-6 text-white/40 hover:text-white transition"
                >
                    <i className="fa-solid fa-xmark" />
                </button>

                {/* HEADER */}
                <div className="text-center mb-8">
                    <div className="inline-block px-3 py-1 rounded-full bg-[#D9C8A1]/10 text-[#D9C8A1] text-[11px] font-black uppercase tracking-widest border border-[#D9C8A1]/20 mb-6">
                        Experiencia
                    </div>

                    <h2 className="text-2xl font-black text-white">
                        {step === 'email' ? '¿Tienes entrada?' : 'Selecciona tu entrada'}
                    </h2>

                    <p className="text-white/30 text-[10px] uppercase tracking-widest mt-2">
                        {step === 'email'
                            ? 'Introduce tu email para verificar'
                            : 'Se reservará automáticamente la fecha del ticket'}
                    </p>
                </div>

                {/* STEP EMAIL */}
                {step === 'email' && (
                    <>
                        <input
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            className="w-full p-4 rounded-2xl bg-white/5 border border-white/10 text-white focus:ring-1 focus:ring-[#D9C8A1]"
                            placeholder="tu@email.com"
                        />

                        {error && (
                            <>
                                <p className="text-red-400 text-xs text-center mt-4">
                                    {error}
                                </p>

                                {/* si no tiene tickets mostramos botón para comprar */}
                                {noTickets && (
                                    <button
                                        onClick={() => window.location.href = "/pago"}
                                        className="mt-4 w-full border border-[#D9C8A1]/30 text-[#D9C8A1] py-3 rounded-xl text-xs font-bold uppercase hover:bg-[#D9C8A1]/10 transition"
                                    >
                                        Comprar tickets
                                    </button>
                                )}
                            </>
                        )}

                        <button
                            onClick={verificarEmail}
                            disabled={loading}
                            className="mt-6 w-full bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] py-5 rounded-2xl font-black uppercase shadow-xl"
                        >
                            {loading ? 'Verificando...' : 'Verificar entradas'}
                        </button>
                    </>
                )}

                {/* STEP TICKETS */}
                {step === 'tickets' && (
                    <>
                        <div className="space-y-4 max-h-60 overflow-y-auto pr-1">
                            {tickets.map(ticket => (
                                <label
                                    key={ticket.id}
                                    onClick={() => setSelectedTicket(ticket)}
                                    className="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 transition"
                                >
                                    <div className="flex items-center gap-3">
                                        <input type="radio" className="accent-[#D9C8A1]" />

                                        <div>
                                            <span className="block text-white font-bold text-sm">
                                                {ticket.visit_day_formatted}
                                            </span>
                                            <span className="text-white/40 text-xs font-mono">
                                                {ticket.cod_ticket}
                                            </span>
                                        </div>
                                    </div>
                                </label>
                            ))}
                        </div>

                        {error && (
                            <p className="text-red-400 text-xs text-center mt-4">
                                {error}
                            </p>
                        )}

                        <button
                            onClick={confirmarReserva}
                            disabled={!selectedTicket || loading}
                            className="mt-6 w-full bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] py-5 rounded-2xl font-black uppercase shadow-xl disabled:opacity-40"
                        >
                            {loading ? 'Procesando...' : 'Confirmar Reserva'}
                        </button>
                    </>
                )}
            </div>
        </div>
    );
}

/* ===================== MAIN ===================== */
export default function ExperienceInfo({ isAuth, userEmail, expId, expName }) {
    const [modalTickets, setModalTickets] = useState(false);
    const [modalEmail, setModalEmail] = useState(false);
    const [userTickets, setUserTickets] = useState(null);
    const [ticketsLoading, setTicketsLoading] = useState(true);
    const hasTickets = userTickets?.length > 0;

    const handleReservar = () => {
        if (!isAuth) {
            setModalEmail(true);
            return;
        }

        if (ticketsLoading) return;

        // Usuario logueado
        if (hasTickets) {
            setModalTickets(true);
        } else {
            window.location.href = "/pago";
        }
    };

    useEffect(() => {
        if (isAuth && userEmail) {
            setTicketsLoading(true);

            fetch(`/api/tickets-by-email?email=${encodeURIComponent(userEmail)}`)
                .then(r => r.json())
                .then(data => {
                    setUserTickets(data.tickets ?? []);
                })
                .catch(() => {
                    setUserTickets([]);
                })
                .finally(() => {
                    setTicketsLoading(false);
                });
        }
    }, [isAuth, userEmail]);

    return (
        <>
            <button
                onClick={handleReservar}
                className="bg-gradient-to-r from-[#F2C94C] via-[#D9C8A1] to-[#F2994A] text-[#1A2E1A] px-6 py-3 rounded-xl font-black shadow-xl"
            >
                {ticketsLoading
                    ? "Cargando..."
                    : isAuth && !hasTickets
                        ? "Comprar tickets"
                        : "Reservar"}
            </button>

            <TicketModal
                isOpen={modalTickets}
                onClose={() => setModalTickets(false)}
                expId={expId}
                expName={expName}
                tickets={userTickets}
                userEmail={userEmail}
            />

            <EmailModal
                isOpen={modalEmail}
                onClose={() => setModalEmail(false)}
                expId={expId}
                expName={expName}
            />
        </>
    );
}