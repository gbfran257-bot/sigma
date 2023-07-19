/**
 * Función que maneja el clic en los input de filtrado para limpiar los filtros no aplicados
 * @param { HTMLElement } input
 */
const clickHandlerLimpiarFiltros = (input) => {
    if (input.getAttribute("id") === "top-search") {
        return limpiarFiltrosIndividuales();
    }
    return limpiarBarraBusqueda();
};

/**
 * Función que limpia el value del input de la barra de búsqueda
 */
const limpiarBarraBusqueda = () => $("#top-search").val("");

/**
 * Función que limpia el value de todos los input de filtrado individuales
 */
const limpiarFiltrosIndividuales = () => {
    $("#input-folio").val("");
    $("#input-nombre").val("");
    $("#input-apaterno").val("");
    $("#input-amaterno").val("");
    $("#input-edad").val("");
    $("#input-sexo").val("");
    $("#input-telefono").val("");
    $("#input-convenio").val("");
};
