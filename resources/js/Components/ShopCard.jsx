import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const COLOR_CATEGORIA = {
    peluche:   { bg: 'bg-purple-900/30', text: 'text-purple-300', dot: '#a78bfa' },
    ropa:      { bg: 'bg-blue-900/30',   text: 'text-blue-300',   dot: '#93c5fd' },
    accesorio: { bg: 'bg-amber-900/30',  text: 'text-amber-300',  dot: '#fcd34d' },
    libro:     { bg: 'bg-orange-900/30', text: 'text-orange-300', dot: '#fdba74' },
    default:   { bg: 'bg-neutral-800',   text: 'text-neutral-400', dot: '#6b7280' },
};

const getColor = (categoria) => {
    if (!categoria) return COLOR_CATEGORIA.default;
    const c = categoria.toLowerCase();
    for (const key of Object.keys(COLOR_CATEGORIA)) {
        if (c.includes(key)) return COLOR_CATEGORIA[key];
    }
    return COLOR_CATEGORIA.default;
};

const ShopCard = ({ producto }) => {
    const [añadido, setAñadido] = useState(false);
    const navigate = useNavigate();
    const color   = getColor(producto.category);
    const agotado = producto.stock <= 0;
    const poco    = producto.stock > 0 && producto.stock <= 10;
    const fallback = `https://ui-avatars.com/api/?name=${encodeURIComponent(producto.name)}&size=500&background=1a1a1a&color=E0D7B6&font-size=0.15&bold=true`;

    const handleCarrito = (e) => {
        e.stopPropagation();
        if (agotado) return;
        setAñadido(true);
        setTimeout(() => setAñadido(false), 2000);
    };

    return (
        <div
            onClick={() => navigate(`/tienda/producto/${producto.id}`)}
            className={`
                bg-[#141914] text-white rounded-[28px] overflow-hidden flex flex-col
                border transition-all duration-300 group cursor-pointer
                ${agotado
                    ? 'border-neutral-800 opacity-70'
                    : 'border-neutral-800 hover:border-[#3A6B35]/60 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(58,107,53,0.15)]'
                }
            `}
        >
            {/* Imagen */}
            <div className="relative w-full h-65 bg-neutral-900 overflow-hidden">
                <img
                    src={producto.image || fallback}
                    alt={producto.name}
                    onError={e => { e.target.onerror = null; e.target.src = fallback; }}
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
                {agotado && (
                    <div className="absolute inset-0 bg-black/60 flex items-center justify-center">
                        <span className="text-white font-bold text-sm uppercase tracking-[3px]">Agotado</span>
                    </div>
                )}
            </div>

            {/* Cuerpo */}
            <div className="p-5 flex flex-col flex-grow gap-3">

                {/* Categoría + stock */}
                <div className="flex items-center justify-between">
                    <span className={`inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-lg ${color.bg} ${color.text}`}>
                        <span className="w-1.5 h-1.5 rounded-full inline-block" style={{ background: color.dot }} />
                        {producto.category}
                    </span>
                    <span className={`text-[10px] font-semibold uppercase tracking-wider ${
                        agotado ? 'text-red-500' : poco ? 'text-yellow-400' : 'text-green-400'
                    }`}>
                        {agotado ? '✕ Sin stock' : poco ? `⚡ Solo ${producto.stock}` : '✓ Disponible'}
                    </span>
                </div>

                {/* Nombre y descripción */}
                <div className="flex-grow">
                    <h3 className="text-lg font-extrabold leading-tight mb-1">{producto.name}</h3>
                    <p className="text-neutral-500 text-xs line-clamp-2 leading-relaxed">
                        {producto.description || 'Producto exclusivo de BLR Zoo.'}
                    </p>
                </div>

                {/* Precio + botón */}
                <div className="flex items-center justify-between pt-3 border-t border-neutral-800/80 mt-auto">
                    <div>
                        <p className="text-[10px] text-neutral-600 uppercase tracking-widest">Precio</p>
                        <p className="text-2xl font-extrabold text-[#E0D7B6]">
                            {parseFloat(producto.price).toFixed(2)}<span className="text-base font-medium"> €</span>
                        </p>
                    </div>
                    <button
                        onClick={handleCarrito}
                        disabled={agotado}
                        className={`flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 ${
                            agotado
                                ? 'bg-neutral-800 text-neutral-600 cursor-not-allowed'
                                : añadido
                                    ? 'bg-green-700 text-white scale-95'
                                    : 'bg-[#3A6B35] text-[#E0D7B6] hover:bg-[#E0D7B6] hover:text-[#1a3a1a] hover:scale-105'
                        }`}
                    >
                        <i className={`bi ${añadido ? 'bi-check-lg' : agotado ? 'bi-bag-x' : 'bi-bag-plus'}`} />
                        {añadido ? '¡Listo!' : agotado ? 'No disp.' : 'Añadir'}
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ShopCard;