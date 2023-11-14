const resumenTransferencias = async (referencia) => {
    const datosTransferencia = await getDatosTranferencia(referencia).catch((error) => console.error(error));
    
    $("#modal_resumen_transferencia").load(
        "transferencias/html/resumen_transferencia.php",
        datosTransferencia,
        (response, status, xhr) => {
            if (status !== "success") {
                console.error(response);
            }

            // Comportamiento del modal
            $("#modal_resumen_transferencia").modal("show");
            $("#modal_resumen_transferencia").on(
                "hidden.bs.modal",
                (e) => {
                    $(".modal-content").remove();
                    $("#modal_resumen_transferencia").empty();
                }
            );
        }
    );
};
