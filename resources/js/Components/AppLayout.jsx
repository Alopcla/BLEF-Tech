import React from "react";
import Navbar from "./Navbar";
import Footer from "./Footer";

const AppLayout = ({ children, showVideo = true }) => {
    return (
        <>
            {/* Reemplazo de la sección de Video de layouts/app.blade.php */}
            {showVideo && (
                <>
                    <video
                        autoPlay
                        muted
                        loop
                        playsInline
                        className="fixed w-full h-full object-cover -z-10"
                    >
                        <source src="/video.mp4" type="video/mp4" />
                    </video>
                    <div className="fixed inset-0 bg-black/50 -z-10"></div>
                </>
            )}

            {/* Componente Navbar real importado */}
            <Navbar />

            {/* Equivalente a @yield('content'). Añadimos pt-24 (padding top) para que el navbar fixed no tape el contenido */}
            <main className="flex-grow relative z-10 pt-24">{children}</main>

            {/* Componente Footer real importado */}
            <Footer />
        </>
    );
};

export default AppLayout;
