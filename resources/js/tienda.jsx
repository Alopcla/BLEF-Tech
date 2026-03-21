import './bootstrap';
import React from 'react';
import { createRoot } from 'react-dom/client';
import ShopGallery from './Components/ShopGallery';

const container = document.getElementById('tienda-root');
if (container) {
    createRoot(container).render(<ShopGallery />);
}