const imprimirMembrete = async (urlE, urlP) => {
    try {
        await swal({
            type: "success",
            title: "¡Hecho!",
            text: "El membrete se descargará en breve.",
        });

        // Creamos las imagenes para el encabezado y el pie de página
        const encabezado = new Image();
        const piePagina = new Image();

        // Definimos el url de las imagenes previamente creadas
        encabezado.src = urlE;
        piePagina.src = urlP;

        // Creamos el archivo pdf de la nota medica
        const notaMedica = new jsPDF();

        // Agregamos las imagenes al pdf previamente creado
        notaMedica.addImage(encabezado, "PNG", 5, 0, 200, 30);
        notaMedica.addImage(piePagina, "PNG", 10, 275, 180, 18);

        // Descargamos la nota emdica
        notaMedica.save("nota_medica.pdf");
    } catch (error) {
        return swal({
            type: "error",
            title: "¡Ocurrió un error!",
            text: "Vuelve a intentar descargar el membrete.",
        });
    }
};
