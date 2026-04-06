import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import ShopGallery from './Components/ShopGallery';
import ProductDetail from './Components/ProductDetail';

const container = document.getElementById('tienda-root');

if (container) {
    createRoot(container).render(
        <BrowserRouter>
            <Routes>
                <Route path="/tienda" element={<ShopGallery />} />
                <Route path="/tienda/producto/:id" element={<ProductDetail />} />
            </Routes>
        </BrowserRouter>
    );
}