import React from 'react';

const AnimalCard = ({ animal }) => {
    // Imagen por defecto profesional por si falta en la BD
    const imageUrl = animal.image || 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=500';

    return (
        <div className="group bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden transform transition duration-300 hover:-translate-y-1 hover:shadow-xl">

            {/* Contenedor de Imagen con efecto zoom en hover */}
            <div className="h-52 w-full overflow-hidden bg-gray-100">
                <img
                    src={imageUrl}
                    alt={animal.common_name}
                    className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                />
            </div>

            {/* Contenido de la Tarjeta */}
            <div className="p-6">
                {/* Título y Especie */}
                <div className="flex items-baseline gap-2 mb-2">
                    <h3 className="text-2xl font-extrabold text-gray-950">
                        {animal.common_name}
                    </h3>
                    <p className="text-xs text-gray-400 font-mono italic">
                        {animal.species}
                    </p>
                </div>

                {/* Tags de clasificación modernos */}
                <div className="flex flex-wrap gap-2 mb-4">
                    {/* Dieta (Verde) */}
                    <span className="px-2.5 py-1 bg-green-50 text-green-700 text-[10px] font-bold uppercase rounded-full tracking-wider">
                        {animal.diet}
                    </span>
                    {/* Ecosistema (Azul) */}
                    <span className="px-2.5 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold uppercase rounded-full tracking-wider">
                        {animal.zone?.ecosystem?.name}
                    </span>
                    {/* Zona (Naranja) */}
                    <span className="px-2.5 py-1 bg-orange-50 text-orange-700 text-[10px] font-bold uppercase rounded-full tracking-wider">
                        {animal.zone?.name}
                    </span>
                </div>

                {/* Separador sutil */}
                <hr className="border-gray-100 my-4" />

                {/* Curiosidad con limitador de líneas profesional */}
                <p className="text-gray-700 text-sm leading-relaxed line-clamp-3">
                    {animal.curiosity}
                </p>
            </div>
        </div>
    );
};

export default AnimalCard;
