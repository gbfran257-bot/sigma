/**
 * Se verifican todos los antagonismos al momento de querer agregar un medicamento a una receta
 * @param { number } idMedicamento id del medicamento que se quiere agregar
 * @return { Promise<number> }
 */
const verificarAntagonismos = async (idMedicamento, { idC, idU, idP }) => {
    // Caso 3: Se verifica si hay medicamentos agregados a la receta
    if (tablaVacia()) {
        return new Promise((resolve, reject) => resolve(1));
    }

    // Caso 4: Se obtiene el nombre del medicamento que se quiere agregar
    const nombreMedicamento = await getAtributoMedicamento("concepto_to", idMedicamento).catch(error => {
        throw error;
    });

    // Caso 5: Se obtienen los antagonismos del medicamento que se quiere agregar
    const antagonismos = await getAntagonismosMedicamento(idMedicamento).catch(error => {
        throw error;
    });

    const medicamentosSeleccionados = $("#dataTableMS tbody tr").map((index, element) => {
        return element.querySelectorAll("td")[1].querySelector("div span").textContent;
    });

    // Caso 6: Verificas si el medicamento que se quiere agregar tiene antagonismos
    let eliminarPrimerReporte = false;
    let setTimeOutTimer = 100;
    if (antagonismos.length !== 0) {
        const medicamentosAntagonistas = verificarAntagonismosMedicamentoSeleccionado(antagonismos, medicamentosSeleccionados);
        if (medicamentosAntagonistas) {
            setTimeOutTimer = 2000;
            await mostrarAlertaDeConfirmacion(`${nombreMedicamento} tiene antagonismo con ${medicamentosAntagonistas}`)
                .then((confirmacion) => {
                    if (!confirmacion) {
                        throw new Error("No se pudo agregar el medicamento.");
                    }
                    // Realizamos el reporte de la decisión tomada por el usuario
                    registrarReporteConsultaAntagonismo(idC, idU)
                    .then(respuesta => {
                        if (respuesta.ERROR) {
                            throw new Error(respuesta.ERROR);
                        }
                        eliminarPrimerReporte = true;
                        return swal({
                            icon: "success",
                            title: "¡Hecho!",
                            text: respuesta.EXITO,
                            buttons: false,
                            timer: 1800
                        });
                    })
                    .catch(error => {
                        throw error;
                    });
                })
                .catch(error => {
                    throw error;
                });
        }
    }

    // Obtienes los antagonismos de los medicamentos en la tabla de medicamentos seleccionado
    const antagonismosMedicamentosSeleccionados = $("#dataTableMS tbody tr").map((index, element) => {
        return $($(element).children("td")[3]).children(".p_antagonismo").map((index, element) => {
            return element.textContent;
        });
    });

    const medicamentosAgregados = [];
    for (let i = 0; i < medicamentosSeleccionados.length; i++) {
        medicamentosAgregados.push({
            nombre: medicamentosSeleccionados[i],
            antagonismos: antagonismosMedicamentosSeleccionados[i]
        });
    }

    const verificacion = verificarAntagonismosMedicamentosAgregados(medicamentosAgregados, nombreMedicamento);
    if (!verificacion) {
        return new Promise((resolve, reject) => resolve(1));
    }

    setTimeout(async () => {
        try {
            await mostrarAlertaDeConfirmacion(`${verificacion} tienen antagonismo con ${nombreMedicamento}`)
                .then((confirmacion) => {
                    if (!confirmacion) {
                        throw new Error("No se pudo agregar el medicamento.");
                    }
                    subirMED(idMedicamento, idC, idU, idP);
                })
                .catch(error => {
                    throw error;
                });
            
                // Realizamos el reporte de la decisión tomada por el usuario
            await registrarReporteConsultaAntagonismo(idC, idU)
                .then(respuesta => {
                    if (respuesta.ERROR) {
                        throw new Error(respuesta.ERROR);
                    }
                    swal({
                        icon: "success",
                        title: "¡Hecho!",
                        text: respuesta.EXITO,
                        buttons: false,
                        timer: 1800,
                    });
                })
                .catch(error => {
                    throw error;
                });
        } catch (error) {
            if (eliminarPrimerReporte) {
                await eliminarUltimoReporte();
            }
            swal({
                icon: "error",
                title: "¡Ocurrió un error!",
                text: error.message,
            });
        }
    }, setTimeOutTimer);
};

