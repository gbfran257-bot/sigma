/**
 * Función que lanza el evento que permite el filtrado en la data table de la página de consultas
 * @returns { void }
 */
const filtradoConsultasHandler = () => $("#btn-buscar-c").click();

/**
 * Función que lanza el evento que permite el filtrado en la data table de la página de pacientes
 * @returns { void }
 */
const filtradoPacientesHandler = () => $("#btn-buscar").click();

/**
 * Función que comprueba si se presiona la tecla Enter para realizar el filtrado de la data table
 * @param { KeyboardEvent } e
 */
const enterFiltradoHandler = (e, pagina) => {
    if (e.key === "Enter") {
        e.preventDefault();
        pagina === 'pacientes' ? filtradoPacientesHandler() : filtradoConsultasHandler();
    }
};

/**
 * Función que agrega los event listeners para los filtros inferiores de la data table de pacientes
 */
const setFiltradoPacientesHandler = () => {
    $("#input-folio").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-nombre").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-apaterno").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-amaterno").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-edad").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-sexo").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-tel").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
    $("#input-convenio").on("keydown", (e) => enterFiltradoHandler(e, 'pacientes'));
};

const setFiltradoConsultasHandler = () => { }

/**
 * Función que limpia la data table en caso de que nigún campo de filtrado tenga un valor
 */
const inputHandlerFiltrar = () => {
    let pagina = window.location.href === 'http://localhost/sigmacruzroja/pacientes.php' ? 'pacientes' : 'consultas';
    if (pagina === 'pacientes') {
        if (filtrosVaciosPacientes()) {
            return $('#btn-buscar').click();
        }
    }
    if (pagina === 'consultas') {
        if (filtrosVaciosConsultas()) {
            $("#btn-buscar-c").click();
        }
    }
};

/**
 * Función que verifica si los campos de filtrado están vacíos o no en la página de pacientes
 * @returns { boolean }
 */
const filtrosVaciosPacientes = () => {
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

/**
 * Función que verifica si los campos de filtrado están vacíos o no en la página de consultas
 * @returns { boolean }
 */
const filtrosVaciosConsultas = () => { };