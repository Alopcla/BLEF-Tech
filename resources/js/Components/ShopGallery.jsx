import React, { useState, useEffect } from 'react';
import ShopCard from './ShopCard';

const CATEGORIAS = ['Todos', 'Peluches', 'Ropa', 'Accesorios', 'Libros', '3D'];
const ICONOS = {
    'Todos':      'bi-grid-fill',
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

    const contarProductosPorCategoria = (cat) => {
        if (cat === 'Todos') return productos.length;
        if (cat === '3D') return productos.filter(p => Boolean(p.spline_url?.trim())).length;
        return productos.filter(p => p.category?.toLowerCase() === cat.toLowerCase()).length;
    };

    return (
        <section className="!bg-transparent min-h-screen pb-24 w-full">
            
            {/* ── BOTÓN CARRITO FLOTANTE (siempre visible) ── */}
            <button
                onClick={() => setCarritoAbierto(true)}
                className="fixed bottom-8 right-8 z-50 bg-[#386641] hover:bg-[#2d5229] text-white rounded-full w-16 h-16 flex items-center justify-center shadow-[0_10px_40px_rgba(0,0,0,0.5)] transition-all duration-200"
            >
                <i className="bi bi-cart3 text-2xl" />
                {totalItems > 0 && (
                    <span className="absolute -top-2 -right-2 bg-[#D9C8A1] text-[#0f1f0f] text-xs font-extrabold rounded-full w-6 h-6 flex items-center justify-center">
                        {totalItems}
                    </span>
                )}
            </button>

            {/* ── PANEL CARRITO (Se mantiene igual, ajustados algunos tonos de verde) ── */}
            {carritoAbierto && (
                <div className="fixed inset-0 z-50 flex justify-end">
                    <div className="absolute inset-0 bg-black/60 backdrop-blur-sm" onClick={() => setCarritoAbierto(false)} />
                    <div className="relative w-full max-w-md bg-[#141A14] border-l border-white/5 h-full flex flex-col shadow-2xl">
                        
                        {/* Header */}
                        <div className="flex items-center justify-between px-6 py-5 border-b border-white/5">
                            <h2 className="fuenteZoo text-3xl text-white tracking-wide">
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
                                        className="mt-2 px-6 py-2.5 rounded-xl bg-[#386641] text-white text-sm font-bold hover:bg-[#2d5229] transition-colors"
                                    >
                                        Ver productos
                                    </button>
                                </div>
                            ) : carrito.map(item => (
                                <div key={item.id} className="flex gap-4 bg-[#1A221A] rounded-2xl p-4 border border-white/5">
                                    {item.image
                                        ? <img src={item.image} alt={item.name} className="w-16 h-16 object-contain rounded-xl bg-[#141A14] flex-shrink-0" />
                                        : <div className="w-16 h-16 rounded-xl bg-[#141A14] flex items-center justify-center flex-shrink-0">
                                            <i className="bi bi-box text-neutral-600 text-2xl" />
                                          </div>
                                    }
                                    <div className="flex-1 min-w-0">
                                        <p className="text-white text-sm font-semibold truncate">{item.name}</p>
                                        <p className="text-[#D9C8A1] text-sm font-bold mt-0.5">{parseFloat(item.price).toFixed(2)} € / ud.</p>
                                        <div className="flex items-center gap-2 mt-2">
                                            <button
                                                onClick={() => cambiarCantidad(item.id, -1)}
                                                className="w-7 h-7 rounded-lg bg-[#141A14] text-white flex items-center justify-center hover:bg-neutral-700 transition-colors"
                                            >
                                                <i className="bi bi-dash" />
                                            </button>
                                            <span className="text-white text-sm font-bold w-6 text-center">{item.quantity}</span>
                                            <button
                                                onClick={() => cambiarCantidad(item.id, +1)}
                                                disabled={item.quantity >= item.stock}
                                                className="w-7 h-7 rounded-lg bg-[#141A14] text-white flex items-center justify-center hover:bg-neutral-700 transition-colors disabled:opacity-40"
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
                            <div className="px-6 py-5 border-t border-white/5 flex flex-col gap-3">
                                {/* Email invitado */}
                                {!userEmail && (
                                    <div>
                                        <p className="text-[#D9C8A1] text-xs font-bold uppercase tracking-widest mb-2">
                                            <i className="bi bi-envelope mr-1" /> Email para el recibo
                                        </p>
                                        <input
                                            type="email"
                                            placeholder="tu@email.com"
                                            value={emailInvitado}
                                            onChange={e => { setEmailInvitado(e.target.value); setEmailError(''); }}
                                            className="w-full bg-[#1A221A] border border-white/5 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:border-[#D9C8A1] transition-colors placeholder-neutral-600 shadow-inner"
                                        />
                                        {emailError && (
                                            <p className="text-red-400 text-xs mt-1">{emailError}</p>
                                        )}
                                    </div>
                                )}

                                {/* Email logueado */}
                                {userEmail && (
                                    <div className="flex items-center gap-2 bg-[#1A221A] rounded-xl px-4 py-2.5 border border-white/5">
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
                                    className="w-full py-4 rounded-xl bg-[#386641] hover:bg-[#2d5229] text-white font-bold text-sm uppercase tracking-widest transition-colors disabled:opacity-60 flex items-center justify-center gap-2"
                                >
                                    {pagando
                                        ? <><i className="bi bi-arrow-repeat animate-spin" /> Procesando...</>
                                        : <><i className="bi bi-lock text-xs" /> Pagar {totalCarrito.toFixed(2)} € </>
                                    }
                                </button>

                                <button
                                    onClick={() => setCarrito([])}
                                    className="w-full py-2 text-xs text-neutral-600 hover:text-red-400 transition-colors uppercase tracking-widest mt-1"
                                >
                                    <i className="bi bi-trash3 mr-1" /> Vaciar carrito
                                </button>
                            </div>
                        )}
                    </div>
                </div>
            )}

            {/* ── TÍTULO (Estilo unificado con AnimalGallery) ── */}
            <section className="text-center pt-24 pb-12 px-6">
                <span className="text-[#D9C8A1] uppercase tracking-[4px] text-xs font-bold">
                    <i className="bi bi-bag-heart-fill mr-2"></i> BLR Zoo · Tienda Oficial
                </span>
                <h1 className="text-4xl md:text-5xl font-parkzoo mt-2 text-white fuenteZoo">
                    Nuestra <span className="text-[#D9C8A1]">Tienda</span>
                </h1>
                <div className="w-16 h-[2px] bg-[#D9C8A1] mx-auto mt-4"></div>
                <p className="text-gray-400 max-w-xl mx-auto mt-6 italic">
                    Productos exclusivos inspirados en nuestros animales. Cada compra contribuye a la conservación del zoo.
                </p>
            </section>

            {/* ── CONTENEDOR PRINCIPAL ── */}
            <div className="container mx-auto px-4 max-w-7xl flex flex-col lg:flex-row gap-8 items-start">

                {/* SIDEBAR (Misma estructura y clases que AnimalGallery) */}
                <aside className="w-full lg:w-80 shrink-0 bg-[#141A14]/90 backdrop-blur-md p-6 rounded-[2rem] border border-white/5 shadow-2xl z-30 static lg:sticky lg:top-24">
                    
                    {/* Búsqueda */}
                    <div className="mb-8">
                        <h3 className="text-[#D9C8A1] uppercase tracking-widest text-[11px] font-black mb-3">
                            Buscar
                        </h3>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-neutral-500">
                                <i className="bi bi-search"></i>
                            </div>
                            <input
                                type="text"
                                placeholder="Nombre del producto..."
                                value={busqueda}
                                onChange={e => setBusqueda(e.target.value)}
                                className="w-full bg-[#1A221A] border border-white/5 text-white text-sm rounded-xl focus:ring-[#D9C8A1] focus:border-[#D9C8A1] block pl-10 p-3 transition-colors placeholder-neutral-600 shadow-inner"
                            />
                        </div>
                    </div>

                    {/* Categorías */}
                    <div className="mb-8">
                        <h3 className="text-[#D9C8A1] uppercase tracking-widest text-[11px] font-black mb-3">
                            Categorías
                        </h3>
                        <div className="flex flex-col gap-1">
                            {CATEGORIAS.map(cat => (
                                <button
                                    key={cat}
                                    onClick={() => setFiltroCategoria(cat)}
                                    className={`flex items-center justify-between px-4 py-3 rounded-xl text-sm font-medium transition-all ${
                                        filtroCategoria === cat 
                                            ? "bg-[#386641] text-white shadow-lg" 
                                            : "text-neutral-400 hover:bg-white/5 hover:text-white"
                                    }`}
                                >
                                    <div className="flex items-center gap-3">
                                        <i className={`bi ${ICONOS[cat]}`}></i>
                                        <span>{cat}</span>
                                    </div>
                                    <span className="bg-[#1A221A] text-neutral-500 text-[10px] px-2.5 py-1 rounded-full font-bold shadow-inner">
                                        {contarProductosPorCategoria(cat)}
                                    </span>
                                </button>
                            ))}
                        </div>
                    </div>

                    {/* Ordenar */}
                    <div>
                        <h3 className="text-[#D9C8A1] uppercase tracking-widest text-[11px] font-black mb-3">
                            Ordenar por
                        </h3>
                        <select
                            value={orden}
                            onChange={e => setOrden(e.target.value)}
                            className="w-full bg-[#1A221A] border border-white/5 text-white text-sm rounded-xl px-4 py-3 focus:outline-none focus:ring-[#D9C8A1] focus:border-[#D9C8A1] transition-colors cursor-pointer shadow-inner"
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
                            className="w-full mt-6 py-2.5 rounded-xl border border-red-800/50 text-red-400 text-xs font-bold uppercase tracking-widest hover:bg-red-900/20 transition-colors"
                        >
                            <i className="bi bi-x-circle mr-2" />Limpiar filtros
                        </button>
                    )}
                </aside>

                {/* GRID DE PRODUCTOS */}
                <main className="w-full flex-1 min-w-0">
                    <div className="flex items-center justify-between mb-6 px-2">
                        <p className="text-neutral-500 text-xs uppercase tracking-widest font-bold">
                            {cargando ? 'Cargando catálogo...' : `${productosFiltrados.length} resultado${productosFiltrados.length !== 1 ? 's' : ''}`}
                        </p>
                    </div>

                    {cargando ? (
                        <p className="text-center text-2xl text-white font-bold animate-pulse mt-12">
                            Cargando productos...
                        </p>
                    ) : productosFiltrados.length === 0 ? (
                        <div className="text-center py-20 bg-[#141A14]/50 rounded-[2rem] border border-white/5">
                            <i className="bi bi-bag-x text-6xl text-neutral-500 mb-4 block"></i>
                            <h3 className="text-2xl text-white font-bold">
                                No hay productos en esta categoría
                            </h3>
                            <p className="text-neutral-400 mt-2">
                                Prueba a buscar con otras palabras o quita los filtros.
                            </p>
                            <button
                                onClick={() => {
                                    setBusqueda('');
                                    setFiltroCategoria('Todos');
                                }}
                                className="mt-6 text-[#D9C8A1] underline hover:text-white transition"
                            >
                                Limpiar búsqueda
                            </button>
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
        </section>
    );
};

export default ShopGallery;