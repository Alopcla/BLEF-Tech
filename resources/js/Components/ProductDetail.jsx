import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { useCart } from './CartContext';
import '../../css/tiendadetalle.css';

const ProductDetail = () => {
    const { id }      = useParams();
    const navigate    = useNavigate();
    const { agregarAlCarrito, setCarritoAbierto, totalItems } = useCart();

    const [producto, setProducto]         = useState(null);
    const [selectedSize, setSelectedSize] = useState('');
    const [quantity, setQuantity]         = useState(1);
    const [isLoading, setIsLoading]       = useState(true);
    const [añadido, setAñadido]           = useState(false);
    const [favorito, setFavorito]         = useState(false);
    const [splineActivo, setSplineActivo] = useState(false);

    useEffect(() => {
        document.body.classList.add('producto-view');
        return () => document.body.classList.remove('producto-view');
    }, []);

    useEffect(() => {
        setIsLoading(true);
        setSplineActivo(false);
        fetch(`/api/products/${id}`)
            .then(r => r.json())
            .then(data => {
                setProducto(data.data);
                setIsLoading(false);
                // Recuperar favorito guardado localmente
                const favs = JSON.parse(localStorage.getItem('blrzoo_favs') || '[]');
                setFavorito(favs.includes(data.data.id));
            })
            .catch(() => setIsLoading(false));
    }, [id]);

    const handleCarrito = () => {
        if (!producto || producto.stock <= 0) return;
        // Añadir tantas veces como quantity indica
        for (let i = 0; i < quantity; i++) {
            agregarAlCarrito(producto);
        }
        setAñadido(true);
        setTimeout(() => setAñadido(false), 2000);
    };

    const handleFavorito = () => {
        const favs = JSON.parse(localStorage.getItem('blrzoo_favs') || '[]');
        let nuevos;
        if (favorito) {
            nuevos = favs.filter(f => f !== producto.id);
        } else {
            nuevos = [...favs, producto.id];
        }
        localStorage.setItem('blrzoo_favs', JSON.stringify(nuevos));
        setFavorito(!favorito);
    };

    if (isLoading) {
        return <div className="pd-center"><div className="pd-spinner" /></div>;
    }

    if (!producto) {
        return (
            <div className="pd-center">
                <div className="pd-error">
                    <h2>Producto no encontrado</h2>
                    <button className="pd-btn-primary" onClick={() => navigate('/tienda')}>Volver a la tienda</button>
                </div>
            </div>
        );
    }

    const hasSizes  = producto.sizes?.length > 0;
    const hasSpline = producto.spline_url;
    const agotado   = producto.stock <= 0;

    return (
        <div className="pd-wrapper">
            <div className="pd-container">

                {/* Volver + botón carrito flotante */}
                <div className="flex items-center justify-between mb-6">
                    <button className="pd-btn-back" onClick={() => navigate('/tienda')}>← Volver</button>
                    <button
                        onClick={() => setCarritoAbierto(true)}
                        className="relative flex items-center gap-2 bg-[#386641] hover:bg-[#2d5229] text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors"
                    >
                        <i className="bi bi-cart3 text-lg" />
                        Ver carrito
                        {totalItems > 0 && (
                            <span className="absolute -top-2 -right-2 bg-[#D9C8A1] text-[#0f1f0f] text-xs font-extrabold rounded-full w-5 h-5 flex items-center justify-center">
                                {totalItems}
                            </span>
                        )}
                    </button>
                </div>

                {/* Grid */}
                <div className="pd-grid">

                    {/* Imagen / Spline */}
                    <div className="pd-image-col">
                        <div className={`relative w-full h-[500px] rounded-[30px] overflow-hidden ${hasSpline && splineActivo ? 'bg-transparent p-0 shadow-none' : 'bg-neutral-900 p-4 border border-neutral-800'}`}>
                            {hasSpline && splineActivo ? (
                                <>
                                    <spline-viewer key={producto.spline_url} url={`${producto.spline_url}?v=${Date.now()}`} />
                                    <button className="absolute top-4 right-4 z-10 bg-black/70 text-white px-4 py-2 rounded-xl backdrop-blur hover:bg-black" onClick={() => setSplineActivo(false)}>✕ Cerrar</button>
                                </>
                            ) : (
                                <>
                                    {producto.image
                                        ? <img src={producto.image} alt={producto.name} className="pd-image" />
                                        : <span className="pd-image-placeholder">Sin imagen</span>
                                    }
                                    {hasSpline && (
                                        <button className="pd-spline-toggle" onClick={() => setSplineActivo(true)}>
                                            <span className="pd-spline-icon">⬡</span> Visualizar 3D
                                        </button>
                                    )}
                                </>
                            )}
                        </div>
                    </div>

                    {/* Info */}
                    <div className="pd-info-col">
                        <span className="pd-badge">{producto.category || 'Producto'}</span>
                        <h1 className="pd-title">{producto.name}</h1>
                        <p className="pd-description">{producto.description}</p>

                        <div className="pd-price-box">
                            <span className="pd-price-label">Precio</span>
                            <span className="pd-price-value">{parseFloat(producto.price).toFixed(2)} €</span>
                        </div>

                        {hasSizes && (
                            <div>
                                <p className="pd-section-label">Talla</p>
                                <div className="pd-sizes">
                                    {producto.sizes.map(size => (
                                        <button key={size} className={`pd-size-btn${selectedSize === size ? ' active' : ''}`} onClick={() => setSelectedSize(size)}>{size}</button>
                                    ))}
                                </div>
                            </div>
                        )}

                        <div>
                            <p className="pd-section-label">Cantidad</p>
                            <div className="pd-qty-control">
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => Math.max(1, Number(q) - 1))}>−</button>
                                <input
                                    type="number" min="1" value={quantity}
                                    onChange={e => { const v = e.target.value; setQuantity(v === '' ? '' : Math.max(1, parseInt(v))); }}
                                    onBlur={() => { if (!quantity || quantity < 1) setQuantity(1); }}
                                    className="pd-qty-input"
                                />
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => Math.min(producto.stock, Number(q) + 1))}>+</button>
                            </div>
                        </div>

                        {/* Acciones */}
                        <div className="pd-actions">
                            <button
                                className={`pd-btn-add${añadido ? ' done' : ''} ${agotado ? 'opacity-50 cursor-not-allowed' : ''}`}
                                onClick={handleCarrito}
                                disabled={agotado}
                            >
                                {agotado ? '✕ Sin stock' : añadido ? '✓ Añadido al carrito' : '🛒 Agregar al carrito'}
                            </button>
                            {/* ← Corazón ahora funciona */}
                            <button
                                className="pd-btn-wish"
                                onClick={handleFavorito}
                                title={favorito ? 'Quitar de favoritos' : 'Añadir a favoritos'}
                                style={{ color: favorito ? '#e53e3e' : undefined, borderColor: favorito ? '#e53e3e' : undefined }}
                            >
                                {favorito ? '♥' : '♡'}
                            </button>
                        </div>

                        <div className="pd-info-cards">
                            <div className="pd-info-card">
                                <div className="icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <rect x="1" y="3" width="15" height="13"></rect>
                                        <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                        <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                        <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                    </svg>
                                </div>
                                <div>
                                    <p className="pd-info-title">Envío a domicilio</p>
                                    <p className="pd-info-text">Recíbelo en tu casa en 48/72h</p>
                                </div>
                            </div>
                            <div className="pd-info-card">
                                <div className="icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p className="pd-info-title">Compra con impacto</p>
                                    <p className="pd-info-text">El 100% de los beneficios apoyan al Zoo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ProductDetail;