import React, { useState, useEffect } from 'react';
import AnimalCard from './AnimalCard'; // Asegúrate de que la ruta sea correcta

const AnimalGallery = () => {
  // Aquí guardaremos la lista de animales que nos devuelva Laravel
  const [animales, setAnimales] = useState([]);
  // Un estado para saber si los datos están cargando
  const [cargando, setCargando] = useState(true);

  // useEffect se ejecuta automáticamente cuando el componente se muestra en pantalla
  useEffect(() => {
    // Hacemos la llamada a tu API de Laravel
    fetch('/api/animales')
      .then(response => response.json())
      .then(datos => {
        // Guardamos los datos en el estado (Recuerda que Laravel nos devuelve { status: 'success', data: [...] })
        setAnimales(datos.data);
        setCargando(false);
      })
      .catch(error => {
        console.error("Error al cargar los animales:", error);
        setCargando(false);
      });
  }, []); // Los corchetes vacíos significan que esto solo se ejecuta UNA vez al principio

  return (
    <div className="container mx-auto px-4 py-12">
      <h1 className="text-5xl font-extrabold text-center text-gray-950 mb-12">
        Nuestro Zoológico
      </h1>

      {/* Si está cargando... */}
      {cargando ? (
        <p className="text-center text-2xl text-gray-400 font-semibold animate-pulse">
          Trayendo a los animales desde el servidor...
        </p>
      ) : (
        /* SOLUCIÓN: Cuadrícula mejorada */
        /* Forzamos 2 columnas en móviles, 3 en tablets y 4 en escritorio grande */
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          {animales.map((animal) => (
            // Por cada animal, pintamos tu TarjetaAnimal (que ahora es AnimalCard)
            <AnimalCard key={animal.id} animal={animal} />
          ))}
        </div>
      )}
    </div>
  );
};

export default AnimalGallery;
