import React, { useState, useEffect } from "react";

export default function TarjetaAnimal() {
    const [animal, setAnimal] = useState(null);
    const [cargando, setCargando] = useState(true);

    // Funcion que utiliza una API para traducir la información
    const traducirTexto = async (texto) => {
        if (!texto) return "";
        try {
            const res = await fetch(
                `https://api.mymemory.translated.net/get?q=${encodeURIComponent(texto)}&langpair=en|es`,
            );
            const datos = await res.json();
            return datos.responseData.translatedText;
        } catch (error) {
            return texto; // Si falla, devolvemos el original
        }
    };

    const traerAnimal = async () => {
        setCargando(true);
        const nombres = [
            "Lion",
            "Tiger",
            "Wolf",
            "Cheetah",
            "Elephant",
            "Eagle",
            "Goat",
            "Giraffe",
        ];
        const busqueda = nombres[Math.floor(Math.random() * nombres.length)];

        try {
            const resNinja = await fetch(`https://api.api-ninjas.com/v1/animals?name=${busqueda}`,{headers: {"X-Api-Key": "nb4rKI76iulLVjrHor9PlI19yDMUbtxMfrXjrKLG"}});

            const datosNinja = await resNinja.json();

            if (datosNinja && datosNinja.length > 0) {
                const info = datosNinja[0];

                // 1. Lanzamos las 3 traducciones al mismo tiempo para evitar bloqueos
                // Si una falla, devolvemos el texto original (|| info.name, etc.)
                const [nombreEs, curiosidadEs, ubicacionEs] = await Promise.all(
                    [
                        traducirTexto(info.name).catch(() => info.name),
                        traducirTexto(
                            info.characteristics?.slogan ||
                                "An amazing animal.",
                        ).catch(() => info.characteristics?.slogan),
                        traducirTexto(
                            info.locations?.[0] || "Natural habitat",
                        ).catch(() => info.locations?.[0]),
                    ],
                );

                // 2. PETICIÓN A UNSPLASH
                const resUnsplash = await fetch(
                    `https://api.unsplash.com/photos/random?query=${info.name}&client_id=mhX64xEPUCpHPLdj0saioXZ_bGQx2Esuw14IBV2MzUk`,
                );
                const datosFoto = await resUnsplash.json();
                const urlFinal =
                    datosFoto.urls?.regular ||
                    "https://via.placeholder.com/450";

                setAnimal({
                    species: nombreEs || info.name,
                    curiosity:
                        curiosidadEs ||
                        info.characteristics?.slogan ||
                        "Un animal increíble.",
                    location:
                        ubicacionEs || info.locations?.[0] || "Hábitat natural",
                    imagen: urlFinal,
                });
            }
        } catch (e) {
            console.error("Error en la carga, usando Plan B local...");
            // Tu Plan B de Laravel
            const resLar = await fetch(
                "http://127.0.0.1:8000/api/animal-aleatorio",
            );
            const dataLar = await resLar.json();

            setAnimal({
                species: dataLar.nombre,
                curiosity: dataLar.curiosidad,
                location: dataLar.location || "Zoo Logic",
                imagen: dataLar.imagen,
            });
        } finally {
            setCargando(false);
        }
    };

    useEffect(() => {
        traerAnimal();
    }, []);

    if (cargando)
        return (
            <div style={estilos.contenedorCarga}>Cargando curiosidad...</div>
        );

    if (!animal)
        return (
            <div
                style={{ color: "white", textAlign: "center", padding: "50px" }}
            >
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
                    <p style={estilos.curiosidad}> "{animal.curiosity}" </p>
                    <hr style={estilos.separador} />
                    <p style={estilos.ubicacion}>
                        <i className="bi bi-geo-alt-fill"></i> {animal.location}
                    </p>
                    <button onClick={traerAnimal} style={estilos.boton}>
                        ¿Sabías que...? (Ver otro)
                    </button>
                </div>
            </div>
        </div>
    );
}

const estilos = {
    contenedor: {
        padding: "50px 20px",
        display: "flex",
        justifyContent: "center",
        background: "transparent",
    },
    contenedorCarga: {
        color: "white",
        textAlign: "center",
        padding: "100px",
        fontSize: "1.2rem",
        fontStyle: "italic",
    },
    tarjeta: {
        backgroundColor: "rgba(30, 30, 30, 0.85)",
        borderRadius: "25px",
        backdropFilter: "blur(10px)",
        maxWidth: "450px",
        overflow: "hidden",
        boxShadow: "0 20px 40px rgba(0,0,0,0.6)",
        border: "1px solid rgba(255,255,255,0.1)",
    },
    imagen: {
        width: "100%",
        height: "280px",
        objectFit: "cover",
        display: "block",
    },
    info: {
        padding: "25px",
        textAlign: "center",
    },
    titulo: {
        color: "#d4c59f",
        fontFamily: "Parkzoo-Regular, sans-serif",
        fontSize: "2rem",
        marginBottom: "10px",
        textTransform: "capitalize",
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