/**
 * Comprueba el medicamento que se quiere agregar se encuentra como antagonista de uno ya agregado
 * @param { Object[] } msa medicamentos ya agredados
 * @param { string } m medicamento que se quiere agregar
 * @returns { string | false }
 */
const verificarAntagonismosMedicamentosAgregados = (msa, m) => {
    let medicamentosAntagonistas = "";
    msa.forEach((ma) => {
        for (let i = 0; i < ma.antagonismos.length; i++) {
            if (m === ma.antagonismos[i]) {
                medicamentosAntagonistas += `${ma.nombre}, `
            }
        }
    });
    return medicamentosAntagonistas || false;
};

/**
 * Comprueba si entre los medicamentos ya seleccionados hay antagonismos del medicamento que se quiere agregar
 * @param { string[] } antagonismos 
 * @param { string[] } medicamentosSeleccionados 
 * @returns { string | false } medicamentos seleccionados que son antagonistas del medicamento que se quiere agregar
 */
const verificarAntagonismosMedicamentoSeleccionado = (antagonismos, medicamentosSeleccionados) => {
    let medicamentoAntagonicos = "";
    for (const i in antagonismos) {
        for (const j in medicamentosSeleccionados) {
            if (antagonismos[i] === medicamentosSeleccionados[j]) {
                medicamentoAntagonicos += `${medicamentosSeleccionados[j]}, `;
            }
        }
    }
    return medicamentoAntagonicos || false;
};

/**
 * Muestra una alerta para que el usuario pueda decidir si recetar el medicamento o no
 * @param { string } mensaje
 */
const mostrarAlertaDeConfirmacion = async (mensaje) => {
    const preguntaConfirmacion = document.createElement("strong");
    preguntaConfirmacion.textContent = "¿Deseas continuar?";
    return swal({
        icon: "warning",
        title: "¡Advertencia!",
        text: mensaje,
        content: preguntaConfirmacion,
        buttons: [
            {
                text: "Cancelar",
                visible: true,
            },
            {
                text: "Aceptar de todos modos",
            }
        ],
        dangerMode: true,
        closeOnEsc: false,
        closeOnClickOutside: false
    })
        .then(isConfirmed => {
            return isConfirmed;
        });
};

/**
 * Se verifica si la tabla de medicamentos seleccionados para un receta tiene o no medicamentos agregados
 * @returns { boolean }
 */
const tablaVacia = () => {
    return $("#dataTableMS tbody tr .dataTables_empty").length === 1;
};

/**
 * Consulta el atributo, pasado como parámetro, del medicamento cuyo id sea pasado como segundo parámetro
 * @param { string } atributo
 * @param { number } id
 */
const getAtributoMedicamento = (atributo, id) => {
    return new Promise((resolve, reject) => {
        try {
            fetch(`${URL_GET_ATRIBUTO_MEDICAMENTO}?id=${id}&atributo=${atributo}`, {
                method: "GET",
            })
                .then(response => response.json())
                .then(respuesta => {
                    if (respuesta.ERROR) {
                        throw new Error(respuesta.ERROR);
                    }
                    resolve(respuesta.ATRIBUTO);
                })
                .catch(error => {
                    reject(error);
                })
        } catch (error) {
            throw error;
        }
    });
};

/**
 * Consulta los nombres de los medicamentos que fueron registrados como antagonistas del medicamento cuyo id sea pasado como parámetro
 * @param { number } id 
 */
const getAntagonismosMedicamento = (id) => {
    return new Promise((resolve, reject) => {
        try {
            fetch(`${URL_GET_ANTAGONISMOS_MEDICAMENTO}?id=${id}`, {
                method: "GET",
            })
                .then(response => response.json())
                .then(respuesta => {
                    if (respuesta.ERROR) {
                        throw new Error(respuesta.ERROR);
                    }
                    resolve(respuesta.ANTAGONISMOS);
                })
                .catch(error => reject(error));
        } catch (error) {
            throw error;
        }
    })
};

const URL_GET_ATRIBUTO_MEDICAMENTO = "consultas/js/files-serverside/getAtributoMedicamento.php";
const URL_GET_ANTAGONISMOS_MEDICAMENTO = "consultas/js/files-serverside/getAntagonismosMedicamento.php";
