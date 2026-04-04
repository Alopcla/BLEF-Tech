import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';

const obtenerColorCategoria = (categoria) => {
    if (!categoria) return { bg: 'bg-neutral-800', text: 'text-neutral-400', dot: '#6b7280' };
    const c = categoria.toLowerCase();
    if (c.includes('peluche'))   return { bg: 'bg-purple-900/30', text: 'text-purple-300', dot: '#a78bfa' };
    if (c.includes('ropa'))      return { bg: 'bg-blue-900/30',   text: 'text-blue-300',   dot: '#93c5fd' };
    if (c.includes('accesorio')) return { bg: 'bg-amber-900/30',  text: 'text-amber-300',  dot: '#fcd34d' };
    if (c.includes('libro'))     return { bg: 'bg-orange-900/30', text: 'text-orange-300', dot: '#fdba74' };
    return { bg: 'bg-neutral-800', text: 'text-neutral-400', dot: '#6b7280' };
};

const ShopCard = ({ producto }) => {
    const [añadido, setAñadido] = useState(false);
    const color = obtenerColorCategoria(producto.category);
    const agotado = producto.stock <= 0;
    const pocoStock = producto.stock > 0 && producto.stock <= 10;
    const imagenFallback = `https://ui-avatars.com/api/?name=${encodeURIComponent(producto.name)}&size=500&background=1a1a1a&color=E0D7B6&font-size=0.15&bold=true`;
    const navigate = useNavigate();

    const handleCarrito = () => {
        if (agotado) return;
        setAñadido(true);
        setTimeout(() => setAñadido(false), 2000);
    };

    return (
        <div className={`bg-[#141914] text-white rounded-[28px] overflow-hidden flex flex-col border transition-all duration-300 group ${
            agotado ? 'border-neutral-800 opacity-70' : 'border-neutral-800 hover:border-[#3A6B35]/60 hover:-translate-y-1 hover:shadow-[0_20px_50px_rgba(58,107,53,0.15)]'
        }`}>

            {/* Imagen */}
            <div
            onClick={() => navigate(`/tienda/producto/${producto.id}`)}
            className="relative w-full h-48 bg-neutral-900 overflow-hidden">
                <img
                    src={producto.image || imagenFallback}
                    alt={producto.name}
                    onError={e => { e.target.onerror = null; e.target.src = imagenFallback; }}
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
                        <span className="w-1.5 h-1.5 rounded-full inline-block" style={{ background: color.dot }}></span>
                        {producto.category}
                    </span>
                    <span className={`text-[10px] font-semibold uppercase tracking-wider ${
                        agotado ? 'text-red-500' : pocoStock ? 'text-yellow-400' : 'text-green-400'
                    }`}>
                        {agotado ? '✕ Sin stock' : pocoStock ? `⚡ Solo ${producto.stock}` : `✓ Disponible`}
                    </span>
                </div>

                {/* Nombre y descripción */}
                <div className="flex-grow">
                    <h3 className="text-lg font-extrabold leading-tight mb-1">
                        {producto.name}
                    </h3>
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
                        onClick={(e) => {
                            e.stopPropagation();
                            handleCarrito();
                        }}
                        disabled={agotado}
                        className={`flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 ${
                            agotado
                                ? 'bg-neutral-800 text-neutral-600 cursor-not-allowed'
                                : añadido
                                    ? 'bg-green-700 text-white scale-95'
                                    : 'bg-[#3A6B35] text-[#E0D7B6] hover:bg-[#E0D7B6] hover:text-[#1a3a1a] hover:scale-105'
                        }`}
                    >
                        <i className={`bi ${añadido ? 'bi-check-lg' : agotado ? 'bi-bag-x' : 'bi-bag-plus'}`}></i>
                        {añadido ? '¡Listo!' : agotado ? 'No disp.' : 'Añadir'}
                    </button>
                </div>
            </div>
        </div>
    );
};

export default ShopCard;