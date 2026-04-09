import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import '../../css/tiendadetalle.css';

const ProductDetail = () => {
    const { id }      = useParams();
    const navigate    = useNavigate();
    const [producto, setProducto]         = useState(null);
    const [selectedSize, setSelectedSize] = useState('');
    const [quantity, setQuantity]         = useState(1);
    const [isLoading, setIsLoading]       = useState(true);
    const [añadido, setAñadido]           = useState(false);
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
            .then(data => { setProducto(data.data); setIsLoading(false); })
            .catch(() => setIsLoading(false));
    }, [id]);

    const handleCarrito = () => {
        setAñadido(true);
        setTimeout(() => setAñadido(false), 2000);
    };

    if (isLoading) {
        return (
            <div className="pd-center">
                <div className="pd-spinner" />
            </div>
        );
    }

    if (!producto) {
        return (
            <div className="pd-center">
                <div className="pd-error">
                    <h2>Producto no encontrado</h2>
                    <button className="pd-btn-primary" onClick={() => navigate('/tienda')}>
                        Volver a la tienda
                    </button>
                </div>
            </div>
        );
    }

    const hasSizes  = producto.sizes?.length > 0;
    const hasSpline = producto.spline_url;

    return (
        <div className="pd-wrapper">
            <div className="pd-container">

                {/* Volver */}
                <button className="pd-btn-back" onClick={() => navigate('/tienda')}>
                    ← Volver
                </button>

                {/* Grid */}
                <div className="pd-grid">

                    {/* Imagen / Spline */}
                    <div className="pd-image-col">
                        <div className={`relative w-full h-[500px] rounded-[30px] overflow-hidden ${hasSpline && splineActivo ? 'bg-transparent p-0 shadow-none' 
                                : 'bg-neutral-900 p-4 border border-neutral-800'}
                            `}>

                            {/* Vista Spline activa */}
                            {hasSpline && splineActivo ? (
                                    <>
                                    <spline-viewer
                                        key={producto.spline_url}
                                        url={`${producto.spline_url}?v=${Date.now()}`}
                                    />

                                        <button
                                            className="absolute top-4 right-4 z-10 bg-black/70 text-white px-4 py-2 rounded-xl backdrop-blur hover:bg-black"
                                            onClick={() => setSplineActivo(false)}
                                        >
                                            ✕ Cerrar
                                        </button>
                                    </>
                                ) : (
                                <>
                                    {producto.image
                                        ? <img src={producto.image} alt={producto.name} className="pd-image" />
                                        : <span className="pd-image-placeholder">Sin imagen</span>
                                    }
                                    {/* Botón 3D solo si el producto tiene Spline */}
                                    {hasSpline && (
                                        <button
                                            className="pd-spline-toggle"
                                            onClick={() => setSplineActivo(true)}
                                        >
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

                        {/* Precio */}
                        <div className="pd-price-box">
                            <span className="pd-price-label">Precio</span>
                            <span className="pd-price-value">{parseFloat(producto.price).toFixed(2)} €</span>
                        </div>

                        {/* Tallas */}
                        {hasSizes && (
                            <div>
                                <p className="pd-section-label">Talla</p>
                                <div className="pd-sizes">
                                    {producto.sizes.map(size => (
                                        <button
                                            key={size}
                                            className={`pd-size-btn${selectedSize === size ? ' active' : ''}`}
                                            onClick={() => setSelectedSize(size)}
                                        >
                                            {size}
                                        </button>
                                    ))}
                                </div>
                            </div>
                        )}

                        {/* Cantidad */}
                        <div>
                            <p className="pd-section-label">Cantidad</p>
                            <div className="pd-qty-control">
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => Math.max(1, Number(q) - 1))}>−</button>
                                <input
                                    type="number"
                                    min="1"
                                    value={quantity}
                                    onChange={e => {
                                        const val = e.target.value;
                                        if (val === '') {
                                            setQuantity('');
                                        } else {
                                            setQuantity(Math.max(1, parseInt(val)));
                                        }
                                    }}
                                    onBlur={() => {
                                        if (quantity === '' || quantity < 1) setQuantity(1);
                                    }}
                                    className="pd-qty-input"
                                />
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => Number(q) + 1)}>+</button>
                            </div>
                        </div>

                        {/* Acciones */}
                        <div className="pd-actions">
                            <button
                                className={`pd-btn-add${añadido ? ' done' : ''}`}
                                onClick={handleCarrito}
                            >
                                {añadido ? '✓ Añadido' : '🛒 Agregar al carrito'}
                            </button>
                            <button className="pd-btn-wish">♡</button>
                        </div>

                        {/* NUEVAS INFO CARDS (Sin emojis, con SVGs y mejor texto) */}
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