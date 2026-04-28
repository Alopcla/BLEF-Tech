import React, { createContext, useContext, useState } from 'react';

const CartContext = createContext(null);

export const CartProvider = ({ children }) => {
    const [carrito, setCarrito] = useState([]);
    const [carritoAbierto, setCarritoAbierto] = useState(false);

    const agregarAlCarrito = (producto) => {
        setCarrito(prev => {
            const existe = prev.find(i => i.id === producto.id);
            if (existe) return prev.map(i => i.id === producto.id ? { ...i, quantity: i.quantity + 1 } : i);
            return [...prev, { ...producto, quantity: 1 }];
        });
    };

    const cambiarCantidad = (id, delta) => {
        setCarrito(prev => prev.map(i => i.id === id ? { ...i, quantity: Math.max(1, i.quantity + delta) } : i));
    };

    const eliminarDelCarrito = (id) => setCarrito(prev => prev.filter(i => i.id !== id));

    const totalCarrito = carrito.reduce((s, i) => s + i.price * i.quantity, 0);
    const totalItems   = carrito.reduce((s, i) => s + i.quantity, 0);

    return (
        <CartContext.Provider value={{
            carrito, setCarrito,
            carritoAbierto, setCarritoAbierto,
            agregarAlCarrito, cambiarCantidad, eliminarDelCarrito,
            totalCarrito, totalItems,
        }}>
            {children}
        </CartContext.Provider>
    );
};

export const useCart = () => useContext(CartContext);