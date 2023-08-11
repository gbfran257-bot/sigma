/**
 * Se consultan los medicamentos antagónicos de un medicamento seleccionado para ser agregado a la consulta
 * @param { number } idMedicamentoSeleccionado
 * @param { string[] } medicamentosYaSeleccionados
 */
const verificarAntagonismosMedicamentos = async (
    idMedicamentoSeleccionado,
    medicamentosYaSeleccionados
) => {
    if (medicamentosYaSeleccionados.length === 0) return;

    const medicamentoSeleccionado = await getMedicamentoComercialById(
        idMedicamentoSeleccionado
    ).then((data) => data);
    const antagonismos = await getAntagonismos(idMedicamentoSeleccionado).then(
        (data) => data
    );

    return new Promise((resolve, reject) => {
        // Comprobamos si el medicamento seleccionado ya se encuentra agregado
        medicamentosYaSeleccionados.forEach(medicamento => {
            if (medicamentoSeleccionado.concepto_to === medicamento) {
                resolve(true);
            }
        });

        // Comprobamos si el medicamento seleccionado tiene antagonismo con alguno de los medicamentos ya seleccionados
        antagonismos.forEach((antagonismo) => {
            medicamentosYaSeleccionados.forEach((medicamento) => {
                if (antagonismo === medicamento) {
                    reject({
                        medicamento: medicamentoSeleccionado.concepto_to,
                        antagonismo: medicamento,
                    });
                }
            });
        });
        resolve(true);
    });
};
