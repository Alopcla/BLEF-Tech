import { useState, useEffect } from "react";

const API_BASE = "";

function StarRating({ spots }) {
    if (spots <= 0) return (
        <span className="text-red-400 text-[11px] font-black">Sold Out</span>
    );
    return (
        <div className="flex items-center justify-center gap-1.5">
            <span className={`relative flex h-1.5 w-1.5`}>
                <span className={`animate-ping absolute inline-flex h-full w-full rounded-full ${spots < 3 ? 'bg-orange-400' : 'bg-green-400'} opacity-75`}></span>
                <span className={`relative inline-flex rounded-full h-1.5 w-1.5 ${spots < 3 ? 'bg-orange-500' : 'bg-green-500'}`}></span>
            </span>
            <span className={`${spots < 3 ? 'text-orange-400' : 'text-[#D9C8A1]'} text-[11px] font-black`}>{spots}</span>
        </div>
    );
}

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
                    ticket_id:      selectedTicket.id,
                    fecha:          selectedTicket.visit_day,
                    email:          userEmail,
                }),
            });

            const data = await res.json();

            if (data.url) {
                window.location.href = data.url;
            } else {
                setError(data.error || 'Error al procesar la reserva.');
            }
        } catch {
            setError('Error de conexión. Inténtalo de nuevo.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div className="absolute inset-0 bg-black/80 backdrop-blur-sm" onClick={onClose}></div>
            <div className="relative bg-[#1A2E1A] border border-white/10 w-full max-w-md rounded-[2.5rem] p-8">

                <button onClick={onClose} className="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full border border-white/10 text-white/40 hover:text-white hover:bg-white/10 transition-all">
                    <i className="fa-solid fa-xmark text-sm"></i>
                </button>

                <h2 className="text-2xl font-parkzoo text-white mb-2 text-center">Selecciona tu entrada</h2>
                <p className="text-white/30 text-xs text-center mb-6 uppercase tracking-widest">La experiencia se reservará en la fecha del ticket</p>

                {tickets.length === 0 ? (
                    <div className="text-center py-6">
                        <i className="fa-solid fa-ticket-simple text-white/10 text-4xl mb-4 block"></i>
                        <p className="text-white/40 text-sm mb-6">No tienes entradas disponibles.</p>
                        <a href="/pago" className="inline-block bg-[#D9C8A1] text-[#1A2E1A] px-6 py-3 rounded-xl font-black uppercase text-xs tracking-widest hover:bg-white transition-all">
                            Comprar Entrada
                        </a>
                    </div>
                ) : (
                    <>
                        <div className="space-y-3 max-h-60 overflow-y-auto pr-1">
                            {tickets.map(ticket => (
                                <label key={ticket.id}
                                    onClick={() => setSelectedTicket(ticket)}
                                    className="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 hover:border-[#D9C8A1]/30 transition-all">
                                    <div className="flex items-center gap-3">
                                        <input type="radio" name="_ticket_modal"
                                            checked={selectedTicket?.id === ticket.id}
                                            onChange={() => setSelectedTicket(ticket)}
                                            className="accent-[#D9C8A1]" />
                                        <div>
                                            <span className="text-white font-bold block text-sm">{ticket.visit_day_formatted}</span>
                                            <span className="text-white/40 text-xs font-mono">{ticket.cod_ticket}</span>
                                        </div>
                                    </div>
                                    <span className="text-[#D9C8A1] text-xs font-bold px-3 py-1 bg-[#D9C8A1]/10 rounded-lg">
                                        {ticket.visit_day_short}
                                    </span>
                                </label>
                            ))}
                        </div>

                        {error && <p className="text-red-400 text-xs text-center mt-4">{error}</p>}

                        <button onClick={confirmarReserva}
                            disabled={!selectedTicket || loading}
                            className={`w-full mt-6 bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-xl font-black uppercase shadow-xl hover:bg-white transition-all ${!selectedTicket || loading ? 'opacity-50 cursor-not-allowed' : ''}`}>
                            {loading ? 'Procesando...' : 'Confirmar Reserva'}
                        </button>
                    </>
                )}
            </div>
        </div>
    );
}

