const getInfoPaciente = async () => {
    const idConsulta = parseInt($("#id_cons").val());
    const idPaciente = parseInt($("#idPaciente_c").val());

    const { referencia, id_usuario } = await fetch(URL_GET_REFERENCIA_CONSULTA + idConsulta, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta;
    })
    .catch(error => {
        throw error;
    });
    
    setReferenciaConsulta(referencia);

    const paciente = await fetch(URL_GET_INFO_PACIENTE + idPaciente, {
        method: "GET",
    })
    .then(response => response.json())
    .then(respuesta => {
        if (respuesta.error) {
            throw new Error(respuesta.error);
        }
        return respuesta;
    })
    .catch(error => {
        throw error;
    });

    setPacienteInfo(paciente);
};

const setReferenciaConsulta = referencia => $("#referencia_vc").text(referencia);

const setPacienteInfo = (paciente) => {
    console.log(paciente);
    $("#paciente_vc").text(paciente.nombre_completo_p);
    $("#f_nacimiento_vc").text(paciente.fNac_p.split(" ")[0]);
    $("#sexo_vc").text(paciente.sexo_p == 1 ? "FEMENINO" : "MASCULINO");
    
    const año = new Date().getFullYear();
    const edad = año - parseInt(paciente.fNac_p.split(" ")[0].split("-")[0]);
    $("#edad_vc").text(`${edad} años`);
};

const URL_GET_REFERENCIA_CONSULTA = "consultas/js/files-serverside/getReferenciaConsulta.php?id_c=";
const URL_GET_INFO_PACIENTE = "consultas/js/files-serverside/getInfoPaciente.php?id_p=";
