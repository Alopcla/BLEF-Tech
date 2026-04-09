import React, { useState, useEffect } from 'react';
import ShopCard from './ShopCard';

const CATEGORIAS = ['Todos', 'Peluches', 'Ropa', 'Accesorios', 'Libros', '3D'];
const ICONOS = {
    'Todos':      'bi-grid-3x3-gap',
    'Peluches':   'bi-heart',
    'Ropa':       'bi-bag',
    'Accesorios': 'bi-stars',
    'Libros':     'bi-book',
    '3D':         'bi-badge-3d',
};

const ShopGallery = ({ userEmail = '' }) => {
    const [productos, setProductos]             = useState([]);
    const [cargando, setCargando]               = useState(true);
    const [busqueda, setBusqueda]               = useState('');
    const [filtroCategoria, setFiltroCategoria] = useState('Todos');
    const [orden, setOrden]                     = useState('default');
    const [carrito, setCarrito]                 = useState([]);
    const [carritoAbierto, setCarritoAbierto]   = useState(false);
    const [pagando, setPagando]                 = useState(false);
    const [emailInvitado, setEmailInvitado]     = useState('');
    const [emailError, setEmailError]           = useState('');

    useEffect(() => { document.body.classList.remove('producto-view'); }, []);

    useEffect(() => {
        fetch('/api/products')
            .then(r => r.json())
            .then(datos => { setProductos(datos.data); setCargando(false); })
            .catch(() => setCargando(false));
    }, []);

    const agregarAlCarrito = (producto) => {
        setCarrito(prev => {
            const existe = prev.find(i => i.id === producto.id);
            if (existe) return prev.map(i => i.id === producto.id ? { ...i, quantity: i.quantity + 1 } : i);
            return [...prev, { ...producto, quantity: 1 }];
        });
        setCarritoAbierto(true);
    };

    const cambiarCantidad = (id, delta) => {
        setCarrito(prev => prev.map(i => i.id === id ? { ...i, quantity: Math.max(1, i.quantity + delta) } : i));
    };

    const eliminarDelCarrito = (id) => setCarrito(prev => prev.filter(i => i.id !== id));

    const totalCarrito = carrito.reduce((s, i) => s + i.price * i.quantity, 0);
    const totalItems   = carrito.reduce((s, i) => s + i.quantity, 0);

    const irAPagar = async () => {
        if (carrito.length === 0) return;

        // Validar email si es invitado
        if (!userEmail) {
            if (!emailInvitado || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInvitado)) {
                setEmailError('Introduce un email válido para recibir el recibo.');
                return;
            }
        }
        setEmailError('');
        setPagando(true);

        try {
            const res = await fetch('/api/shop/checkout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                },
                body: JSON.stringify({
                    items: carrito.map(i => ({ id: i.id, name: i.name, quantity: i.quantity })),
                    email: userEmail || emailInvitado,
                }),
            });
            const data = await res.json();
            if (data.url) {
                window.location.href = data.url;
            } else {
                alert(data.error ?? 'Error al procesar el pago.');
                setPagando(false);
            }
        } catch {
            alert('Error de conexión.');
            setPagando(false);
        }
    };

    const productosFiltrados = productos
        .filter(p => {
            const coincideTexto     = p.name.toLowerCase().includes(busqueda.toLowerCase());
            const coincideCategoria =
                filtroCategoria === 'Todos' ||
                (filtroCategoria === '3D' && Boolean(p.spline_url?.trim())) ||
                p.category?.toLowerCase() === filtroCategoria.toLowerCase();
            return coincideTexto && coincideCategoria;
        })
        .sort((a, b) => {
            if (orden === 'precio-asc')  return a.price - b.price;
            if (orden === 'precio-desc') return b.price - a.price;
            if (orden === 'nombre')      return a.name.localeCompare(b.name);
            return 0;
        });

    return (
        <div className="!bg-transparent min-h-screen w-full">
            <style>{`
                @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&display=swap');
                .fuente-zoo { font-family: 'Fredoka', sans-serif; }
            `}</style>

            {/* ── BOTÓN CARRITO FLOTANTE (siempre visible) ── */}
            <button
                onClick={() => setCarritoAbierto(true)}
                className="fixed bottom-8 right-8 z-50 bg-[#3A6B35] hover:bg-[#2d5229] text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl transition-all duration-200"
            >
                <i className="bi bi-cart3 text-2xl" />
                {totalItems > 0 && (
                    <span className="absolute -top-2 -right-2 bg-[#E0D7B6] text-[#0f1f0f] text-xs font-extrabold rounded-full w-6 h-6 flex items-center justify-center">
                        {totalItems}
                    </span>
                )}
            </button>

            {/* ── PANEL CARRITO ── */}
            {carritoAbierto && (
                <div className="fixed inset-0 z-50 flex justify-end">
                    <div className="absolute inset-0 bg-black/60 backdrop-blur-sm" onClick={() => setCarritoAbierto(false)} />
                    <div className="relative w-full max-w-md bg-[#111811] border-l border-neutral-800 h-full flex flex-col shadow-2xl">

                        {/* Header */}
                        <div className="flex items-center justify-between px-6 py-5 border-b border-neutral-800">
                            <h2 className="fuente-zoo text-2xl text-white">
                                Tu carrito

                            </h2>
                            <button onClick={() => setCarritoAbierto(false)} className="text-neutral-400 hover:text-white transition-colors">
                                <i className="bi bi-x-lg text-xl" />
                            </button>
                        </div>

                        {/* Items */}
                        <div className="flex-1 overflow-y-auto px-6 py-4 flex flex-col gap-4">
                            {carrito.length === 0 ? (
                                <div className="flex flex-col items-center justify-center h-full text-center gap-4">
                                    <i className="bi bi-cart-x text-6xl text-neutral-700" />
                                    <div>
                                        <p className="text-white font-bold">Tu carrito está vacío</p>
                                        <p className="text-neutral-500 text-sm mt-1">Añade productos para empezar</p>
                                    </div>
                                    <button
                                        onClick={() => setCarritoAbierto(false)}
                                        className="mt-2 px-6 py-2.5 rounded-xl bg-[#3A6B35] text-white text-sm font-bold hover:bg-[#2d5229] transition-colors"
                                    >
                                        Ver productos
                                    </button>
                                </div>
                            ) : carrito.map(item => (
                                <div key={item.id} className="flex gap-4 bg-[#171717] rounded-2xl p-4 border border-neutral-800">
                                    {item.image
                                        ? <img src={item.image} alt={item.name} className="w-16 h-16 object-contain rounded-xl bg-neutral-900 flex-shrink-0" />
                                        : <div className="w-16 h-16 rounded-xl bg-neutral-800 flex items-center justify-center flex-shrink-0">
                                            <i className="bi bi-box text-neutral-600 text-2xl" />
                                          </div>
                                    }
                                    <div className="flex-1 min-w-0">
                                        <p className="text-white text-sm font-semibold truncate">{item.name}</p>
                                        <p className="text-[#E0D7B6] text-sm font-bold mt-0.5">{parseFloat(item.price).toFixed(2)} € / ud.</p>
                                        <div className="flex items-center gap-2 mt-2">
                                            <button
                                                onClick={() => cambiarCantidad(item.id, -1)}
                                                className="w-7 h-7 rounded-lg bg-neutral-800 text-white flex items-center justify-center hover:bg-neutral-700 transition-colors"
                                            >
                                                <i className="bi bi-dash" />
                                            </button>
                                            <span className="text-white text-sm font-bold w-6 text-center">{item.quantity}</span>
                                            <button
                                                onClick={() => cambiarCantidad(item.id, +1)}
                                                disabled={item.quantity >= item.stock}
                                                className="w-7 h-7 rounded-lg bg-neutral-800 text-white flex items-center justify-center hover:bg-neutral-700 transition-colors disabled:opacity-40"
                                            >
                                                <i className="bi bi-plus" />
                                            </button>
                                        </div>
                                    </div>
                                    <div className="flex flex-col items-end justify-between flex-shrink-0">
                                        <button onClick={() => eliminarDelCarrito(item.id)} className="text-neutral-600 hover:text-red-400 transition-colors">
                                            <i className="bi bi-trash3 text-sm" />
                                        </button>
                                        <p className="text-white text-sm font-bold">{(item.price * item.quantity).toFixed(2)} €</p>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Footer */}
                        {carrito.length > 0 && (
                            <div className="px-6 py-5 border-t border-neutral-800 flex flex-col gap-3">

                                {/* Email invitado */}
                                {!userEmail && (
                                    <div>
                                        <p className="text-[#E0D7B6] text-xs font-bold uppercase tracking-widest mb-2">
                                            <i className="bi bi-envelope mr-1" /> Email para el recibo
                                        </p>
                                        <input
                                            type="email"
                                            placeholder="tu@email.com"
                                            value={emailInvitado}
                                            onChange={e => { setEmailInvitado(e.target.value); setEmailError(''); }}
                                            className="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-[#E0D7B6] transition-colors placeholder-neutral-600"
                                        />
                                        {emailError && (
                                            <p className="text-red-400 text-xs mt-1">{emailError}</p>
                                        )}
                                    </div>
                                )}

                                {/* Email logueado */}
                                {userEmail && (
                                    <div className="flex items-center gap-2 bg-neutral-900 rounded-xl px-4 py-2.5 border border-neutral-800">
                                        <i className="bi bi-person-check text-green-400 text-sm" />
                                        <p className="text-neutral-400 text-xs truncate">Recibo para <span className="text-white">{userEmail}</span></p>
                                    </div>
                                )}

                                {/* Total */}
                                <div className="flex items-center justify-between py-2">
                                    <span className="text-neutral-400 text-sm">Total</span>
                                    <span className="text-white text-2xl font-extrabold">{totalCarrito.toFixed(2)} €</span>
                                </div>

                                <button
                                    onClick={irAPagar}
                                    disabled={pagando}
                                    className="w-full py-4 rounded-2xl bg-[#3A6B35] hover:bg-[#2d5229] text-white font-bold text-sm uppercase tracking-widest transition-colors disabled:opacity-60 flex items-center justify-center gap-2"
                                >
                                    {pagando
                                        ? <><i className="bi bi-arrow-repeat animate-spin" /> Redirigiendo...</>
                                        : <><i className="bi bi-lock text-xs" /> Pagar {totalCarrito.toFixed(2)} € </>
                                    }
                                </button>

                                <button
                                    onClick={() => setCarrito([])}
                                    className="w-full py-2 text-xs text-neutral-600 hover:text-red-400 transition-colors uppercase tracking-widest"
                                >
                                    <i className="bi bi-trash3 mr-1" /> Vaciar carrito
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            )}

            {/* ── HERO BANNER ── */}
            <div className="w-full px-4 pt-20 pb-10 md:pt-28">
                <div className="max-w-7xl mx-auto relative overflow-hidden rounded-[40px] bg-[#0f1f0f] border border-[#2a4a2a] shadow-[0_30px_80px_rgba(0,0,0,0.8)]">
                    <div className="absolute inset-0 opacity-10" style={{
                        backgroundImage: 'radial-gradient(circle at 20% 50%, #3A6B35 0%, transparent 50%), radial-gradient(circle at 80% 20%, #D9C8A1 0%, transparent 40%)'
                    }} />
                    <div className="relative z-10 flex flex-col md:flex-row items-center justify-between px-10 py-10 gap-6">
                        <div>
                            <p className="text-[#E0D7B6]/60 text-xs font-bold uppercase tracking-[4px] mb-2">BLR Zoo · Tienda Oficial</p>
                            <h1 className="fuente-zoo text-5xl md:text-7xl text-white leading-tight" style={{ textShadow: '0 4px 20px rgba(0,0,0,0.8)' }}>
                                Llévate el Zoo<br /><span className="text-[#E0D7B6]">a casa</span>
                            </h1>
                            <p className="text-neutral-400 mt-3 text-sm max-w-md">
                                Productos exclusivos inspirados en nuestros animales. Cada compra contribuye a la conservación del zoo.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {/* ── CUERPO ── */}
            <div className="max-w-7xl mx-auto px-4 pb-32 flex flex-col lg:flex-row gap-8">

                {/* SIDEBAR */}
                <aside className="w-full lg:w-64 flex-shrink-0">
                    <div className="sticky top-6 bg-[#111811]/90 backdrop-blur-md rounded-[28px] border border-neutral-800 p-6 flex flex-col gap-6">
                        <div>
                            <p className="text-[#E0D7B6] text-xs font-bold uppercase tracking-widest mb-3">Buscar</p>
                            <div className="relative">
                                <i className="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-neutral-500 text-sm" />
                                <input
                                    type="text"
                                    placeholder="Nombre del producto..."
                                    value={busqueda}
                                    onChange={e => setBusqueda(e.target.value)}
                                    className="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:outline-none focus:border-[#E0D7B6] transition-colors placeholder-neutral-600"
                                />
                            </div>
                        </div>

                        <div>
                            <p className="text-[#E0D7B6] text-xs font-bold uppercase tracking-widest mb-3">Categoría</p>
                            <div className="flex flex-col gap-1">
                                {CATEGORIAS.map(cat => (
                                    <button
                                        key={cat}
                                        onClick={() => setFiltroCategoria(cat)}
                                        className={`flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-left ${
                                            filtroCategoria === cat ? 'bg-[#3A6B35] text-white' : 'text-neutral-400 hover:bg-neutral-800 hover:text-white'
                                        }`}
                                    >
                                        <i className={`bi ${ICONOS[cat]} text-base`} />
                                        {cat}
                                        {cat !== 'Todos' && (
                                            <span className="ml-auto text-xs bg-neutral-800 text-neutral-500 px-2 py-0.5 rounded-full">
                                                {cat === '3D'
                                                    ? productos.filter(p => Boolean(p.spline_url?.trim())).length
                                                    : productos.filter(p => p.category?.toLowerCase() === cat.toLowerCase()).length
                                                }
                                            </span>
                                        )}
                                    </button>
                                ))}
                            </div>
                        </div>

                        <div>
                            <p className="text-[#E0D7B6] text-xs font-bold uppercase tracking-widest mb-3">Ordenar por</p>
                            <select
                                value={orden}
                                onChange={e => setOrden(e.target.value)}
                                className="w-full bg-neutral-900 border border-neutral-700 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-[#E0D7B6] transition-colors cursor-pointer"
                            >
                                <option value="default">Relevancia</option>
                                <option value="precio-asc">Precio: menor a mayor</option>
                                <option value="precio-desc">Precio: mayor a menor</option>
                                <option value="nombre">Nombre A–Z</option>
                            </select>
                        </div>

                        {(busqueda || filtroCategoria !== 'Todos') && (
                            <button
                                onClick={() => { setBusqueda(''); setFiltroCategoria('Todos'); }}
                                className="w-full py-2.5 rounded-xl border border-red-800/50 text-red-400 text-xs font-bold uppercase tracking-widest hover:bg-red-900/20 transition-colors"
                            >
                                <i className="bi bi-x-circle mr-2" />Limpiar filtros
                            </button>
                        )}
                    </div>
                </aside>

                {/* GRID */}
                <main className="flex-1">
                    <div className="flex items-center justify-between mb-6">
                        <p className="text-neutral-500 text-xs uppercase tracking-widest">
                            {cargando ? 'Cargando...' : `${productosFiltrados.length} resultado${productosFiltrados.length !== 1 ? 's' : ''}`}
                        </p>
                    </div>

                    {cargando ? (
                        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            {[...Array(6)].map((_, i) => (
                                <div key={i} className="bg-[#171717] rounded-[28px] h-80 animate-pulse border border-neutral-800" />
                            ))}
                        </div>
                    ) : productosFiltrados.length === 0 ? (
                        <div className="text-center py-32">
                            <i className="bi bi-bag-x text-6xl text-neutral-700 mb-4 block" />
                            <h3 className="text-xl text-white font-bold">Sin resultados</h3>
                            <p className="text-neutral-500 mt-2 text-sm">Prueba con otras palabras o cambia la categoría.</p>
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                            {productosFiltrados.map(p => (
                                <ShopCard key={p.id} producto={p} onAgregar={agregarAlCarrito} />
                            ))}
                        </div>
                    )}
                </main>
            </div>
        </div>
    );
};

export default ShopGallery;