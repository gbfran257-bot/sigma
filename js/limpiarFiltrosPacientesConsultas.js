/**
 * Función que maneja el clic en los input de filtrado para limpiar los filtros no aplicados
 * @param { HTMLElement } input
 */
const clickHandlerLimpiarFiltros = (input) => {
    if (input.getAttribute("id") === "top-search") {
        let pagina = window.location.href === "http://localhost/sigmacruzroja/pacientes.php" ? "pacientes" : "consultas";
        return pagina === 'pacientes' ? limpiarFiltrosPacientes() : limpiarFiltrosConsultas();
    }
    return limpiarBarraBusqueda();
};

/**
 * Función que limpia el value del input de la barra de búsqueda
 * @param { string }
 */
const limpiarBarraBusqueda = () => {
    $("#top-search").val("");
    $("#top-search").keyup();
}

/**
 * Función que limpia los campos de filtrado de la página de pacientes
 * @returns { void }
 */
const limpiarFiltrosPacientes = () => {
    $("#input-folio").val("");
    $("#input-nombre").val("");
    $("#input-apaterno").val("");
    $("#input-amaterno").val("");
    $("#input-edad").val("");
    $("#input-sexo").val("");
    $("#input-telefono").val("");
    $("#input-convenio").val("");
    $("#btn-buscar").click();
    return;
};

/**
 * Función que limpia los capos de filtrado de la página de consultas
 * @returns { void }
 */
const limpiarFiltrosConsultas = () => {
    $("#input-c-referencia").val("");
    $("#input-c-paciente").val("");
    $("#input-c-motivo").val("");
    $("#input-c-edad").val("");
    $("#input-c-sexo").val("");
    $("#input-c-medico").val("");
    $("#input-c-especialidad").val("");
    $("#input-c-convenio").val("");
    $("#input-c-estatus").val("");
    $("#btn-buscar-c").click();
    return;
};
