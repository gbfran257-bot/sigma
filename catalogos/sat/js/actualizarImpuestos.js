/**
 * @param { HTMLElement[] } htmlImpuestos
 */
const actualizarImpuestos = async (htmlImpuestos) => {
    const impuestos = [];
    for (const impuesto of htmlImpuestos) {
        impuestos.push({
            id_impuesto_catalogo: impuesto.querySelector(
                "#id_impuesto_catalogo"
            ).value,
            id_tipo: impuesto.querySelector("#select_tipo").value,
            id_impuesto: impuesto.querySelector("#select_impuesto").value,
            id_factor: impuesto.querySelector("#select_factor").value,
            id_tasa_cuota: impuesto.querySelector("#select_tasa_cuota").value,
            monto_impuesto: impuesto.querySelector("#monto_impuesto").value,
        });
    }

    const bodyImpuestos = new FormData();
    bodyImpuestos.append("impuestos", JSON.stringify(impuestos));

    return await fetch(
        "catalogos/sat/files-serverside/actualizarImpuestos.php",
        {
            method: "POST",
            body: bodyImpuestos,
        }
    )
        .then((response) => true)
        .catch((error) => {
            swal({
                title: "Ocurrió un error al actualizar los impuestos",
                text: error,
                type: "error",
            });
            return false;
        });
};
