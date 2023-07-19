/**
 * Función que lanza el evento que permite el filtrado en la data table
 * @returns { void }
 */
const filtradoHandler = () => $("#btn-buscar").click();

/**
 * Función que comprueba si se presiona la tecla Enter para realizar el filtrado de la data table
 * @param { KeyboardEvent } e
 */
const enterFiltradoHandler = (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        filtradoHandler();
    }
};

/**
 * Función que agrega los event listeners para los filtros inferiores de la data table
 */
const setFiltradoHandler = () => {
    $("#input-folio").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-nombre").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-apaterno").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-amaterno").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-edad").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-sexo").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-tel").on("keydown", (e) => enterFiltradoHandler(e));
    $("#input-convenio").on("keydown", (e) => enterFiltradoHandler(e));
};

/**
 * Función que limpia la data table en caso de que nigún campo de filtrado tenga un valor
 */
const inputHandlerFiltrar = () => {
    if (filtrosVacios()) {
        $("#btn-buscar").click();
    }
};

/**
 * Función que verifica si los campos de filtrado están vacíos o no
 * @returns { boolean }
 */
const filtrosVacios = () => {
    return (
        $("#input-folio").val() === "" &&
        $("#input-nombre").val() === "" &&
        $("#input-apaterno").val() === "" &&
        $("#input-amaterno").val() === "" &&
        $("#input-edad").val() === "" &&
        $("#input-sexo").val() === "" &&
        $("#input-tel").val() === "" &&
        $("#input-convenio").val() === ""
    );
};
