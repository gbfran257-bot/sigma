/**
 *
 * @param { string } urlE
 * @param { string } urlP
 * @param { string } tituloPDF
 * @returns
 */
const imprimirMembrete = async (urlE, urlP, tituloPDF) => {
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
        const membrete = new jsPDF();

        // Agregamos las imagenes al pdf previamente creado
        membrete.addImage(encabezado, "PNG", 5, 0, 200, 30);
        membrete.addImage(piePagina, "PNG", 10, 275, 180, 18);

        // Descargamos la nota medica
        membrete.save(`${tituloPDF}.pdf`);
    } catch (error) {
        return swal({
            type: "error",
            title: "¡Ocurrió un error!",
            text: "Vuelve a intentar descargar el membrete.",
        });
    }
};
