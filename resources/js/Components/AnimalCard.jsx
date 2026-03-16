import React from 'react';

const AnimalCard = ({ animal }) => {
    // 1. Imágenes y Fechas dinámicas
    const nombreCodificado = encodeURIComponent(animal.common_name);
    const imagenPorDefecto = `https://ui-avatars.com/api/?name=${nombreCodificado}&size=500&background=222222&color=E0D7B6&font-size=0.1&bold=true`;
    const imageUrl = animal.image || imagenPorDefecto;

    const fechaNacimiento = animal.birth_date
        ? new Date(animal.birth_date).toLocaleDateString('es-ES', { year: 'numeric', month: 'long', day: 'numeric' })
        : 'Fecha desconocida';

    // 2. LA MAGIA DE LOS COLORES: Asignamos clases de Tailwind según el tipo de dieta
    const obtenerColorDieta = (dieta) => {
        if (!dieta) return 'bg-neutral-800 text-neutral-400 border-neutral-700';

        const dietaNormalizada = dieta.toLowerCase();

        if (dietaNormalizada.includes('carn')) { // Carnívoro: Rojo
            return 'bg-red-900/40 text-red-400 border-red-800/50';
        } else if (dietaNormalizada.includes('herb')) { // Herbívoro: Verde
            return 'bg-green-900/40 text-green-400 border-green-800/50';
        } else if (dietaNormalizada.includes('omn')) { // Omnívoro: Amarillo
            return 'bg-yellow-900/40 text-yellow-400 border-yellow-800/50';
        } else {
            return 'bg-neutral-800 text-neutral-400 border-neutral-700'; // Por defecto
        }
    };

    return (
        <div className="bg-[#171717] text-white rounded-[32px] overflow-hidden flex flex-col h-full border border-neutral-800 shadow-[0_20px_40px_rgba(0,0,0,0.8)] transition-transform duration-300 hover:-translate-y-2">

            {/* Imagen superior */}
            <div className="w-full h-56 bg-neutral-900 relative">
                <img
                    src={imageUrl}
                    alt={animal.common_name}
                    onError={(e) => { e.target.onerror = null; e.target.src = imagenPorDefecto; }}
                    className="w-full h-full object-cover"
                />

                {/* Fecha */}
                <div className="absolute top-4 right-4 bg-black/70 backdrop-blur-md px-3 py-1.5 rounded-full text-xs font-semibold border border-white/10 flex items-center gap-2 shadow-lg">
                    <i className="bi bi-cake2"></i> {fechaNacimiento}
                </div>
            </div>

            {/* Contenido principal */}
            <div className="p-6 flex-grow flex flex-col text-center">
                <h3 className="text-3xl font-extrabold tracking-tight mb-1">
                    {animal.common_name}
                </h3>
                <p className="text-sm italic text-neutral-400 mb-4">
                    {animal.species}
                </p>

                {/* ETIQUETAS CON COLORES DINÁMICOS */}
                <div className="inline-flex flex-wrap justify-center items-center gap-2 text-[10px] font-bold uppercase tracking-wider mb-4">
                    {/* Llamamos a nuestra función para el color de la Dieta */}
                    <span className={`px-3 py-1.5 rounded-full border ${obtenerColorDieta(animal.diet)}`}>
                        {animal.diet}
                    </span>
                    {/* El ecosistema sigue azul por defecto */}
                    <span className="bg-blue-900/40 text-blue-400 px-3 py-1.5 rounded-full border border-blue-800/50">
                        {animal.zone?.ecosystem?.name || 'Sin ecosistema'}
                    </span>
                </div>

                <hr className="border-neutral-800 my-2 w-2/3 mx-auto" />

                {/* Curiosidad */}
                <p className="text-sm text-neutral-300 line-clamp-3 my-4 flex-grow italic">
                    "{animal.curiosity || 'Aún no hemos registrado ninguna curiosidad sobre este fascinante animal.'}"
                </p>

                {/* Zona inferior */}
                <div className="flex flex-col items-center gap-4 mt-auto">
                    <div className="flex items-center gap-2 text-neutral-500 text-[10px] uppercase tracking-widest font-bold">
                        <i className="bi bi-geo-alt-fill"></i>
                        <span>{animal.zone?.type || 'Zona sin asignar'} • Zoo Logic</span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default AnimalCard;
