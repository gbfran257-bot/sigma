const URL_IMPRIMIR_RECETA_MEDICA = "consultas/js/files-serverside/imprimirRecetaMedica.php?id_c=";

const imprimirRecetaMedica = () => {
    getMembrete(parseInt($("#id_cons").val()), tiposMembrete.receta)
    .then(data => {
        const piePagina = new Image();
        piePagina.id = "pie_de_pagina_membrete";
        piePagina.src = data.url_pie_pagina;
        piePagina.alt = "pie_de_pagina_membrete";

        const indicaciones = $("#indicaciones").val().split("\n").filter(texto => texto !== "");
        $("#indicaciones").hide();
        let p_indicaciones = `<p id="p_indicaciones" style="max-width: 600.1px; margin: 0px; font-size: 1.5rem;">`;
        indicaciones.forEach((indicaciones, index) => {
            p_indicaciones += indicaciones;
            if (index !== p_indicaciones.length - 1) {
                p_indicaciones += "<br><br>"
            }
        });
        p_indicaciones += "</p>";
        $("#receta_indicaciones").append(p_indicaciones);

        // Obtenemos el div que contiene la información de la receta médica
        const recetaHTML = $("#receta_medica").html();

        // Creamos el archivo pdf
        const recetaPDF = html2pdf();

        // Agregamos el elemento html de la receta en el archivo pdf
        recetaPDF.from(recetaHTML).toContainer().toCanvas().toImg().toPdf().get("pdf").then((pdf) => {
            pdf.addImage(piePagina, "PNG", 10, 270, 188, 20);
        }).save("receta_medica.pdf");

        $("#indicaciones").show();
        $("#p_indicaciones").remove();
    })
    .catch(error => {
        return swal("¡ERROR!", error.message, "error");
    });
};