function EmailModal({ isOpen, onClose, expId, expName }) {
    const [step, setStep] = useState('email');
    const [email, setEmail] = useState('');
    const [tickets, setTickets] = useState([]);
    const [selectedTicket, setSelectedTicket] = useState(null);
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    if (!isOpen) return null;

    const verificarEmail = async () => {
        if (!email) { setError('Introduce un email válido.'); return; }
        setError('');
        setLoading(true);

        try {
            const res = await fetch(`/api/tickets-by-email?email=${encodeURIComponent(userEmail)}`);
            const data = await res.json();

            if (!data.tickets || data.tickets.length === 0) {
                setError('No encontramos entradas disponibles para este email.');
            } else {
                setTickets(data.tickets);
                setStep('tickets');
            }
        } catch {
            setError('Error al verificar. Inténtalo de nuevo.');
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
                    ticket_id:      selectedTicket.id,
                    fecha:          selectedTicket.visit_day,
                    email:          email,
                }),
            });

            const data = await res.json();

            if (data.url) {
                window.location.href = data.url;
            } else {
                setError(data.error || 'Error al procesar la reserva.');
            }
        } catch {
            setError('Error de conexión. Inténtalo de nuevo.');
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div className="absolute inset-0 bg-black/80 backdrop-blur-sm" onClick={onClose}></div>
            <div className="relative bg-[#1A2E1A] border border-white/10 w-full max-w-md rounded-[2.5rem] p-8">

                <button onClick={onClose} className="absolute top-6 right-6 w-8 h-8 flex items-center justify-center rounded-full border border-white/10 text-white/40 hover:text-white hover:bg-white/10 transition-all">
                    <i className="fa-solid fa-xmark text-sm"></i>
                </button>

                {step === 'email' && (
                    <>
                        <h2 className="text-2xl font-parkzoo text-white mb-2 text-center">¿Tienes una entrada?</h2>
                        <p className="text-white/30 text-xs text-center mb-8 uppercase tracking-widest">Introduce tu email para verificar</p>

                        <div className="relative mb-4">
                            <div className="absolute inset-y-0 left-4 flex items-center pointer-events-none text-[#D9C8A1]/50">
                                <i className="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input
                                type="email"
                                value={email}
                                onChange={e => setEmail(e.target.value)}
                                onKeyDown={e => e.key === 'Enter' && verificarEmail()}
                                placeholder="tu@email.com"
                                className="w-full pl-11 pr-4 py-4 rounded-2xl bg-white/5 border border-white/10 text-white text-sm placeholder:text-white/20 focus:outline-none focus:ring-2 focus:ring-[#D9C8A1]/30 focus:border-[#D9C8A1]/50 transition-all"
                            />
                        </div>

                        {error && <p className="text-red-400 text-xs text-center mb-4">{error}</p>}

                        <button
                            onClick={verificarEmail}
                            disabled={loading}
                            className="w-full bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-xl font-black uppercase shadow-xl hover:bg-white transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            {loading ? 'Verificando...' : 'Verificar Entradas'}
                        </button>
                    </>
                )}

                {step === 'tickets' && (
                    <>
                        <h2 className="text-2xl font-parkzoo text-white mb-2 text-center">Selecciona tu entrada</h2>
                        <p className="text-white/30 text-xs text-center mb-6 uppercase tracking-widest">La experiencia se reservará en la fecha del ticket</p>

                        <div className="space-y-3 max-h-60 overflow-y-auto pr-1 mb-6">
                            {tickets.map(ticket => (
                                <label
                                    key={ticket.id}
                                    onClick={() => setSelectedTicket(ticket)}
                                    className="flex items-center justify-between p-4 bg-white/5 border border-white/10 rounded-2xl cursor-pointer hover:bg-[#D9C8A1]/10 hover:border-[#D9C8A1]/30 transition-all">
                                    <div className="flex items-center gap-3">
                                        <input
                                            type="radio"
                                            name="_ticket_guest"
                                            checked={selectedTicket?.id === ticket.id}
                                            onChange={() => setSelectedTicket(ticket)}
                                            className="accent-[#D9C8A1]"
                                        />
                                        <div>
                                            <span className="text-white font-bold block text-sm">{ticket.visit_day_formatted}</span>
                                            <span className="text-white/40 text-xs font-mono">{ticket.cod_ticket}</span>
                                        </div>
                                    </div>
                                </label>
                            ))}
                        </div>

                        {error && <p className="text-red-400 text-xs text-center mb-4">{error}</p>}

                        <button
                            onClick={confirmarReserva}
                            disabled={!selectedTicket || loading}
                            className={`w-full bg-[#D9C8A1] text-[#1A2E1A] py-4 rounded-xl font-black uppercase shadow-xl hover:bg-white transition-all ${!selectedTicket || loading ? 'opacity-50 cursor-not-allowed' : ''}`}>
                            {loading ? 'Procesando...' : 'Confirmar Reserva'}
                        </button>

                        <button
                            onClick={() => { setStep('email'); setSelectedTicket(null); setError(''); }}
                            className="w-full mt-3 text-white/30 text-xs uppercase tracking-widest hover:text-white/60 transition-colors">
                            ← Cambiar email
                        </button>
                    </>
                )}
            </div>
        </div>
    );
}

