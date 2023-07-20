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
        pagina === "pacientes"
            ? filtradoPacientesHandler()
            : filtradoConsultasHandler();
    }
};

/**
 * Función que agrega los event listeners para los filtros inferiores de la data table de pacientes
 */
const setFiltradoPacientesHandler = () => {
    $("#input-folio").on("keydown", (e) =>
        enterFiltradoHandler(e, "pacientes")
    );
    $("#input-nombre").on("keydown", (e) =>
        enterFiltradoHandler(e, "pacientes")
    );
    $("#input-apaterno").on("keydown", (e) =>
        enterFiltradoHandler(e, "pacientes")
    );
    $("#input-amaterno").on("keydown", (e) =>
        enterFiltradoHandler(e, "pacientes")
    );
    $("#input-edad").on("keydown", (e) => enterFiltradoHandler(e, "pacientes"));
    $("#input-sexo").on("keydown", (e) => enterFiltradoHandler(e, "pacientes"));
    $("#input-tel").on("keydown", (e) => enterFiltradoHandler(e, "pacientes"));
    $("#input-convenio").on("keydown", (e) =>
        enterFiltradoHandler(e, "pacientes")
    );
};

const setFiltradoConsultasHandler = () => {
    $("#input-c-referencia").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-paciente").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-motivo").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-edad").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-sexo").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-medico").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-especialidad").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-convenio").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
    $("#input-c-estatus").on("keydown", (e) =>
        enterFiltradoHandler(e, "consultas")
    );
};

/**
 * Función que limpia la data table en caso de que nigún campo de filtrado tenga un valor
 */
const inputHandlerFiltrar = async () => {
    let pagina =
        window.location.href === "http://localhost/sigmacruzroja/pacientes.php"
            ? "pacientes"
            : "consultas";
    if (pagina === "pacientes") {
        if (filtrosVaciosPacientes()) {
            return $("#btn-buscar").click();
        }
    }
    if (pagina === "consultas") {
        if (filtrosVaciosConsultas()) {
            return $("#btn-buscar-c").click();
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
const filtrosVaciosConsultas = () => {
    return (
        $(
            "#input-c-referencia",
            $("#dataTablePrincipal").DataTable().column(1).footer()
        ).val() === "" &&
        $(
            "#input-c-paciente",
            $("#dataTablePrincipal").DataTable().column(2).footer()
        ).val() === "" &&
        $(
            "#input-c-motivo",
            $("#dataTablePrincipal").DataTable().column(3).footer()
        ).val() === "" &&
        $(
            "#input-c-edad",
            $("#dataTablePrincipal").DataTable().column(4).footer()
        ).val() === "" &&
        $(
            "#input-c-sexo",
            $("#dataTablePrincipal").DataTable().column(5).footer()
        ).val() === "" &&
        $(
            "#input-c-medico",
            $("#dataTablePrincipal").DataTable().column(6).footer()
        ).val() === "" &&
        $(
            "#input-c-especialidad",
            $("#dataTablePrincipal").DataTable().column(7).footer()
        ).val() === "" &&
        $(
            "#input-c-convenio",
            $("#dataTablePrincipal").DataTable().column(9).footer()
        ).val() === "" &&
        $(
            "#input-c-estatus",
            $("#dataTablePrincipal").DataTable().column(10).footer()
        ).val() === ""
    );
};
