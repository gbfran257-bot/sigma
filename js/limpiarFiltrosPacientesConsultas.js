/**
 * Función que maneja el clic en los campos de búsqueda tanto de paientes como de consultas
 * @param { HTMLElement } input
 */
const clickHandlerLimpiarFiltros = () => limpiarBarraBusqueda();

/**
 * Función que limpia la barra de búsqueda y recarga la tabla con toda la información
 * @param { string }
 */
const limpiarBarraBusqueda = () => {
    $("#top-search").val("");
    $("#top-search").keyup();
}
