/**
 * @param { HTMLElement[] } htmlImpuestos
 */
const insertarImpuestos = (htmlImpuestos) => {
    const impuestos = [];
    for (const impuesto of htmlImpuestos) {
        impuestos.push({
            tipo: impuesto.querySelector("#select_tipo").value,
            impuesto: impuesto.querySelector("#select_impuesto").value,
            factor: impuesto.querySelector("#select_factor").value,
            porcentajeFijo: impuesto.querySelector("#select_tasa_cuota").value,
            porcentajeLibre: impuesto.querySelector("#monto_impuesto").value,
        });
    }

    const body = new FormData();
    body.append("clave_sat", $("#clave").val());
    body.append("impuestosExtra", JSON.stringify(impuestos));
    
    fetch("catalogos/sat/files-serverside/addImpuestosExtra.php", {
        method: "post",
        body,
    })
        .then((response) => response.json())
        .then((data) => {
            swal({
                title: "Realizado",
                text: "La cuenta se ha actualizado correctamente",
                type: "success",
                timer: 1800,
                showConfirmButton: false,
            });
        })
        .catch((error) => {
            swal({
                title: "Ocurrió un error",
                text: error,
                type: "error",
                timer: 1800,
                showConfirmButton: false,
            });
        });
};
