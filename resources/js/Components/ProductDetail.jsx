import React, { useEffect, useState } from 'react';
import { useParams, useNavigate } from 'react-router-dom';

const ProductDetail = () => {
    const { id } = useParams();
    const navigate = useNavigate();
    const [producto, setProducto] = useState(null);

    useEffect(() => {
        fetch(`/api/products/${id}`)
            .then(r => r.json())
            .then(data => setProducto(data.data));
    }, [id]);

    if (!producto) return <p className="text-white p-10">Cargando...</p>;

    return (
        <div className="fixed inset-0 z-0 bg-black">



            {producto.id == 9 && (
                <div className="fixed inset-0 z-0">
                    <spline-viewer url="https://prod.spline.design/EsYGvTc8LJHw2crp/scene.splinecode"></spline-viewer>
                </div>
            )}

            <div className="relative z-10 p-10">
                <button onClick={() => navigate('/tienda')}>
                    ← Volver
                </button>
                <h1 className="text-4xl font-bold">{producto.name}</h1>
                <p>{producto.description}</p>
                <p>{producto.price} €</p>
            </div>

        </div>
    );
};

export default ProductDetail;