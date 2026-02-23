import React, { useState, useEffect } from "react";

export default function TarjetaAnimal() {
    // Estados para guardar el animal y saber si esta cargando
    const [animal, setAnimal] = useState(null);
    const [cargando, setCargando] = useState(true);

    // Funcion para llamar a la API Manual creada en Laravel
    const traerAnimal = async () => {
        setCargando(true);

        try {
            // Llamamos a la ruta que creamos en api.php (la que creamos mediante el comando)
            const respuesta = await fetch("http://127.0.0.1:8000/api/animal-aleatorio");
            const datos = await respuesta.json();

            setAnimal(datos);

        } catch (error) {
            console.error("Error al obtener el animal: ", error);
        } finally {
            setCargando(false);
        }
    };

    // Ejecutar la funcion nada mas cargar el componente
    useEffect(() => {
        traerAnimal();
    }, []);

    // Interfaz de carga
    if (cargando)
        return (
            <div style={{ color: "white", textAlign: "center" }}>
                Cargando curiosidad...
            </div>
        );

    // Si no hay animal (error), mostrar mensaje
    if (!animal)
        return (
            <div style={{ color: "white" }}>
                No se pudo cargar la informacion
            </div>
        );

    return (
        <div style={estilos.contenedor}>
            <div style={estilos.tarjeta}>
                <img
                    src={animal.imagen}
                    alt={animal.species}
                    style={estilos.imagen}
                />

                <div style={estilos.info}>
                    <h2 style={estilos.titulo}> {animal.species} </h2>
                    <p style={estilos.curiosidad}> {animal.curiosity} </p>
                    <hr style={estilos.separador} />
                    <p style={estilos.ubicacion}>
                        <i className="bi bi-geo-alt-fill"></i>
                        {animal.location || "Hábitat natural"}
                    </p>
                    <button onClick={traerAnimal} style={estilos.boton}>
                        ¿Sabías que...? (Ver otro)
                    </button>
                </div>
            </div>
        </div>
    );
}

// Estilos integrados
const estilos = {
    contenedor: {
        padding: "50px 20px",
        display: "flex",
        justifyContent: "center",
         // Para que se vea el video de fondo
    },
    tarjeta: {
        backgroundColor: "rgba(51, 51, 51, 0.9)", // Gris oscuro con transparencia
        borderRadius: "25px",
        maxWidth: "450px",
        overflow: "hidden",
        boxShadow: "0 15px 35px rgba(0,0,0,0.5)",
        border: "1px solid #4a4a4a",
    },
    imagen: {
        width: "100%",
        height: "250px",
        objectFit: "cover",
    },
    info: {
        padding: "25px",
        textAlign: "center",
    },
    titulo: {
        color: "#d4c59f", // Color arena de tu botón de inicio de sesión
        fontFamily: "Parkzoo-Regular, sans-serif",
        fontSize: "2rem",
        marginBottom: "10px",
    },
    curiosidad: {
        color: "#f0f0f0",
        fontStyle: "italic",
        fontSize: "1.1rem",
        lineHeight: "1.5",
    },
    separador: {
        border: "0.5px solid #4a4a4a",
        margin: "20px 0",
    },
    ubicacion: {
        color: "#aaa",
        fontSize: "0.9rem",
        marginBottom: "20px",
    },
    boton: {
        backgroundColor: "#d4c59f",
        color: "#333",
        border: "none",
        padding: "12px 25px",
        borderRadius: "30px",
        fontWeight: "bold",
        cursor: "pointer",
        transition: "0.3s",
    },
};
