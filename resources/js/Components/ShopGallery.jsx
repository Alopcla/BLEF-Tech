import React, { useState, useEffect } from 'react';
import ShopCard from './ShopCard';

const CATEGORIAS = ['Todos', 'Peluches', 'Ropa', 'Accesorios', 'Libros'];

const ICONOS = {
    'Todos':      'bi-grid-3x3-gap',
    'Peluches':   'bi-heart',
    'Ropa':       'bi-bag',
    'Accesorios': 'bi-stars',
    'Libros':     'bi-book',
};

const ShopGallery = () => {
    const [productos, setProductos]           = useState([]);
    const [cargando, setCargando]             = useState(true);
    const [busqueda, setBusqueda]             = useState('');
    const [filtroCategoria, setFiltroCategoria] = useState('Todos');
    const [orden, setOrden]                   = useState('default');

    // Restaurar fondo de galería al montar
    useEffect(() => {
        document.body.classList.remove('producto-view');
    }, []);

    useEffect(() => {
        fetch('/api/products')
            .then(r => r.json())
            .then(datos => { setProductos(datos.data); setCargando(false); })
            .catch(() => setCargando(false));
    }, []);

    const productosFiltrados = productos
        .filter(p => {
            const coincideTexto     = p.name.toLowerCase().includes(busqueda.toLowerCase());
            const coincideCategoria = filtroCategoria === 'Todos' ||
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

            {/* ── HERO BANNER ── */}
            <div className="w-full px-4 pt-20 pb-10 md:pt-28">
                <div className="max-w-7xl mx-auto relative overflow-hidden rounded-[40px] bg-[#0f1f0f] border border-[#2a4a2a] shadow-[0_30px_80px_rgba(0,0,0,0.8)]">

                    <div className="absolute inset-0 opacity-10" style={{
                        backgroundImage: 'radial-gradient(circle at 20% 50%, #3A6B35 0%, transparent 50%), radial-gradient(circle at 80% 20%, #D9C8A1 0%, transparent 40%)'
                    }} />

                    <div className="relative z-10 flex flex-col md:flex-row items-center justify-between px-10 py-10 gap-6">
                        <div>
                            <p className="text-[#E0D7B6]/60 text-xs font-bold uppercase tracking-[4px] mb-2">
                                BLR Zoo · Tienda Oficial
                            </p>
                            <h1 className="fuente-zoo text-5xl md:text-7xl text-white leading-tight"
                                style={{ textShadow: '0 4px 20px rgba(0,0,0,0.8)' }}>
                                Llévate el Zoo<br />
                                <span className="text-[#E0D7B6]">a casa</span>
                            </h1>
                            <p className="text-neutral-400 mt-3 text-sm max-w-md">
                                Productos exclusivos inspirados en nuestros animales. Cada compra contribuye a la conservación del zoo.
                            </p>
                        </div>
                        <div className="flex flex-col items-end gap-3">
                            <div className="bg-[#3A6B35]/20 border border-[#3A6B35]/40 rounded-2xl px-6 py-4 text-center">
                                <p className="text-[#E0D7B6] text-3xl font-extrabold">{productos.length}</p>
                                <p className="text-neutral-400 text-xs uppercase tracking-widest">Productos</p>
                            </div>
                            <div className="bg-[#171717]/60 border border-neutral-800 rounded-2xl px-6 py-4 text-center">
                                <p className="text-white text-3xl font-extrabold">{CATEGORIAS.length - 1}</p>
                                <p className="text-neutral-400 text-xs uppercase tracking-widest">Categorías</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* ── CUERPO: sidebar + grid ── */}
            <div className="max-w-7xl mx-auto px-4 pb-32 flex flex-col lg:flex-row gap-8">

                {/* SIDEBAR FILTROS */}
                <aside className="w-full lg:w-64 flex-shrink-0">
                    <div className="sticky top-6 bg-[#111811]/90 backdrop-blur-md rounded-[28px] border border-neutral-800 p-6 flex flex-col gap-6">

                        {/* Buscador */}
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

                        {/* Categorías */}
                        <div>
                            <p className="text-[#E0D7B6] text-xs font-bold uppercase tracking-widest mb-3">Categoría</p>
                            <div className="flex flex-col gap-1">
                                {CATEGORIAS.map(cat => (
                                    <button
                                        key={cat}
                                        onClick={() => setFiltroCategoria(cat)}
                                        className={`flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 text-left ${
                                            filtroCategoria === cat
                                                ? 'bg-[#3A6B35] text-white'
                                                : 'text-neutral-400 hover:bg-neutral-800 hover:text-white'
                                        }`}
                                    >
                                        <i className={`bi ${ICONOS[cat]} text-base`} />
                                        {cat}
                                        {cat !== 'Todos' && (
                                            <span className="ml-auto text-xs bg-neutral-800 text-neutral-500 px-2 py-0.5 rounded-full">
                                                {productos.filter(p => p.category?.toLowerCase() === cat.toLowerCase()).length}
                                            </span>
                                        )}
                                    </button>
                                ))}
                            </div>
                        </div>

                        {/* Ordenar */}
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

                        {/* Limpiar filtros */}
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

                {/* GRID PRODUCTOS */}
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
                                <ShopCard key={p.id} producto={p} />
                            ))}
                        </div>
                    )}
                </main>
            </div>
        </div>
    );
};

export default ShopGallery;