const URL_IMPRIMIR_RECETA_MEDICA = "consultas/js/files-serverside/imprimirRecetaMedica.php?id_c=";

const imprimirRecetaMedica = () => {
    // Obtenemos el div que contiene la información de la receta médica
    const recetaHTML = $("#receta_medica").html();

    // Creamos el archivo pdf
    const recetaPDF = html2pdf();

    // Agregamos el elemento html de la receta en el archivo pdf
    recetaPDF.from(recetaHTML).toContainer().toCanvas().toImg().toPdf().save("receta_medica.pdf");
};