function ExperienciaCard({ exp, isPopular, isAuth, userTickets, onReservar }) {
    const spots = exp.available_spots ?? 0;

    const handleReservar = () => onReservar(exp);

    const botonReserva = () => {
        if (!isAuth) return null;

        if (userTickets.length === 0) {
            return (
                <a href="/pago"
                    className={`${isPopular ? 'flex-[4]' : 'flex-[3]'} bg-orange-600 text-white py-4 rounded-2xl font-black text-xs uppercase text-center flex items-center justify-center gap-2`}>
                    <i className="fa-solid fa-ticket"></i> Comprar Ticket
                </a>
            );
        }

        return (
            <button onClick={handleReservar}
                className={`${isPopular ? 'flex-[4] py-5 text-sm' : 'flex-[3] py-4 text-xs'} bg-[#D9C8A1] text-[#1A2E1A] rounded-2xl font-black uppercase tracking-[1px] hover:bg-white transition-all`}>
                {isPopular ? 'Reservar Ahora' : 'Reservar'}
            </button>
        );
    };

    if (isPopular) return (
        <div className="mb-16">
            <div className="group relative bg-[#1A2E1A]/40 backdrop-blur-md rounded-[2rem] border border-white/5 p-3 md:p-4 transition-all duration-500 hover:bg-[#1A2E1A]/80 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)]">
                <div className="absolute -top-3 -right-3 z-20 bg-gradient-to-r from-orange-500 to-yellow-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-xl rotate-12 uppercase tracking-tighter">
                    Popular 🔥
                </div>
                <div className="flex flex-col md:flex-row gap-6 md:gap-10">
                    <div className="relative h-72 md:h-[400px] md:w-2/5 overflow-hidden rounded-[1.5rem] shrink-0">
                        <img src={exp.image} className="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt={exp.name} />
                        <div className="absolute top-4 left-4 backdrop-blur-md bg-white/10 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl uppercase tracking-widest">
                            {exp.type ?? 'Safari'}
                        </div>
                    </div>

                    <div className="flex-grow flex flex-col justify-center px-4 py-2 md:py-6 md:pr-6">
                        <div className="flex justify-between items-start mb-4">
                            <div className="flex items-center gap-2">
                                <div className="w-2 h-2 rounded-full bg-[#D9C8A1] animate-pulse"></div>
                                <h3 className="text-3xl md:text-5xl font-parkzoo font-bold text-white leading-tight font-parkzoo fuenteZoo">{exp.name}</h3>
                            </div>
                            <div className="bg-[#D9C8A1] text-[#1A2E1A] px-5 py-2 rounded-xl font-black text-xl shadow-2xl shrink-0">
                                {exp.price}€
                            </div>
                        </div>

                        <p className="text-gray-400 text-base md:text-lg mb-8 font-medium font-parkzoo fuenteZoo">"{exp.description}"</p>

                        <div className="grid grid-cols-3 gap-4 py-6 border-y border-white/10 mb-8">
                            <div className="text-center border-r border-white/5">
                                <span className="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Tiempo</span>
                                <span className="text-white text-sm md:text-base font-bold">{exp.duration_min}'</span>
                            </div>
                            <div className="text-center border-r border-white/5">
                                <span className="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Disponibles</span>
                                <div className="flex items-center justify-center gap-2">
                                    <span className="relative flex h-2 w-2">
                                        <span className={`animate-ping absolute inline-flex h-full w-full rounded-full ${spots < 3 ? 'bg-orange-400' : 'bg-green-400'} opacity-75`}></span>
                                        <span className={`relative inline-flex rounded-full h-2 w-2 ${spots < 3 ? 'bg-orange-500' : 'bg-green-500'}`}></span>
                                    </span>
                                    <span className={`${spots < 3 ? 'text-orange-400' : 'text-[#D9C8A1]'} text-sm md:text-base font-black`}>{spots}</span>
                                </div>
                            </div>
                            <div className="text-center">
                                <span className="block text-[10px] uppercase text-white/30 font-bold tracking-widest mb-1">Capacidad</span>
                                <span className="text-white text-sm md:text-base font-bold">{exp.capacity} <i className="fa-solid fa-users text-[#D9C8A1] ml-1"></i></span>
                            </div>
                        </div>

                        <div className="flex gap-4">
                            {botonReserva()}
                            <a href={`/experiencias/${exp.slug}`}
                                className={`${isAuth ? 'flex-1' : 'flex-grow py-5'} border border-[#D9C8A1]/30 rounded-2xl flex items-center justify-center text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all font-bold uppercase text-xs tracking-widest gap-2 font-parkzoo fuenteZoo`}>
                                {!isAuth && 'Ver Detalles'} <i className="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );

    return (
        <div className="group relative bg-[#1A2E1A]/40 backdrop-blur-md rounded-[2rem] border border-white/5 p-3 pb-6 transition-all duration-500 hover:bg-[#1A2E1A]/80 hover:shadow-[0_20px_50px_rgba(0,0,0,0.5)] hover:-translate-y-2">
            {spots <= 0 && (
                <div className="absolute -top-3 -right-3 z-20 bg-red-600 text-white text-[10px] font-black px-4 py-1.5 rounded-full shadow-xl rotate-12 uppercase tracking-tighter">Sold Out</div>
            )}
            <div className="relative h-64 w-full overflow-hidden rounded-[1.5rem] mb-6">
                <img src={exp.image} loading="lazy" className="w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" alt={exp.name} />
                <div className="absolute inset-0 bg-gradient-to-t from-[#1A2E1A] via-transparent to-transparent opacity-80"></div>
                <div className="absolute top-4 left-4 backdrop-blur-md bg-white/10 border border-white/20 text-white text-[10px] font-bold px-3 py-1.5 rounded-xl uppercase tracking-widest">{exp.type ?? 'Safari'}</div>
                <div className="absolute bottom-4 right-4 bg-[#D9C8A1] text-[#1A2E1A] px-4 py-1 rounded-lg font-black text-lg shadow-2xl">{exp.price}€</div>
            </div>

            <div className="px-4">
                <div className="flex items-center gap-2 mb-2">
                    <div className="w-2 h-2 rounded-full bg-[#D9C8A1] animate-pulse"></div>
                    <h3 className="text-2xl font-parkzoo font-bold text-white leading-tight font-parkzoo fuenteZoo">{exp.name}</h3>
                </div>
                <p className="text-gray-400 text-sm line-clamp-2 mb-6 font-medium leading-relaxed font-parkzoo fuenteZoo">"{exp.description}"</p>

                <div className="grid grid-cols-3 gap-2 py-4 border-t border-white/10 mb-6">
                    <div className="text-center border-r border-white/5">
                        <span className="block text-[8px] uppercase text-white/30 font-bold mb-1">Tiempo</span>
                        <span className="text-white text-[11px] font-bold">{exp.duration_min}'</span>
                    </div>
                    <div className="text-center border-r border-white/5">
                        <span className="block text-[8px] uppercase text-white/30 font-bold mb-1">Libres</span>
                        <StarRating spots={spots} />
                    </div>
                    <div className="text-center">
                        <span className="block text-[8px] uppercase text-white/30 font-bold mb-1">Máximo</span>
                        <span className="text-white text-[11px] font-bold">{exp.capacity} <i className="fa-solid fa-users text-[9px] text-[#D9C8A1]"></i></span>
                    </div>
                </div>

                <div className="flex gap-3">
                    {botonReserva()}
                    <a href={`/experiencias/${exp.slug}`}
                        className={`${isAuth ? 'flex-1' : 'flex-grow py-4'} border border-[#D9C8A1]/30 rounded-2xl flex items-center justify-center text-[#D9C8A1] hover:bg-[#D9C8A1]/10 transition-all font-bold uppercase text-[10px] tracking-widest gap-2 font-parkzoo fuenteZoo`}>
                        {!isAuth && 'Ver Detalles'} <i className="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    );
}

export default function ExperienciasPage({ isAuth, userEmail }) {
    const [experiencias, setExperiencias] = useState([]);
    const [userTickets, setUserTickets] = useState([]);
    const [loading, setLoading] = useState(true);
    const [modalTickets, setModalTickets] = useState({ open: false, exp: null });
    const [modalEmail, setModalEmail] = useState({ open: false, exp: null });

        // 👇 AQUÍ
    console.log("EMAIL:", userEmail);
    console.log("TICKETS:", userTickets);

    useEffect(() => {
        fetch('/api/experiencias')
            .then(r => r.json())
            .then(data => { setExperiencias(data.data); setLoading(false); })
            .catch(() => setLoading(false));
    }, []);

    useEffect(() => {
        if (isAuth && userEmail) {
            fetch(`/api/tickets-by-email?email=${encodeURIComponent(userEmail)}`)
                .then(r => r.json())
                .then(data => setUserTickets(data.tickets ?? []))
                .catch(() => {});
        }
    }, [isAuth, userEmail]);

    const handleReservar = (exp) => {
        if (isAuth) {
            setModalTickets({ open: true, exp });
        } else {
            setModalEmail({ open: true, exp });
        }
    };

    if (loading) return (
        <div className="flex items-center justify-center min-h-[60vh]">
            <div className="text-[#D9C8A1] text-center">
                <i className="fa-solid fa-paw text-4xl animate-pulse mb-4 block"></i>
                <p className="text-sm uppercase tracking-widest">Cargando experiencias...</p>
            </div>
        </div>
    );

    const popular = experiencias[0] ?? null;
    const resto   = experiencias.slice(1);

    return (
        <>
            <section className="text-center mt-32 px-6 font-parkzoo fuenteZoo">
                <span className="text-[#D9C8A1] uppercase tracking-[4px] text-xs font-bold">Descubre lo inolvidable</span>
                <h1 className="text-4xl md:text-5xl font-parkzoo font-bold mt-2 text-white ">
                    Experiencias <span className="text-[#D9C8A1]">Park Zoo</span>
                </h1>
                <div className="w-16 h-[2px] bg-[#D9C8A1] mx-auto mt-4"></div>
                <p className="text-gray-400 max-w-xl mx-auto mt-6 italic">
                    Vive momentos únicos y conecta con la esencia de la vida silvestre.
                </p>
            </section>

            <main className="max-w-7xl mx-auto mt-16 px-6 mb-20">
                {popular && (
                    <ExperienciaCard
                        exp={popular}
                        isPopular={true}
                        isAuth={isAuth}
                        userTickets={userTickets}
                        onReservar={handleReservar}
                    />
                )}

                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                    {resto.map(exp => (
                        <ExperienciaCard
                            key={exp.id}
                            exp={exp}
                            isPopular={false}
                            isAuth={isAuth}
                            userTickets={userTickets}
                            onReservar={handleReservar}
                        />
                    ))}
                </div>
            </main>

            <TicketModal
                isOpen={modalTickets.open}
                onClose={() => setModalTickets({ open: false, exp: null })}
                expId={modalTickets.exp?.id}
                expName={modalTickets.exp?.name}
                tickets={userTickets}
                userEmail={userEmail}
                onSelectTicket={() => {}}
            />

            <EmailModal
                isOpen={modalEmail.open}
                onClose={() => setModalEmail({ open: false, exp: null })}
                expId={modalEmail.exp?.id}
                expName={modalEmail.exp?.name}
            />
        </>
    );
}