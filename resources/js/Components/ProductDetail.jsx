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
    const hasSpline = producto.id === 9;

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
                        <div className={`pd-image-box${hasSpline && splineActivo ? " spline-active" : ""}`}>

                            {/* Vista Spline activa */}
                            {hasSpline && splineActivo ? (
                                <>
                                    <spline-viewer
                                        url="https://prod.spline.design/EsYGvTc8LJHw2crp/scene.splinecode"
                                        className="pd-spline-viewer"
                                    />
                                    <button
                                        className="pd-spline-toggle active"
                                        onClick={() => setSplineActivo(false)}
                                    >
                                        ✕ Cerrar 3D
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
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => Math.max(1, q - 1))}>−</button>
                                <input
                                    type="number"
                                    min="1"
                                    value={quantity}
                                    onChange={e => setQuantity(Math.max(1, parseInt(e.target.value) || 1))}
                                    className="pd-qty-input"
                                />
                                <button className="pd-qty-btn" onClick={() => setQuantity(q => q + 1)}>+</button>
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

                        {/* Info cards */}
                        <div className="pd-info-cards">
                            <div className="pd-info-card">
                                <span className="icon">🚚</span>
                                <div>
                                    <p className="pd-info-title">Envío rápido</p>
                                    <p className="pd-info-text">Entrega en 2-3 días</p>
                                </div>
                            </div>
                            <div className="pd-info-card">
                                <span className="icon">♻️</span>
                                <div>
                                    <p className="pd-info-title">Sostenible</p>
                                    <p className="pd-info-text">Beneficia al zoo</p>
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