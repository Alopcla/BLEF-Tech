import { defineConfig } from 'vite'; // Esta es la línea que te falta
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            // Asegúrate de que aquí ponga .jsx si ya renombraste el archivo
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
});
